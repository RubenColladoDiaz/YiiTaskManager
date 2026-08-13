# TaskManager

Aplicación web desarrollada con Yii 2 para gestionar tareas diarias de forma simple y ordenada.

La app permite crear, editar, eliminar, buscar y priorizar tareas, además de asociarlas a categorías y controlar fechas de vencimiento.

## Características

- CRUD completo de tareas
- Categorización por categorías
- Prioridades con ordenamiento por relevancia
- Estados: pendiente, en progreso y completada
- Fechas de vencimiento y tareas vencidas
- Búsqueda por título
- Vista de tareas pendientes con prioridad alta
- Estructura MVC con Yii 2

## Tecnologías

- PHP 8.2+
- Yii 2 Framework
- MySQL
- Bootstrap 5
- Codeception

## Requisitos

- PHP 8.2 o superior
- Composer
- MySQL
- Servidor web local o PHP built-in server

## Instalación

1. Clona el repositorio:

```bash
git clone <url-del-repositorio>
cd YiiTaskManager
```

2. Instala las dependencias:

```bash
composer install
```

3. Configura la base de datos en [config/db.php](config/db.php).

Ejemplo:

```php
return [
    'class' => \yii\db\Connection::class,
    'dsn' => 'mysql:host=localhost;dbname=taskmanager',
    'username' => 'tu_usuario',
    'password' => 'tu_password',
    'charset' => 'utf8',
];
```

4. Crea la base de datos y aplica las migraciones:

```bash
php yii migrate
```

## Ejecución

Inicia la aplicación con el servidor integrado de PHP:

```bash
php -S localhost:8080 -t web
```

Luego abre en el navegador:

```text
http://localhost:8080/
```

## Rutas principales

- `/` -> listado principal de tareas
- `/create-task` -> crear una nueva tarea
- `/task/update/<id>` -> actualizar una tarea
- `/task/delete/<id>` -> eliminar una tarea
- `/task/pending` -> vista de tareas pendientes con prioridad alta

## Estructura del proyecto

```text
assets/            Archivos de assets
commands/          Comandos de consola
config/            Configuración de la app
controllers/       Controladores, incluido TaskController
migrations/        Migraciones de base de datos
models/            Modelos: Task y Category
views/             Vistas del proyecto
web/               Entrada web y recursos públicos
tests/             Pruebas con Codeception
```

## Modelo de datos

La app se basa en dos entidades principales:

- `Task`: representa cada tarea con título, descripción, estado, prioridad, categoría y fecha límite.
- `Category`: agrupa tareas por tipo o área.

## Funcionalidades principales

- Crear tareas con título obligatorio.
- Editar cualquiera de las tareas existentes.
- Eliminar tareas con confirmación.
- Ordenar por prioridad.
- Marcar tareas como pendiente, en progreso o completada.
- Buscar tareas por título.
- Ver tareas con prioridad alta pendientes.

## Pruebas

El proyecto incluye pruebas con Codeception.

```bash
vendor/bin/codecept run
```

## Licencia

Este proyecto se distribuye bajo la licencia MIT, salvo que se indique lo contrario en el repositorio.
