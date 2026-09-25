import Alpine from 'alpinejs';

/**
 * Cart forms — add to cart, the cart page's quantity stepper, "Retirer" — are sent in the
 * background instead of reloading the page. Each stays an ordinary POST form with its own action,
 * so it still works without JS; only forms marked `data-cart-form` are intercepted.
 *
 * CartController answers with the item count (the header badges read $store.cart.count), an
 * optional toast, and the cart page's lines and summary re-rendered server-side, which replace
 * [data-cart-body] on the cart page.
 */

// Requests go one at a time, in order, so replies can't land out of sequence.
let queue = Promise.resolve();

// Requests queued or in flight.
let waiting = 0;

// Stepper changes still inside their pause (see cartQuantity).
let pendingEdits = 0;

document.addEventListener('alpine:init', () => {
    Alpine.store('cart', {
        count: Number(document.querySelector('[data-cart-count]')?.dataset.cartCount ?? 0),
    });

    /*
     * The cart page's -/+ stepper: the change is sent once the shopper pauses, so a run of clicks
     * becomes a single request (and a single re-render) rather than one per click.
     */
    Alpine.data('cartQuantity', (quantity, max) => ({
        quantity,
        max,
        timer: null,

        step(delta) {
            this.quantity = Math.min(this.max, Math.max(1, this.quantity + delta));
            this.save();
        },

        save() {
            if (this.timer === null) {
                pendingEdits += 1;
            }

            clearTimeout(this.timer);

            this.timer = setTimeout(() => {
                this.timer = null;
                pendingEdits -= 1;
                this.$root.requestSubmit();
            }, 350);
        },
    }));
});

document.addEventListener('submit', (event) => {
    const form = event.target;

    if (!(form instanceof HTMLFormElement) || !form.hasAttribute('data-cart-form')) {
        return;
    }

    event.preventDefault();

    const data = new FormData(form);
    const button = event.submitter ?? form.querySelector('[type="submit"]');

    waiting += 1;
    button?.setAttribute('disabled', '');
    document.querySelector('[data-cart-body]')?.classList.add('is-updating');

    queue = queue.then(() => send(form.action, data, button));
});

async function send(action, data, button) {
    let reply;

    try {
        ({ data: reply } = await window.axios.post(action, data, {
            headers: { Accept: 'application/json' },
        }));
    } catch (error) {
        reply = { ...(error.response?.data ?? {}), type: 'error' };
        reply.message ??= "Der Warenkorb konnte nicht aktualisiert werden. Bitte erneut versuchen.";
    }

    waiting -= 1;
    button?.removeAttribute('disabled');

    if (typeof reply.count === 'number') {
        Alpine.store('cart').count = reply.count;
    }

    const body = document.querySelector('[data-cart-body]');

    // Only the reply to the last change of a run re-renders the cart: an earlier one would briefly
    // put back a quantity the shopper has already changed again.
    if (body && waiting === 0 && pendingEdits === 0) {
        if (typeof reply.html === 'string') {
            body.innerHTML = reply.html;
        }

        body.classList.remove('is-updating');
    }

    if (reply.message) {
        Alpine.store('toast').push(reply.message, reply.type ?? 'success');
    }
}
