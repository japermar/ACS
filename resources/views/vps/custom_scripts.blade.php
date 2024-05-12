@extends('layouts.app')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/wc-bubble"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.15.0/cdn/themes/light.css"/>
    <script type="module"
            src="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.15.0/cdn/shoelace-autoloader.js"></script>
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .warning-tag {
            margin-bottom: 20px;
        }

        .command-input {
            margin-bottom: 20px;
        }

        .execute-button {
            margin-bottom: 20px;
        }

        #response {
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
        }

        #response pre {
            margin: 0;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: Consolas, monospace;
            font-size: 14px;
            line-height: 1.4;
            overflow-x: auto;
        }
    </style>
    @vite(['resources/sass/app.scss', 'resources/js/graph.js','resources/js/app.js', 'resources/js/htmx.js', 'resources/js/event.js'])

    <div class="container">
        <h1 class="title">Comandos por ssh</h1>
        <sl-tag variant="warning" class="warning-tag">Desde ACS no recomendamos usar la app ejecutando comandos, nuestra idea es usar la herramienta gráfica</sl-tag>
        <sl-input id="command-input" placeholder="Introduce tu comando" clearable class="command-input"></sl-input>
        <sl-button onclick="executeCustomScript()" variant="primary" class="execute-button">Ejecutar</sl-button>
        <div id="response"></div>
    </div>

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
                    document.getElementById('response').innerHTML = `<pre>${result}</pre>`;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Add an event listener to detect the Enter key press in the input
        document.getElementById('command-input').addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                executeCustomScript();
            }
        });
    </script>
@endsection
