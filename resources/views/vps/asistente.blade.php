@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.15.0/cdn/themes/light.css"/>
<script type="module"
        src="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.15.0/cdn/shoelace-autoloader.js"></script>
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite(['resources/sass/app.scss', 'resources/js/graph.js','resources/js/app.js', 'resources/js/htmx.js', 'resources/js/event.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.15.0/cdn/themes/light.css"/>
    <script type="module"
            src="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.15.0/cdn/shoelace-autoloader.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        @vite(['resources/sass/app.scss', 'resources/js/graph.js','resources/js/app.js', 'resources/js/htmx.js', 'resources/js/event.js'])
        <style>
            /* Establece el estilo general del contenedor */
            #container {
                display: flex; /* Utiliza flexbox para distribuir los espacios */
                height: 100vh; /* Ajusta la altura del contenedor al 100% de la vista del viewport */
            }

            /* Estilos comunes para las columnas */
            #columnaUno, #columnaDos, #columnaTres {
                flex: 1;  /* Cada columna toma un tercio del espacio disponible */
                padding: 20px; /* Añade un poco de espacio alrededor del contenido de cada columna */
                border-right: 1px solid #ccc; /* Añade un borde para diferenciar las columnas */
                box-sizing: border-box; /* Incluye el padding y el borde en el cálculo del ancho */
            }

            /* Elimina el borde de la última columna */
            #columnaTres {
                border-right: none;
            }

            .chat-container {
                display: flex;
                flex-direction: column; /* Organiza los elementos internos en columna */
                justify-content: center; /* Centra los elementos verticalmente */
            }

            .chat-input {
                margin-top: -20px; /* Eleva el input hacia arriba */
                margin-bottom: 20px; /* Añade un margen inferior */
            }
        </style>
        <div id="container">
            <div id="columnaUno">
                Toda la información de tu equipo
                <div>team info</div>
                <div>server info</div>
            </div>
            <div id="columnaDos" class="chat-container">
                <p id="respuestaIA" class="chat-response">Aquí podrás ver la respuesta de nuestra Inteligencia Artificial</p>
                <input type="text" id="chat" class="chat-input" placeholder="Escribe tu mensaje...">
            </div>
            <div id="columnaTres">
                Información de nuestra IA
                Modelo: <a href="https://huggingface.co/meta-llama/Meta-Llama-3-8B-Instruct">Meta LLama 3 8b Instruct</a>
                <img src="https://i.ytimg.com/vi/pK8u4QfdLx0/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLCz6KiOU2oZp103RzDfa3NdsvMI6A" alt="Logo de la IA">
            </div>
        </div>



    <script>
        let mensajeIA = `Un usuario de mi aplicacion para manejar servidores online tiene esta duda MENSAJE_USUARIO. Contestaras en espanol y con instrucciones claras`
        async function enviarMensajeIA() {
            let chatElementRef = document.getElementById('chat');
            mensajeIA = mensajeIA.replace('MENSAJE_USUARIO', chatElementRef.value)
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
    @endsection

