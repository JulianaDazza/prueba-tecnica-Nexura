CREATE DATABASE IF NOT EXISTS prueba_tecnica
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE prueba_tecnica

--Tabla areas
CREATE TABLE areas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);

--Tabla roles
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);

--Tabla empleados
CREATE TABLE empleados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    sexo CHAR(1) NOT NULL,
    area_id INT NOT NULL,
    boletin INT NOT NULL,
    descripcion TEXT NOT NULL
);

--Tabla empleado-rol
CREATE TABLE empleado_rol (
    empleado_id INT NOT NULL,
    rol_id INT NOT NULL,
    PRIMARY KEY (empleado_id, rol_id),
    CONSTRAINT fk_empleado_rol_empleado
        FOREIGN KEY (empleado_id) REFERENCES empleados(id) ON DELETE CASCADE,
    CONSTRAINT fk_empleado_rol_rol
        FOREIGN KEY (rol_id) REFERENCES roles(id) ON DELETE CASCADE
);


INSERT INTO areas (nombre) VALUES
('Administración'),
('Ventas'),
('Calidad'),
('Producción');

INSERT INTO roles (nombre) VALUES
('Profesional de proyectos - Desarrollador'),
('Gerente estratégico'),
('Auxiliar administrativo');