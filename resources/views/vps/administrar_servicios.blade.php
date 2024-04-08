<div class="details-group-example">

    @foreach($servicios as $servicio)
        <sl-details summary="{{ $servicio['repository'] }}" >

            <p><strong>ID de la Imagen:</strong> {{ $servicio['image_id'] }}</p>
            <p><strong>Version:</strong> {{ $servicio['tag'] }}</p>
            <p><strong>Creado el:</strong> {{ $servicio['created'] }}</p>
            <p><strong>Tamaño:</strong> {{ $servicio['size'] }}</p>
        </sl-details>
    @endforeach
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.querySelector('.details-group-example');

        // Close all other details when one is shown
        container.addEventListener('sl-show', event => {
            if (event.target.localName === 'sl-details') {
                [...container.querySelectorAll('sl-details')].forEach(details => {
                    if (details !== event.target) {
                        details.removeAttribute('open');
                    }
                });
            }
        });
    });
</script>

<style>
    .details-group-example sl-details:not(:last-of-type) {
        margin-bottom: var(--sl-spacing-2x-small);
    }
</style>
