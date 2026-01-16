# prueba-tecnica-Nexura
Realización de la prueba técnica en php para la empresa Nexura.

## 1. Descripción general
Desarrollo de una aplicación web para la gestión de empleados, realizada como prueba técnica.
El sistema permite administrar la información de los empleados, incluyendo su área de trabajo y los roles que desempeñan dentro de la organización.

Las funcionalidades principales del sistema son:
- Crear empleados
- Listar empleados
- Editar empleados
- Eliminar empleados
- Asignar áreas
- Asignar múltiples roles por empleado

El proyecto fue desarrollado utilizando PHP, una base de datos MySQL, y una estructura básica tipo MVC, priorizando buenas prácticas, claridad del código y correcto manejo de la información.

## 2. Tecnologías Utilizadas
* PHP 8+
* MySQL
* HTML5
* CSS3
* JavaScript
* Apache (XAMPP)
* PDO (PHP Data Objects) para la conexión a la base de datos

## 3. Estructura del proyecto
La aplicación se organizó de la siguiente manera:

```text
prueba-tecnica/
│
├── config/
│   └── database.php          # Configuración de conexión a la base de datos
│
├── controllers/
│   └── userController.php    # Lógica de negocio (crear, editar, eliminar)
│
├── models/
│   └── user.php              # Acceso a datos (CRUD)
│
├── views/
│   ├── form.php              # Formulario de creación y edición
│   └── list.php              # Listado de empleados
│
├── public/
│   ├── css/
│   │   └── styles.css        # Estilos de la aplicación
│   └── js/
│       └── validaciones.js   # Validaciones del formulario
│
├── database/
│   └── schema.sql            # Esquema versionado de la base de datos
│
└── README.md
```


## 4. Base de Datos
### 4.1 Versionamiento del esquema
El esquema de la base de datos se encuentra versionado mediante el archivo: database/schema.sql
Este archivo permite:
- Crear la base de datos
- Crear todas las tablas necesarias
- Insertar datos iniciales (áreas y roles)
De esta forma, cualquier evaluador puede reproducir el entorno de base de datos de manera sencilla.

### 4.2 Tablas Creadas
* empleados: almacena la información principal del empleado.
* areas: contiene las áreas disponibles.
* roles: contiene los roles disponibles.
* empleado_rol: tabla intermedia para la relación muchos a muchos entre empleados y roles.

### 4.3 Datos iniciales
- Áreas registradas:
    * Administración
    * Ventas
    * Calidad
    * Producción
- Roles registrados:
    * Profesional de proyectos – Desarrollador
    * Gerente estratégico
    * Auxiliar administrativo

## 5. Ejecución del proyecto
El proyecto fue ejecutado utilizando el servidor de desarrollo integrado de PHP a través del editor Visual Studio Code.

Para iniciar el proyecto se realizaron los siguientes pasos:

1. Abrir el proyecto en Visual Studio Code.
2. Hacer clic derecho sobre el archivo `index.php`.
3. Seleccionar la opción **PHP Server: Serve Project**.
4. El sistema se ejecuta automáticamente en el navegador web.

Este método permite ejecutar el proyecto sin necesidad de configurar Apache manualmente.

### 6. Funcionalidades implementadas
* Registro de empleados
* Edición de empleados
* Eliminación de empleados
* Asociación de áreas
* Asociación de múltiples roles
* Validaciones del formulario
* Mensajes de éxito y error
* Confirmación al eliminar registros

### 7. Validaciones
* Todos los campos obligatorios deben completarse
* Validación de formato de correo electrónico
* Selección obligatoria de al menos un rol
* Confirmación antes de eliminar un empleado
* Manejo de errores mediante sesiones

## Autora
### Juliana Dazza Pineda
Prueba tecnica Nexura - Desarrollo en PHP
