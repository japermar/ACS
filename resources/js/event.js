
document.body.addEventListener('htmx:configRequest', function (event) {
    event.detail.headers['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
});




document.addEventListener('DOMContentLoaded', function () {
    // Use document.querySelectorAll to select all buttons with the hx-post attribute
    const htmxButtons = document.querySelectorAll('sl-button[hx-post]');
    htmxButtons.forEach(button => {
        button.addEventListener('htmx:beforeRequest', function () {
            button.setAttribute('loading', '');
        });
        button.addEventListener('htmx:afterRequest', function () {
            button.removeAttribute('loading');
        });
    });
    const menu_items = document.querySelectorAll('sl-menu-item[hx-post]');
    menu_items.forEach(button => {
        button.addEventListener('htmx:beforeRequest', function () {
            console.log('before');
            const parent = document.getElementById('imagenes')
            parent.setAttribute('loading', '');
        });
        button.addEventListener('htmx:afterRequest', function () {
            const parent = document.getElementById('imagenes')
            console.log('after');
            parent.removeAttribute('loading');
        });
    });

});

