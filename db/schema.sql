-- Script de creación de base de datos y tablas para el Club de Estadística
CREATE DATABASE IF NOT EXISTS club_estadistica CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE club_estadistica;

-- -------------------------------------------------------------
-- Tabla de Actividades (realizadas y por realizar)
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS actividades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    anio INT NOT NULL,
    estado ENUM('realizada', 'por_realizar') NOT NULL,
    fecha_actividad DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla de Imágenes de Actividades
CREATE TABLE IF NOT EXISTS actividad_imagenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    actividad_id INT NOT NULL,
    ruta_imagen VARCHAR(255) NOT NULL,
    FOREIGN KEY (actividad_id) REFERENCES actividades(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- -------------------------------------------------------------
-- Tabla de Miembros del Club (Directiva y Asesores)
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS miembros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    cargo VARCHAR(150) NOT NULL,
    tipo ENUM('directivo', 'asesor') NOT NULL,
    ruta_imagen VARCHAR(255) NOT NULL,
    orden INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- -------------------------------------------------------------
-- Datos iniciales de prueba (Semillas - Actividades)
-- -------------------------------------------------------------
INSERT INTO actividades (id, titulo, descripcion, anio, estado, fecha_actividad) VALUES
(1, 'Feria de Ciencias y Modelado Estadístico', 'Participación destacada del Statistical Solutions Club en la casa abierta de la ESPOCH. Los miembros presentaron modelos de simulación estadística en tiempo real, demostrando la aplicación de regresiones lineales y árboles de decisión en problemas sociales y ambientales locales. Se brindó asesoría y demostración interactiva a los estudiantes visitantes.', 2025, 'realizada', '2025-11-15'),
(2, 'Taller Integral de Habilidades Blandas para Ingenieros', 'Un taller interactivo diseñado para fortalecer la comunicación asertiva, el trabajo en equipo y el liderazgo dentro del ámbito técnico. Entendiendo que el análisis de datos requiere no solo destreza matemática sino también la capacidad de traducir hallazgos a audiencias no técnicas, este taller capacitó a 35 miembros del club en técnicas de presentación eficaz.', 2025, 'realizada', '2025-10-05'),
(3, 'Planificación Estratégica Anual y Misión/Visión', 'Reunión general del club en la que directivos, asesores y miembros activos definieron los objetivos estratégicos a mediano y largo plazo. Se revisaron y actualizaron las declaraciones de misión y visión del club para alinearlas con las tendencias actuales en ciencia de datos y las necesidades de la comunidad politécnica de la ESPOCH.', 2025, 'realizada', '2025-09-10'),
(4, 'Seminario de Eventos Académicos y Conferencias', 'Ciclo de conferencias y charlas donde se presentaron resúmenes de investigaciones realizadas por estudiantes y ponentes invitados sobre redes complejas y machine learning aplicado.', 2025, 'realizada', '2025-12-01'),
(5, 'Taller Avanzado de Machine Learning en Python', 'Actividad planificada para capacitar a los integrantes en modelos predictivos avanzados, algoritmos de clustering y redes neuronales utilizando bibliotecas como Scikit-Learn y TensorFlow.', 2026, 'por_realizar', '2026-07-10'),
(6, 'Hackathon de Análisis de Datos y Predicciones', 'Competencia interna abierta de 24 horas donde grupos de estudiantes resolverán un problema real analizando grandes volúmenes de datos para proponer soluciones optimizadas con modelos estadísticos.', 2026, 'por_realizar', '2026-09-15');

-- Inserción de imágenes de actividades
INSERT INTO actividad_imagenes (actividad_id, ruta_imagen) VALUES
(1, 'public/img/actividades/eventos_academicos.png'),
(2, 'public/img/actividades/habilidades_blandas.png'),
(3, 'public/img/actividades/mision_vision.png'),
(4, 'public/img/actividades/eventos_academicos.png'),
(5, 'public/img/actividades/actividades_planificadas.png'),
(6, 'public/img/actividades/actividades_planificadas.png');

-- -------------------------------------------------------------
-- Datos iniciales (Semillas - Miembros y Asesores)
-- -------------------------------------------------------------
INSERT INTO miembros (nombre, cargo, tipo, ruta_imagen, orden) VALUES
-- Directiva
('Kevin Yanzapanta', 'Presidente', 'directivo', 'public/img/equipo/kevin_yanzapanta.png', 1),
('Liseth Choto', 'Vicepresidenta', 'directivo', 'public/img/equipo/liseth_choto.png', 2),
('Paul Vaca', 'Secretario', 'directivo', 'public/img/equipo/paul_vaca.png', 3),
('Dayra Moyano', 'Tesorera', 'directivo', 'public/img/equipo/dayra_moyano.png', 4),
('Erick Barroso', 'Coordinador General', 'directivo', 'public/img/equipo/erick_barroso.png', 5),
-- Asesores
('Dra. Isabel Escudero', 'Asesora Académica (Principal)', 'asesor', 'public/img/equipo/isabel_escudero.png', 1),
('Ing. Paulina Morocho', 'Apoyo Docente', 'asesor', 'public/img/equipo/paulina_morocho.png', 2),
('Ing. Johanna Aguilar', 'Apoyo Docente', 'asesor', 'public/img/equipo/johanna_aguilar.png', 3),
('Ing. Edwin Mejía', 'Apoyo Docente', 'asesor', 'public/img/equipo/edwin_mejia.png', 4);

-- -------------------------------------------------------------
-- Tabla de Usuarios (Administradores del sistema)
-- Contraseña encriptada con SHA1 según requisito del cliente
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(40) NOT NULL COMMENT 'Hash SHA1 de la contraseña',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Insertar administrador por defecto
-- Contraseña: admin -> SHA1: d033e22ae348aeb5660fc2140aec35850c4da997
INSERT INTO usuarios (usuario, password) VALUES
('admin', 'd033e22ae348aeb5660fc2140aec35850c4da997');
