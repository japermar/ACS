<script>
        const switchContainers = document.querySelectorAll('.switch-container');
        switchContainers.forEach(container => {
            const switchEl = container.querySelector('sl-switch');
            const labelEl = container.querySelector('.switch-label'); // Get the label/span for this switch
            switchEl.addEventListener('sl-change', event => {
                if (switchEl.checked) {
                    labelEl.textContent = 'Encender';
                } else {
                    labelEl.textContent = 'Apagar';
                }
            });
        });
</script>

<form hx-post="{{ route('encender_servicios', [$grupo_id, $vps_id]) }}" hx-target="#manejado_servicios"  id="servicesForm">
    @foreach($servicios as $servicio)
        <sl-card class="card-header">
            <div class="switch-container" slot="header">
                <sl-switch id="switch_{{ $loop->index }}" value="{{$servicio['repository']}}" onclick="updateSwitchValue(this)">
                <span class="switch-label">Apagar</span>
                    </sl-switch>
            </div>
            <input type="hidden" name="estado[{{$servicio['repository']}}]" id="estado_{{ $loop->index }}" value="off">
            <label>{{ $servicio['repository'] }}</label>
        </sl-card>
    @endforeach
        <input type="submit" value="Ejecutar cambios">
</form>
{{--        <button variant="neutral" outline>Submit</button>--}}

<div id="manejado_servicios"></div>


<script>
    function updateSwitchValue(switchElement) {
        var input = document.getElementById('estado_' + switchElement.id.split('_')[1]);
        console.log('switch element checked ? ', switchElement.checked);
        console.log(switchElement);


        input.value = switchElement.checked ? 'on' : 'off';
    }
</script>


