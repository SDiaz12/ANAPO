# ANAPO Project

## Descripción
El proyecto ANAPO es una aplicación web diseñada para gestionar la información de estudiantes y sus residencias en Honduras. Utiliza un mapa interactivo para visualizar la cantidad de estudiantes según su residencia, facilitando el análisis y la toma de decisiones.

## Estructura del Proyecto
La estructura del proyecto incluye los siguientes componentes clave:

- **Controladores**: 
  - `app/Http/Controllers/ResidenciaController.php`: Maneja la lógica relacionada con las residencias de los estudiantes.

- **Modelos**: 
  - `app/Models/Residencia.php`: Define el modelo de datos para las residencias.

- **Vistas**: 
  - `resources/views/livewire/principal/inicioadmin.blade.php`: Vista principal que incluye el componente del mapa de residencias.

- **JavaScript**: 
  - `resources/js/components/MapaResidencias.js`: Componente que renderiza el mapa de Honduras y muestra la cantidad de estudiantes.
  - `public/js/mapa-honduras.js`: Código JavaScript para la lógica del mapa.

- **Rutas**: 
  - `routes/web.php`: Define las rutas de la aplicación, incluyendo la ruta para acceder al controlador de residencias.

- **Configuraciones**: 
  - `package.json`: Configuración de npm con las dependencias necesarias.
  - `composer.json`: Configuración de Composer con las dependencias de PHP.

## Instalación
1. Clona el repositorio en tu máquina local.
2. Navega al directorio del proyecto.
3. Ejecuta `composer install` para instalar las dependencias de PHP.
4. Ejecuta `npm install` para instalar las dependencias de JavaScript.
5. Configura tu archivo `.env` con las credenciales de la base de datos.
6. Ejecuta las migraciones con `php artisan migrate`.
7. Inicia el servidor de desarrollo con `php artisan serve`.

## Uso
Accede a la aplicación a través de `http://localhost:8000` en tu navegador. Desde la vista principal, podrás visualizar el mapa de Honduras con la cantidad de estudiantes según su residencia.

## Contribuciones
Las contribuciones son bienvenidas. Si deseas contribuir, por favor abre un issue o envía un pull request.

## Licencia
Este proyecto está bajo la Licencia MIT.