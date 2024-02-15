<!DOCTYPE html><!-- This site was created in Webflow. https://www.webflow.com --><!-- Last Published: Wed Feb 07 2024 00:42:40 GMT+0000 (Coordinated Universal Time) -->
<html data-wf-domain="eduardos-fabulous-site-57049f.webflow.io" data-wf-page="65c2d1ed8547d6ac2c4ffd25"
      data-wf-site="65c2d1ec8547d6ac2c4ffc9f" data-wf-status="1" lang="en">
<head>
    <link href="{{ asset('css/styling.css') }}" rel="stylesheet">

    <meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta content="Home 2" property="og:title">
    <meta content="Home 2" property="twitter:title">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="Webflow" name="generator">
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
    <script
        type="text/javascript">WebFont.load({google: {families: ["Plus Jakarta Sans:200,300,regular,500,600,700,800", "Krona One:regular", "Belleza:regular", "Space Grotesk:300,regular,500,600,700", "Outfit:100,200,300,regular,500,600,700,800,900"]}});</script>
    <script type="text/javascript">!function (o, c) {
            var n = c.documentElement, t = " w-mod-";
            n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch")
        }(window, document);</script>
    <link href="https://assets-global.website-files.com/img/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link href="https://assets-global.website-files.com/img/webclip.png" rel="apple-touch-icon">
    <script defer src="{{ asset('js/interactivity.js') }}" type="text/javascript"></script>

    <style>
        .lightbox-modal {
            position: fixed;
            display: none;
        }

        a, button, input {
            transition: 200ms;
        }

    </style>
</head>
<body>
<div class="wrap_sticky">
    <div data-collapse="small" data-animation="default" data-duration="450"
         data-w-id="de9a86b4-7912-1142-82cc-3ef633997408" data-easing="ease-out-quart" data-easing2="ease-out-quart"
         role="banner" class="navbar-outer w-nav">
        <div class="navbar-container"><a href="/"
                                         aria-current="page" class="navbar-logo-link w-nav-brand w--current">
                <div class="logo-img w-embed">
                    <img src="{{asset('/img/logo.webp')}}" alt="" width="92" height="92">
                </div>
            </a>
            <nav role="navigation" class="navbar-menu overflow-hidden w-nav-menu"><a
                    href="/login"
                    class="navbar-link w-nav-link">Log In</a><a
                    href="/register"
                    class="button in-nav w-button">Sign Up</a></nav>
            <div class="navbar_menu-button w-nav-button">
                <div class="menu-icon">
                    <div class="menu-icon_line-top"></div>
                    <div class="menu-icon-line-middle">
                        <div class="menu-icon-line-middle-inner"></div>
                    </div>
                    <div class="menu-icon-line-bottom"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-wrapper">
    <div class="main-section">
        <div class="main-container">
            <div class="w-layout-grid grid_1-2">
                <div id="w-node-_05440e2b-310f-d781-83e6-e169aaed84f6-2c4ffd25" class="content-wrap">
                    <div class="subheader cta-color">Bienvenido a ACS</div>
                    <div class="spacer_xs"></div>
                    <h1 class="h1">Configuracion de Sistemas Simple</h1>
                    <div class="spacer_xs"></div>
                    <p class="paragraph">ACS (Auto configuracion de sistemas) es una novedosa idea donde podras
                        administrar tu VPS de una forma grafica comoda e intuitia sin necesidad de recordar
                        comandos.</p>
                    <div class="spacer_l"></div>
                    <a href="#" class="button w-button">Registrate</a></div>
                <img src="{{asset('img/nube.jpg')}}" loading="lazy"
                     id="w-node-_05440e2b-310f-d781-83e6-e169aaed8502-2c4ffd25" sizes="90vw" alt=""
                     class="hero-image tall"></div>
        </div>
    </div>
    <div class="main-section">
        <div class="main-container">
            <div class="w-layout-grid grid_1-2">
                <div id="w-node-_9a521c9b-b9ee-4177-6591-f2e194d4a0fd-2c4ffd25" class="content-wrap"><h2 class="h2">
                        Hecha para todo tipo de pantallas</h2>
                    <div class="spacer_m"></div>
                    <p class="paragraph">Con nuestro servicio puedes configurar un VPS desde el movil gracias a la
                        sencillez grafica.</p>
                    <div class="spacer_l"></div>
                </div>
                <div id="w-node-_8e653e4b-67f9-f2a7-6f82-d80e04f3535f-2c4ffd25" class="macbook-wrapper"><img
                        src="{{asset('img/screen.jpg')}}" loading="lazy"
                        id="w-node-_8e653e4b-67f9-f2a7-6f82-d80e04f35360-2c4ffd25" sizes="90vw" alt=""
                        class="hero-image tall">


                </div>
            </div>
        </div>
    </div>
    <div id="about" class="main-section">
        <div class="main-container">
            <div class="w-layout-grid grid_1-2 reverse"><img src="{{asset('img/ssh.png')}}"
                                                             loading="lazy"
                                                             id="w-node-b4ef11d3-2ae9-1808-aaa2-cbc9973a0fbb-2c4ffd25"
                                                             sizes="90vw" alt="" class="hero-image">
                <div id="w-node-b4ef11d3-2ae9-1808-aaa2-cbc9973a0fbc-2c4ffd25" class="content-wrap"><h2 class="h2">
                        Tenemos un gran objetivo</h2>
                    <div class="spacer_m"></div>
                    <p class="paragraph">Nuestro objetivo es conseguir que el despliegue de aplicaciones web o
                        configuraciones de servidores sea lo mas comoda y facil posible .</p>
                    <div class="spacer_l"></div>
                    <a href="#" class="button secondary w-button">Crear cuenta</a></div>
            </div>
        </div>
    </div>
    <div class="main-section">
        <div class="main-container">
            <div class="w-layout-grid grid_1-2 _75-space">
                <div id="w-node-_896be899-d6d5-78ce-59df-eb1d6476f4e1-2c4ffd25"
                     data-w-id="896be899-d6d5-78ce-59df-eb1d6476f4e1" style="opacity:0" class="content-wrap"><h2
                        class="h2">Todo lo que buscas en un solo lugar.</h2>
                    <div class="spacer_m"></div>
                    <p class="paragraph">Queremos que ACS sea un sistema completo a la hora de desplegar para no tener
                        que utilizar otras herramientas.</p>
                    <div class="spacer_l"></div>
                </div>
                <div id="w-node-_896be899-d6d5-78ce-59df-eb1d6476f4ea-2c4ffd25" class="w-layout-grid grid_2-2">
                    <div id="w-node-_896be899-d6d5-78ce-59df-eb1d6476f4eb-2c4ffd25"
                         data-w-id="896be899-d6d5-78ce-59df-eb1d6476f4eb" style="opacity:0" class="card_small">
                        <div class="icon w-embed">
                            <img src="{{asset('/img/logo.webp')}}">
                        </div>
                        <div class="spacer_xs"></div>
                        <h3 class="h3">Ligero</h3>
                        <div class="spacer_xs"></div>
                        <p class="paragraph">ACS se centra en ser rapido y ligero para llevar a cabo una tarea lo mas
                            rapido posible.</p></div>
                    <div id="w-node-_896be899-d6d5-78ce-59df-eb1d6476f4f6-2c4ffd25"
                         data-w-id="896be899-d6d5-78ce-59df-eb1d6476f4f6" style="opacity:0" class="card_small">
                        <div class="icon w-embed">
                            <img src="{{asset('/img/logo.webp')}}">
                        </div>
                        <div class="spacer_xs"></div>
                        <h3 class="h3">Comodo</h3>
                        <div class="spacer_xs"></div>
                        <p class="paragraph">La sencillez visual permite mejorar la concentracion a la hora de
                            configurar un VPS.</p></div>
                    <div id="w-node-_896be899-d6d5-78ce-59df-eb1d6476f501-2c4ffd25"
                         data-w-id="896be899-d6d5-78ce-59df-eb1d6476f501" style="opacity:0" class="card_small">
                        <div class="icon w-embed">
                            <img src="{{asset('/img/logo.webp')}}">
                        </div>
                        <div class="spacer_xs"></div>
                        <h3 class="h3">Eficiencia Energética</h3>
                        <div class="spacer_xs"></div>
                        <p class="paragraph">Minimiza los costos operativos y el consumo de recursos gracias a una
                            gestión eficiente, automatizada y optimizada de tus servidores.</p></div>
                    <div id="w-node-_896be899-d6d5-78ce-59df-eb1d6476f50c-2c4ffd25"
                         data-w-id="896be899-d6d5-78ce-59df-eb1d6476f50c" style="opacity:0" class="card_small">
                        <div class="icon w-embed">
                            <img src="{{asset('/img/logo.webp')}}">
                        </div>
                        <div class="spacer_xs"></div>
                        <h3 class="h3">Optimización con Inteligencia Artificial</h3>
                        <div class="spacer_xs"></div>
                        <p class="paragraph">Imagina tener un asistente personal que no solo entiende tus necesidades
                            sino que también ofrece soluciones proactivas, gracias a la integración con la API de
                            OpenAI.</p></div>
                </div>
            </div>
        </div>
    </div>
    <div id="features" class="main-section">
        <div class="main-container">
            <div class="content-wrap_center">
                <div id="w-node-a0f4c818-4abb-ddfd-6f6c-1c2a34baaa78-2c4ffd25"
                     data-w-id="a0f4c818-4abb-ddfd-6f6c-1c2a34baaa78" style="opacity:0"
                     class="content-wrap_center mw-800"><h2 class="h2">Todo lo que tu VPS necesita</h2>
                    <div class="spacer_xs"></div>
                    <p class="paragraph">Se termino depender de miles de servicios para manejar un servidor.</p></div>

            </div>
        </div>
    </div>
</div>

<div class="footer-outer-wrap">
    <div class="footer_2-inner"><a href="#" class="navbar-logo-link w-nav-brand">
            <div class="logo-img w-embed">
                <img src="{{asset('/img/logo.webp')}}" alt="">
            </div>
        </a>
        <div class="footer-credit-text">© {{ now()->year  }}  {{ config('app.name', 'Laravel') }}</div>
    </div>

</div>
</div>
<script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=65c2d1ec8547d6ac2c4ffc9f"
        type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script><!-- For "Content Section 2" tabs -->

<script>
    var Webflow = Webflow || [];
    Webflow.push(function () {

        // Start Tabs
        var tabTimeout;
        clearTimeout(tabTimeout);
        tabLoop();

        // Connect your class names to elements
        function tabLoop() {
            tabTimeout = setTimeout(function () {
                var $next = $('.tabs-menu').children('.w--current:first').next();

                if ($next.length) {
                    $next.click();  // user click resets timeout
                } else {
                    $('.tab-button:first').click();
                }
            }, 5000);  // 5 Second Rotation
        }

        // Reset Loops
        $('.tab-button').click(function () {
            clearTimeout(tabTimeout);
            tabLoop();
        });
    });
</script>
</body>
</html>
