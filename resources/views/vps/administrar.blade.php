@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.15.0/cdn/themes/light.css" />
<script type="module" src="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.15.0/cdn/shoelace-autoloader.js"></script>
<style>
    /* Scoped style adjustments */
    sl-menu-item {
        --sl-color-primary-600: #007bff;
        --sl-input-border-radius-medium: 8px;
        --sl-spacing-x-small: 4px;
        :hover{
            background-color: #0a58ca;
        }
    }
    :root {
        --sl-color-primary-600: #007bff; /* Primary color adjustment */
        --sl-input-border-radius-medium: 8px; /* Border radius adjustment */
        --sl-spacing-x-small: 4px; /* Spacing adjustment */
    }
</style>
<script defer>
    document.addEventListener('DOMContentLoaded', function () {

    });

</script>

@section('content')
    @vite(['resources/sass/app.scss', 'resources/js/graph.js','resources/js/app.js', 'resources/js/htmx.js', 'resources/js/event.js'])

    <div class="container mt-5">
        <h1 class="mb-4">Ahora estas controlando el servidor {{$servidor['nombre_servidor']}}</h1>
        <sl-button-group label="Alignment">
            <sl-button hx-post="{{ route('revisar_docker', [$grupo_id, $servidor['id']]) }}" hx-target="#response"  variant="primary">Revisar si docker esta instalado</sl-button>
            <sl-button hx-post="{{ route('instalar_docker', [$grupo_id, $servidor['id']]) }}" hx-target="#response"  variant="primary">Instalar docker</sl-button>
            <sl-button hx-post="{{ route('desinstalar_docker', [$grupo_id, $servidor['id']]) }}" hx-target="#response"  variant="primary">Desinstalar docker</sl-button>
            <sl-button hx-post="{{ route('servicios_docker', [$grupo_id, $servidor['id']]) }}" hx-target="#response"  variant="primary">Ver servicios docker en activo</sl-button>
            <sl-button hx-post="{{ route('imagenes', [$grupo_id, $servidor['id']]) }}" hx-target="#response"   variant="primary">Ver imagenes instaladas</sl-button>
            <sl-button hx-post="{{ route('administrar_servicios', [$grupo_id, $servidor['id']]) }}" hx-target="#response"   variant="primary">Encender servicios</sl-button>
            <sl-dropdown>
                <sl-button slot="trigger" variant="primary" id="imagenes" caret>Instalar Imagenes en Docker</sl-button>
                <sl-menu>
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'mysql']) }}"  hx-target="#response">Instalar MySQL</sl-menu-item>
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
                    <sl-menu-item hx-post="{{ route('instalar_servicio', [$grupo_id, $servidor['id'], 'python']) }}" hx-target="#response">Instalar python</sl-menu-item>
                </sl-menu>
            </sl-dropdown>
        </sl-button-group>


        <div id="response">
        </div>

        <div  style="display:none;" class="text-center">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
@endsection
