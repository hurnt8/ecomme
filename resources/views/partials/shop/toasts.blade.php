@if (session('toast'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            window.dispatchEvent(new CustomEvent('toast', {
                detail: @json(session('toast')),
            }));
        });
    </script>
@endif

<div
    x-data
    x-cloak
    style="position:fixed;top:20px;right:20px;z-index:2000;display:flex;flex-direction:column;gap:8px;"
>
    <template x-for="item in $store.toast.items" :key="item.id">
        <div
            x-show="true"
            x-transition
            :style="{
                background: item.type === 'error' ? '#d9534f' : '#d1c286',
                color: '#fff', padding: '12px 18px', borderRadius: '4px',
                boxShadow: '0 4px 12px rgba(0,0,0,.2)', minWidth: '240px', fontSize: '14px',
            }"
            x-text="item.message"
        ></div>
    </template>
</div>
