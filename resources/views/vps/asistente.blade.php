@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.15.0/cdn/themes/light.css"/>
    <script type="module" src="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.15.0/cdn/shoelace-autoloader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite(['resources/sass/app.scss', 'resources/js/graph.js','resources/js/app.js', 'resources/js/htmx.js', 'resources/js/event.js'])
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    </head>
    <style>
        .ai-info {
            text-align: center;
        }

        .ai-header {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #333;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .ai-image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 2rem;
        }
        #columnOne {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .context-header {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #007bff;
        }

        .group-info,
        .server-info,
        .hardware-info {
            margin-bottom: 20px;
        }

        .group-info h4,
        .server-info h4,
        .hardware-info h4 {
            font-size: 1.2rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }

        .group-info p,
        .server-info p,
        .hardware-info p {
            font-size: 1rem;
            color: #333;
            margin-bottom: 5px;
        }

        .server-info strong,
        .hardware-info strong {
            font-weight: bold;
            color: #007bff;
        }
        .ai-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            width: 80%; /* Add this line to set the width of the image */
            max-height: 60vh; /* Add this line to limit the maximum height of the image */
            object-fit: contain; /* Add this line to ensure the image maintains its aspect ratio */
        }

        .ai-image:hover {
            transform: scale(1.05);
        }
        /* General container styles */
        #container {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Column styles */
        .column {
            flex: 1;
            padding: 20px;
            box-sizing: border-box;
            overflow-y: auto;
        }

        #columnOne {
            background-color: #f8f9fa;
        }

        #columnTwo {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        #columnThree {
            background-color: #f1f3f5;
        }

        /* Chat styles */
        .chat-container {
            width: 100%;
            max-width: 600px;
            margin-bottom: 20px;
        }

        .chat-response {
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .chat-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        #columnTwo {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .chat-container {
            width: 100%;
            max-width: 600px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .chat-header {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            text-align: center;
        }

        .chat-header h3 {
            margin: 0;
            font-size: 1.5rem;
        }

        .chat-body {
            padding: 20px;
            max-height: 400px;
            overflow-y: auto;
        }

        .chat-response {
            background-color: #f1f0f0;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .chat-footer {
            display: flex;
            align-items: center;
            padding: 10px;
            background-color: #f8f9fa;
        }

        .chat-input {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-right: 10px;
        }

        .chat-send-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .chat-send-button:hover {
            background-color: #0056b3;
        }

        /* AI information styles */
        .ai-info {
            text-align: center;
        }

        .ai-info img {
            max-width: 200px;
            margin-top: 20px;
        }
    </style>
    <script>
        async function enviarMensajeIA() {
            let mensajeIA = `Un usuario de mi aplicación para manejar servidores online tiene la siguiente duda:

"MENSAJE_USUARIO"

La aplicación permite a los usuarios administrar y configurar servidores web, bases de datos y servicios en la nube.

Por favor, proporciona una respuesta detallada y clara en español, siguiendo estos puntos:
1. Explica los conceptos relevantes de manera concisa y fácil de entender.
2. Ofrece instrucciones paso a paso para resolver el problema o responder a la pregunta.
3. Si es relevante, incluye ejemplos o fragmentos de código para ilustrar la solución.
4. Estructura tu respuesta utilizando viñetas o pasos numerados para una mejor legibilidad.

Recuerda adaptar tu respuesta al nivel de conocimiento técnico del usuario y proporcionar recomendaciones adicionales si es necesario.`;

            let chatElementRef = document.getElementById('chat');
            mensajeIA = mensajeIA.replace('MENSAJE_USUARIO', chatElementRef.value);
           // Send inner HTML to the API
            const request = {
                "url": "https://api.awanllm.com/v1/chat/completions",
                "method": "POST",
                "headers": {
                    "Authorization": "Bearer ad59f79f-6bc4-43bd-828a-67ca2c765a84",
                    "Content-Type": "application/json"
                },
                "body": JSON.stringify({
                    "model": "Meta-Llama-3-8B-Instruct",
                    "websocket": "true",
                    "messages": [
                        {
                            "role": "user",
                            "content": mensajeIA
                        }
                    ]
                })
            };
            try {
                const response = await fetch(request.url, {
                    method: request.method,
                    headers: request.headers,
                    body: request.body
                });
                if (response.ok) {
                    const data = await response.json();
                    let respuestaIA = document.getElementById('respuestaIA');
                    let aimessage = data.choices[0].message.content;
                    respuestaIA.innerHTML = aimessage;
                    chatElementRef.value = '';
                    // Handle the response data as needed
                } else {
                    console.error('Error:', response.status);
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
        document.addEventListener('DOMContentLoaded', () => {
            let chatElementRef = document.getElementById('chat');
            chatElementRef.addEventListener('focusout', async () => {
                await enviarMensajeIA();
            });
            chatElementRef.addEventListener('keydown', async (event) => {
                if (event.key === 'Enter') {
                    await enviarMensajeIA();
                }
            });
        });
    </script>
    <div id="container">
        <div id="columnOne" class="column">
            <h3 class="context-header">Contexto para mejorar tus preguntas a nuestra IA</h3>
            <div class="group-info">
                <h4>Nombre del grupo</h4>
                <p>{{$grupo->nombre_grupo}}</p>
            </div>
            <div class="server-info">
                <h4>Info del servidor</h4>
                <p><strong>Nombre:</strong> {{$vps->nombre_servidor}}</p>
                <p><strong>Dirección IP:</strong> {{$vps->direccion_ssh}}</p>
                <p><strong>Puerto SSH:</strong> {{$vps->puerto_ssh}}</p>
                <p><strong>Usuario SSH:</strong> {{$vps->usuario_ssh}}</p>
            </div>
            <div class="hardware-info">
                <h4>Hardware del servidor</h4>
                <p><strong>CPU:</strong> {{$hardware->cpu}}</p>
                <p><strong>RAM:</strong> {{$hardware->ram}}</p>
                <p><strong>Almacenamiento:</strong> {{$hardware->almacenamiento}}</p>
                <p><strong>Velocidad de internet:</strong> {{$hardware->velocidad_red}}</p>
            </div>
        </div>

        <div id="columnTwo" class="column">
            <div class="chat-container">
                <div class="chat-header">
                    <h3>Habla con nuestra IA</h3>
                </div>
                <div class="chat-body">
                    <div id="respuestaIA" class="chat-response">Aqui veras la respuesta de la IA</div>
                </div>
                <div class="chat-footer">
                    <input type="text" id="chat" class="chat-input" placeholder="Escribe tu mensaje..">
                    <button onclick="enviarMensajeIA" id="sendButton" class="chat-send-button">Enviar a la IA</button>
                </div>
            </div>
        </div>
        <div id="columnThree" class="column">
            <div class="ai-info">
                <h3 class="ai-header animate__animated animate__fadeInDown">AI Information</h3>
                <p>Model: <a href="https://huggingface.co/meta-llama/Meta-Llama-3-8B-Instruct">Meta LLama 3 8b Instruct</a></p>
                <div class="ai-image-container">
                    <img class="ai-image animate__animated animate__zoomIn" src="https://i.ytimg.com/vi/pK8u4QfdLx0/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLCz6KiOU2oZp103RzDfa3NdsvMI6A" alt="AI Logo">
                </div>
            </div>
        </div>
    </div>

    <script>
        // ... Existing JavaScript code ...
    </script>
@endsection
