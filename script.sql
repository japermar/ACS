create table failed_jobs
(
    id         bigint unsigned auto_increment
        primary key,
    uuid       varchar(255)                        not null,
    connection text                                not null,
    queue      text                                not null,
    payload    longtext                            not null,
    exception  longtext                            not null,
    failed_at  timestamp default CURRENT_TIMESTAMP not null,
    constraint failed_jobs_uuid_unique
        unique (uuid)
)
    collate = utf8mb4_unicode_ci;

create table grupos_colaboracion
(
    id           bigint unsigned auto_increment
        primary key,
    nombre_grupo varchar(255) not null,
    created_at   timestamp    null,
    updated_at   timestamp    null
)
    collate = utf8mb4_unicode_ci;

create table migrations
(
    id        int unsigned auto_increment
        primary key,
    migration varchar(255) not null,
    batch     int          not null
)
    collate = utf8mb4_unicode_ci;

create table password_reset_tokens
(
    email      varchar(255) not null
        primary key,
    token      varchar(255) not null,
    created_at timestamp    null
)
    collate = utf8mb4_unicode_ci;

create table password_resets
(
    email      varchar(255) not null,
    token      varchar(255) not null,
    created_at timestamp    null
)
    collate = utf8mb4_unicode_ci;

create index password_resets_email_index
    on password_resets (email);

create table personal_access_tokens
(
    id             bigint unsigned auto_increment
        primary key,
    tokenable_type varchar(255)    not null,
    tokenable_id   bigint unsigned not null,
    name           varchar(255)    not null,
    token          varchar(64)     not null,
    abilities      text            null,
    last_used_at   timestamp       null,
    expires_at     timestamp       null,
    created_at     timestamp       null,
    updated_at     timestamp       null,
    constraint personal_access_tokens_token_unique
        unique (token)
)
    collate = utf8mb4_unicode_ci;

create index personal_access_tokens_tokenable_type_tokenable_id_index
    on personal_access_tokens (tokenable_type, tokenable_id);

create table servidores
(
    id              bigint unsigned auto_increment
        primary key,
    grupo_id        bigint unsigned not null,
    nombre_servidor varchar(255)    not null,
    direccion_ssh   varchar(255)    not null,
    puerto_ssh      int             not null,
    usuario_ssh     varchar(255)    not null,
    contrasena_ssh  varchar(255)    not null,
    created_at      timestamp       null,
    updated_at      timestamp       null,
    constraint servidores_grupo_id_foreign
        foreign key (grupo_id) references grupos_colaboracion (id)
)
    collate = utf8mb4_unicode_ci;

create table aplicaciones_docker
(
    id          bigint unsigned auto_increment
        primary key,
    servidor_id bigint unsigned                           not null,
    nombre_app  varchar(255)                              not null,
    version_app varchar(255)                              null,
    estado      enum ('corriendo', 'detenido', 'pausado') not null,
    created_at  timestamp                                 null,
    updated_at  timestamp                                 null,
    constraint aplicaciones_docker_servidor_id_foreign
        foreign key (servidor_id) references servidores (id)
)
    collate = utf8mb4_unicode_ci;

create table hardware_servidor
(
    id             bigint unsigned auto_increment
        primary key,
    servidor_id    bigint unsigned not null,
    cpu            varchar(255)    not null,
    ram            varchar(255)    not null,
    almacenamiento varchar(255)    not null,
    velocidad_red  varchar(255)    not null,
    created_at     timestamp       null,
    updated_at     timestamp       null,
    constraint hardware_servidor_servidor_id_foreign
        foreign key (servidor_id) references servidores (id)
)
    collate = utf8mb4_unicode_ci;

create table users
(
    id                bigint unsigned auto_increment
        primary key,
    name              varchar(255) not null,
    email             varchar(255) not null,
    email_verified_at timestamp    null,
    password          varchar(255) not null,
    remember_token    varchar(100) null,
    created_at        timestamp    null,
    updated_at        timestamp    null,
    constraint users_email_unique
        unique (email)
)
    collate = utf8mb4_unicode_ci;

create table actividades
(
    id          bigint unsigned auto_increment
        primary key,
    user_id     bigint unsigned not null,
    servidor_id bigint unsigned not null,
    accion      text            not null,
    created_at  timestamp       null,
    updated_at  timestamp       null,
    constraint actividades_servidor_id_foreign
        foreign key (servidor_id) references servidores (id),
    constraint actividades_user_id_foreign
        foreign key (user_id) references users (id)
)
    collate = utf8mb4_unicode_ci;

create table miembros_grupo
(
    id         bigint unsigned auto_increment
        primary key,
    grupo_id   bigint unsigned                     not null,
    user_id    bigint unsigned                     not null,
    rol        enum ('admin', 'monitor', 'editar') not null,
    created_at timestamp                           null,
    updated_at timestamp                           null,
    constraint miembros_grupo_grupo_id_foreign
        foreign key (grupo_id) references grupos_colaboracion (id),
    constraint miembros_grupo_user_id_foreign
        foreign key (user_id) references users (id)
)
    collate = utf8mb4_unicode_ci;


