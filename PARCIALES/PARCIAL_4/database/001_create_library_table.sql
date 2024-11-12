CREATE DATABASE biblioteca;

USE biblioteca;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE,
    nombre VARCHAR(100),
    google_id VARCHAR(100),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de libros guardados
CREATE TABLE libros_guardados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    google_books_id VARCHAR(50),
    titulo VARCHAR(255),
    autor VARCHAR(255),
    imagen_portada VARCHAR(255),
    reseña_personal TEXT,
    fecha_guardado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES usuarios(id)
);
