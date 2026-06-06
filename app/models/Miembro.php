<?php
require_once __DIR__ . '/../config/Database.php';

/**
 * Modelo de Miembros y Asesores de la Base de Datos
 */
class Miembro {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    /**
     * Obtiene los directivos del club ordenados por orden de cargo
     */
    public function getDirectivos() {
        $sql = "SELECT id, nombre, cargo, ruta_imagen, orden 
                FROM miembros 
                WHERE tipo = 'directivo' 
                ORDER BY orden ASC";
        try {
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en Miembro::getDirectivos: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtiene los asesores del club ordenados por orden de relevancia
     */
    public function getAsesores() {
        $sql = "SELECT id, nombre, cargo, ruta_imagen, orden 
                FROM miembros 
                WHERE tipo = 'asesor' 
                ORDER BY orden ASC";
        try {
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en Miembro::getAsesores: " . $e->getMessage());
            return [];
        }
    }

    // =====================================================
    // MÉTODOS CRUD PARA EL PANEL DE ADMINISTRACIÓN
    // =====================================================

    /**
     * Obtiene todos los miembros (directivos y asesores)
     */
    public function getAll() {
        $sql = "SELECT id, nombre, cargo, tipo, ruta_imagen, orden FROM miembros ORDER BY tipo ASC, orden ASC";
        try {
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en Miembro::getAll: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtiene un miembro por su ID
     */
    public function getById($id) {
        $sql = "SELECT * FROM miembros WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error en Miembro::getById: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Crea un nuevo miembro
     */
    public function create($nombre, $cargo, $tipo, $ruta_imagen, $orden = 0) {
        $sql = "INSERT INTO miembros (nombre, cargo, tipo, ruta_imagen, orden) VALUES (:nombre, :cargo, :tipo, :ruta, :orden)";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'nombre' => $nombre,
                'cargo' => $cargo,
                'tipo' => $tipo,
                'ruta' => $ruta_imagen,
                'orden' => $orden
            ]);
        } catch (PDOException $e) {
            error_log("Error en Miembro::create: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualiza un miembro existente
     */
    public function update($id, $nombre, $cargo, $tipo, $ruta_imagen = null, $orden = 0) {
        if ($ruta_imagen !== null) {
            $sql = "UPDATE miembros SET nombre = :nombre, cargo = :cargo, tipo = :tipo, ruta_imagen = :ruta, orden = :orden WHERE id = :id";
            $params = [
                'nombre' => $nombre,
                'cargo' => $cargo,
                'tipo' => $tipo,
                'ruta' => $ruta_imagen,
                'orden' => $orden,
                'id' => $id
            ];
        } else {
            $sql = "UPDATE miembros SET nombre = :nombre, cargo = :cargo, tipo = :tipo, orden = :orden WHERE id = :id";
            $params = [
                'nombre' => $nombre,
                'cargo' => $cargo,
                'tipo' => $tipo,
                'orden' => $orden,
                'id' => $id
            ];
        }
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Error en Miembro::update: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina un miembro y su archivo de imagen asociado
     */
    public function delete($id) {
        // Obtener la ruta de la imagen antes de eliminar
        $miembro = $this->getById($id);
        if ($miembro && !empty($miembro['ruta_imagen'])) {
            $filePath = __DIR__ . '/../../' . $miembro['ruta_imagen'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $sql = "DELETE FROM miembros WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Error en Miembro::delete: " . $e->getMessage());
            return false;
        }
    }
}
