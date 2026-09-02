import Alpine from 'alpinejs';

/**
 * Shared toast store: Blade can push a flash message on page load via
 * `window.dispatchEvent(new CustomEvent('toast', { detail: { message, type } }))`,
 * and any component can call `$store.toast.push(message, type)` from Alpine markup.
 */
document.addEventListener('alpine:init', () => {
    Alpine.store('toast', {
        items: [],

        push(message, type = 'success') {
            const id = Date.now() + Math.random();
            this.items.push({ id, message, type });
            setTimeout(() => this.remove(id), 4000);
        },

        remove(id) {
            this.items = this.items.filter((item) => item.id !== id);
        },
    });
});

window.addEventListener('toast', (event) => {
    Alpine.store('toast').push(event.detail.message, event.detail.type);
});
