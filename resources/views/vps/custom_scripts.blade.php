@extends('layouts.app')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/wc-bubble"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.15.0/cdn/themes/light.css"/>
    <script type="module"
            src="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.15.0/cdn/shoelace-autoloader.js"></script>
    <style>
    </style>
    @vite(['resources/sass/app.scss', 'resources/js/graph.js','resources/js/app.js', 'resources/js/htmx.js', 'resources/js/event.js'])

    <p>hola soy tu custom script lol</p>
    <sl-tag variant="warning">Desde ACS no recomendamos usar la app ejecutando comandos, nuestra idea es usar la herramienta gráfica</sl-tag>
    <sl-input id="command-input" placeholder="Introduce tu comando" clearable></sl-input>
    <p>{{$vps_id}}</p>
    <sl-button onclick="executeCustomScript()" variant="neutral">Neutral</sl-button>
    <div id="response"></div>

    <script>
        function executeCustomScript() {
            var command = document.getElementById('command-input').value;
            var vpsId = {{ $vps_id }}; // Assuming $vps_id is defined in the server-side code
            var url = "{{ route('ejecutar_custom_script', ['vps_id' => ':vps_id']) }}".replace(':vps_id', vpsId);
            var data = {
                command: command,
                vps_id: vpsId
            };

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
                .then(response => response.text())
                .then(result => {
                    document.getElementById('response').innerHTML = result;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Añadir un evento para detectar la tecla Enter en el input
        document.getElementById('command-input').addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                executeCustomScript();
            }
        });
    </script>
@endsection
