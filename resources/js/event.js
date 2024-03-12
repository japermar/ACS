
document.body.addEventListener('htmx:configRequest', function (event) {
    event.detail.headers['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
});
document.body.addEventListener('htmx:beforeRequest', function (event) {
    document.getElementById('spinner').style.display = 'block';
});
document.body.addEventListener('htmx:afterRequest', function (event) {
    document.getElementById('spinner').style.display = 'none';
});
