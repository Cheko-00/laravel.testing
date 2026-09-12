<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Laravel Testing

Laboratorio de pruebas y experimentación con **Laravel**.

Este repositorio es un espacio dedicado a explorar, aprender y probar diferentes funcionalidades del framework Laravel. El proyecto no está pensado como una aplicación de producción, sino como un entorno donde se puedan implementar ideas, experimentar con nuevas características, probar paquetes y evaluar diferentes enfoques de desarrollo.

## Objetivo

El objetivo principal de este proyecto es utilizar Laravel como un entorno de experimentación para:

* Probar nuevas funcionalidades del framework.
* Aprender y reforzar conceptos de Laravel.
* Experimentar con diferentes arquitecturas y patrones de diseño.
* Probar paquetes y herramientas del ecosistema Laravel.
* Crear pequeñas implementaciones para entender cómo funcionan determinadas características.
* Experimentar con APIs, autenticación, autorización, eventos, jobs, queues, testing, entre otras funcionalidades.
* Evaluar diferentes soluciones antes de implementarlas en proyectos reales.

## Enfoque

Este proyecto debe considerarse un **laboratorio de desarrollo**.

El código puede cambiar constantemente y algunas implementaciones pueden ser experimentales, incompletas o posteriormente eliminadas. No existe la intención de mantener una arquitectura definitiva.

La prioridad es **experimentar, aprender y probar**.

## Tecnologías

Las tecnologías principales utilizadas en el proyecto son:

* PHP
* Laravel
* Composer
* Node.js
* NPM
* Vite
* PHPUnit / Pest
* Base de datos relacional
* Git

> La versión específica de PHP y Laravel puede cambiar conforme se realicen nuevas pruebas y actualizaciones.

## Experimentos

Las funcionalidades que se prueben en este proyecto pueden incluir, entre otras:

### Framework

* [ ] Routing
* [ ] Controllers
* [ ] Middleware
* [ ] Requests y Validation
* [ ] Responses
* [ ] Blade
* [ ] Views
* [ ] Sessions
* [ ] Cache
* [ ] Filesystem

### Base de datos

* [ ] Migrations
* [ ] Seeders
* [ ] Factories
* [ ] Eloquent
* [ ] Relationships
* [ ] Query Builder
* [ ] Transactions
* [ ] Model Events
* [ ] Scopes

### Autenticación y autorización

* [ ] Authentication
* [ ] Authorization
* [ ] Gates
* [ ] Policies
* [ ] Abilities / Scopes
* [ ] Laravel Sanctum
* [ ] Roles y permisos

### APIs

* [ ] REST APIs
* [ ] API Resources
* [ ] API Authentication
* [ ] Request Validation
* [ ] Pagination
* [ ] Rate Limiting
* [ ] API Versioning

### Arquitectura y desarrollo

* [ ] Service Classes
* [ ] Service Providers
* [ ] Contracts / Interfaces
* [ ] Dependency Injection
* [ ] Repository Pattern
* [ ] DTOs
* [ ] Events & Listeners
* [ ] Observers
* [ ] Enums
* [ ] Value Objects

### Procesamiento asíncrono

* [ ] Jobs
* [ ] Queues
* [ ] Events
* [ ] Notifications
* [ ] Scheduled Tasks
* [ ] Queue Workers

### Testing

* [ ] Unit Tests
* [ ] Feature Tests
* [ ] HTTP Tests
* [ ] Database Testing
* [ ] Factories
* [ ] Mocking
* [ ] Fakes
* [ ] Pest
* [ ] PHPUnit

### Integraciones

* [ ] Mail
* [ ] Notifications
* [ ] Redis
* [ ] WebSockets
* [ ] Storage
* [ ] External APIs
* [ ] Third-party packages

## Instalación

Clonar el repositorio:

```bash
git clone git@github.com:Cheko-00/laravel.testing.git
cd laravel.testing
```

Instalar las dependencias de PHP:

```bash
composer install
```

Instalar las dependencias de JavaScript:

```bash
npm install
```

Crear el archivo de entorno:

```bash
cp .env.example .env
```

Generar la clave de la aplicación:

```bash
php artisan key:generate
```

Configurar las variables necesarias en `.env`, especialmente las relacionadas con la base de datos.

Ejecutar las migraciones:

```bash
php artisan migrate
```

Si se requieren datos de prueba:

```bash
php artisan db:seed
```

## Ejecución

Para ejecutar el servidor de desarrollo de Laravel:

```bash
php artisan serve
```

Para ejecutar Vite:

```bash
npm run dev
```

También se puede utilizar el entorno de desarrollo basado en Docker cuando esté disponible.

## Testing

Ejecutar la suite de pruebas:

```bash
php artisan test
```

También se pueden ejecutar las pruebas directamente con PHPUnit:

```bash
vendor/bin/phpunit
```

Si el proyecto utiliza Pest:

```bash
vendor/bin/pest
```

## Estructura

La estructura sigue principalmente la estructura estándar de Laravel:

```text
.
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── artisan
├── composer.json
├── package.json
└── vite.config.js
```

Las implementaciones experimentales deben mantenerse organizadas dentro de la estructura correspondiente del framework.

## Convenciones

Aunque este repositorio es experimental, se busca mantener algunas buenas prácticas:

* Mantener el código organizado.
* Utilizar nombres descriptivos.
* Evitar agregar credenciales al repositorio.
* Mantener `.env` fuera del control de versiones.
* Crear pruebas cuando una funcionalidad lo amerite.
* Preferir soluciones simples antes que sobrearquitecturar.
* Documentar experimentos que puedan ser útiles posteriormente.
* Eliminar código experimental que ya no tenga utilidad.

## Experimentos temporales

No todo lo que se implemente aquí tiene que permanecer.

Una funcionalidad puede:

1. Implementarse para realizar una prueba.
2. Evaluarse.
3. Refactorizarse.
4. Documentarse.
5. Eliminarse.

Esto es parte normal del propósito del repositorio.

## Principio del proyecto

> **Probar primero, entender después y llevar a producción solo lo que tenga sentido.**

Este repositorio existe para experimentar con Laravel sin la presión de que cada implementación tenga que convertirse inmediatamente en código de producción.

## Licencia

Este proyecto es de uso personal y experimental.


