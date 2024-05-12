@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.15.0/cdn/themes/light.css" />
<script type="module" src="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.15.0/cdn/shoelace-autoloader.js"></script>
<style>
    /* Global style adjustments */
    :root {
        --sl-color-primary-600: #007bff;
        --sl-input-border-radius-medium: 8px;
        --sl-spacing-x-small: 4px;
        --sl-color-primary-50: #e8f1ff;
        --sl-color-primary-100: #c5dcff;
        --sl-color-primary-200: #a1c7ff;
        --sl-color-primary-300: #7db2ff;
        --sl-color-primary-400: #5a9dff;
        --sl-color-primary-500: #3688ff;
        --sl-color-primary-600: #1a73e8;
        --sl-color-primary-700: #1558b4;
        --sl-color-primary-800: #103d80;
        --sl-color-primary-900: #0b224c;
        --sl-font-size-medium: 16px;
        --sl-font-weight-normal: 400;
        --sl-font-weight-semibold: 600;
    }

    /* Scoped style adjustments */
    sl-button-group sl-button,
    sl-button-group sl-dropdown sl-button {
        --sl-color-primary-600: #007bff;
        --sl-input-border-radius-medium: 8px;
        --sl-spacing-x-small: 4px;
        --sl-button-font-size-medium: var(--sl-font-size-medium);
        --sl-button-font-weight: var(--sl-font-weight-semibold);
        --sl-focus-ring-color: var(--sl-color-primary-400);
        margin-right: var(--sl-spacing-x-small);
        transition: background-color 0.2s, color 0.2s, border-color 0.2s, box-shadow 0.2s;
    }

    sl-button-group sl-button:hover,
    sl-button-group sl-dropdown sl-button:hover {
        background-color: var(--sl-color-primary-700);
        color: white;
    }

    sl-button-group sl-button:focus,
    sl-button-group sl-dropdown sl-button:focus {
        box-shadow: 0 0 0 3px var(--sl-focus-ring-color);
    }

    sl-menu-item {
        --sl-menu-item-color-hover: var(--sl-color-primary-600);
        --sl-menu-item-background-color-hover: var(--sl-color-primary-50);
        --sl-menu-item-color-active: white;
        --sl-menu-item-background-color-active: var(--sl-color-primary-600);
        transition: background-color 0.2s, color 0.2s;
    }

    sl-menu-item:hover {
        background-color: var(--sl-menu-item-background-color-hover);
        color: var(--sl-menu-item-color-hover);
    }

    sl-menu-item:active {
        background-color: var(--sl-menu-item-background-color-active);
        color: var(--sl-menu-item-color-active);
    }

    /* Animation for the loading spinner */
    .spinner-border {
        display: inline-block;
        width: 2rem;
        height: 2rem;
        vertical-align: text-bottom;
        border: 0.25em solid currentColor;
        border-right-color: transparent;
        border-radius: 50%;
        animation: spinner-border 0.75s linear infinite;
    }

    @keyframes spinner-border {
        to {
            transform: rotate(360deg);
        }
    }
</style>
<script defer>
    document.addEventListener('DOMContentLoaded', function () {

    });
</script>

@section('content')
    @vite(['resources/sass/app.scss', 'resources/js/graph.js','resources/js/app.js', 'resources/js/htmx.js', 'resources/js/event.js'])

    <div class="container mt-5">
        <h1 class="mb-4">Ahora estás controlando el servidor {{$servidor['nombre_servidor']}}</h1>
        <sl-button-group label="Alignment">
            <sl-button hx-post="{{ route('revisar_docker', [$grupo_id, $servidor['id']]) }}" hx-target="#response" variant="primary">Revisar si Docker está instalado</sl-button>
            <sl-button hx-post="{{ route('instalar_docker', [$grupo_id, $servidor['id']]) }}" hx-target="#response" variant="primary">Instalar Docker</sl-button>
            <sl-button hx-post="{{ route('desinstalar_docker', [$grupo_id, $servidor['id']]) }}" hx-target="#response" variant="primary">Desinstalar Docker</sl-button>
            <sl-button hx-post="{{ route('servicios_docker', [$grupo_id, $servidor['id']]) }}" hx-target="#response" variant="primary">Ver servicios Docker activos</sl-button>
            <sl-button hx-post="{{ route('imagenes', [$grupo_id, $servidor['id']]) }}" hx-target="#response" variant="primary">Ver imágenes instaladas</sl-button>
            <sl-button hx-post="{{ route('administrar_servicios', [$grupo_id, $servidor['id']]) }}" hx-target="#response" variant="primary">Encender servicios</sl-button>
            <sl-button hx-post="{{ route('apagar_servicios', [$grupo_id, $servidor['id']]) }}" hx-target="#response" variant="primary">Apagar todos los servicios</sl-button>
            <sl-dropdown>
                <sl-button slot="trigger" variant="primary" id="imagenes" caret>Instalar Imágenes en Docker</sl-button>
                <sl-menu>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'mysql']) }}" hx-target="#response">Instalar MySQL</sl-menu-item>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'alpine']) }}" hx-target="#response">Instalar Alpine</sl-menu-item>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'nginx']) }}" hx-target="#response">Instalar NGINX</sl-menu-item>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'redis']) }}" hx-target="#response">Instalar Redis</sl-menu-item>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'mongo']) }}" hx-target="#response">Instalar MongoDB</sl-menu-item>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'memcached']) }}" hx-target="#response">Instalar Memcached</sl-menu-item>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'amazonlinux']) }}" hx-target="#response">Instalar Amazon Linux</sl-menu-item>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'traefik']) }}" hx-target="#response">Instalar Traefik</sl-menu-item>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'caddy']) }}" hx-target="#response">Instalar Caddy</sl-menu-item>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'adminer']) }}" hx-target="#response">Instalar Adminer</sl-menu-item>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'postgres']) }}" hx-target="#response">Instalar PostgreSQL</sl-menu-item>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'elasticsearch']) }}" hx-target="#response">Instalar Elasticsearch</sl-menu-item>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'rabbitmq']) }}" hx-target="#response">Instalar RabbitMQ</sl-menu-item>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'grafana']) }}" hx-target="#response">Instalar Grafana</sl-menu-item>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'prometheus']) }}" hx-target="#response">Instalar Prometheus</sl-menu-item>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'jenkins']) }}" hx-target="#response">Instalar Jenkins</sl-menu-item>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'gitlab']) }}" hx-target="#response">Instalar GitLab</sl-menu-item>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'wordpress']) }}" hx-target="#response">Instalar WordPress</sl-menu-item>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'drupal']) }}" hx-target="#response">Instalar Drupal</sl-menu-item>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'magento']) }}" hx-target="#response">Instalar Magento</sl-menu-item>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'nextcloud']) }}" hx-target="#response">Instalar Nextcloud</sl-menu-item>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'python']) }}" hx-target="#response">Instalar Python</sl-menu-item>
                </sl-menu>
            </sl-dropdown>
        </sl-button-group>

        <div id="response"></div>

        <div class="text-center" style="display: none;">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
@endsection
