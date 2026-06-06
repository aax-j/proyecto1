<?php
/**
 * Clase de Configuración y Conexión de Base de Datos mediante PDO
 */
class Database {
    private static $host = 'localhost';
    private static $db_name = 'club_estadistica';
    private static $username = 'root';
    private static $password = ''; // XAMPP por defecto viene con contraseña vacía
    private static $conn = null;

    /**
     * Establece y retorna la conexión PDO
     */
    public static function connect() {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$db_name . ";charset=utf8mb4",
                    self::$username,
                    self::$password
                );
                // Configurar manejo de errores y excepciones
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // Configurar fetch mode por defecto a objeto o array asociativo
                self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                // En producción es mejor registrar el error y mostrar un mensaje amigable
                // Para desarrollo, mostramos el detalle del error de conexión
                die("Error de conexión a la base de datos MySQL: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
