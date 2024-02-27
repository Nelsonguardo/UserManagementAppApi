# Guía para Configurar un Proyecto de Laravel

## Requisitos previos

Antes de comenzar, asegúrate de tener instalados los siguientes requisitos en tu sistema:

- PHP: Debe estar instalado en tu sistema.
- Composer: Necesitas Composer para gestionar las dependencias de Laravel.
- MySQL u otra base de datos compatible con Laravel.
- Node.js y npm (opcional, dependiendo de los requisitos de tu proyecto).

## Paso 1: Clonar el repositorio de Laravel

Puedes clonar el repositorio de Laravel desde GitHub o iniciar un nuevo proyecto de Laravel utilizando Composer:

```bash
composer create-project --prefer-dist laravel/laravel nombre-del-proyecto
```
## Paso 2: Configurar la base de datos

Edita el archivo .env de tu proyecto Laravel y configura las credenciales de tu base de datos.

## Paso 3: Instalar Laravel Sanctum
Instala Laravel Sanctum utilizando Composer:

```bash
composer require laravel/sanctum
```

## Paso 4: Ejecutar migraciones y seeders
Ejecuta las migraciones para crear las tablas necesarias en la base de datos:

```bash
php artisan migrate
```
Luego, ejecuta el seeders para insertar datos iniciales en la base de datos:
```bash
php artisan db:seed --class=AdminUserSeeder
```

## Paso 5: Ejecutar el servidor de desarrollo
Inicia el servidor de desarrollo de Laravel:
```bash
php artisan serve
```
