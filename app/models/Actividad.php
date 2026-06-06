<?php
require_once __DIR__ . '/../config/Database.php';

/**
 * Modelo de Actividades del Club
 */
class Actividad {
    private $db;

    public $id;
    public $titulo;
    public $descripcion;
    public $anio;
    public $estado;
    public $fecha_actividad;
    public $imagenes = [];

    public function __construct() {
        $this->db = Database::connect();
    }

    /**
     * Obtiene todas las actividades agrupadas por año
     * Opcionalmente se puede filtrar por estado ('realizada', 'por_realizar')
     */
    public function getGroupedByYear($estado = null) {
        $sql = "SELECT a.id, a.titulo, a.descripcion, a.anio, a.estado, a.fecha_actividad, ai.ruta_imagen 
                FROM actividades a 
                LEFT JOIN actividad_imagenes ai ON a.id = ai.actividad_id";
        
        $params = [];
        if ($estado !== null) {
            $sql .= " WHERE a.estado = :estado";
            $params['estado'] = $estado;
        }

        $sql .= " ORDER BY a.anio DESC, a.fecha_actividad DESC, a.id ASC";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $rows = $stmt->fetchAll();

            $activities = [];
            // Agrupar imágenes por actividad
            foreach ($rows as $row) {
                $id = $row['id'];
                if (!isset($activities[$id])) {
                    $activities[$id] = [
                        'id' => $row['id'],
                        'titulo' => $row['titulo'],
                        'descripcion' => $row['descripcion'],
                        'anio' => $row['anio'],
                        'estado' => $row['estado'],
                        'fecha_actividad' => $row['fecha_actividad'],
                        'imagenes' => []
                    ];
                }
                if (!empty($row['ruta_imagen'])) {
                    $activities[$id]['imagenes'][] = $row['ruta_imagen'];
                }
            }

            // Agrupar actividades por año
            $grouped = [];
            foreach ($activities as $act) {
                $year = $act['anio'];
                if (!isset($grouped[$year])) {
                    $grouped[$year] = [];
                }
                $grouped[$year][] = $act;
            }

            return $grouped;
        } catch (PDOException $e) {
            error_log("Error en Actividad::getGroupedByYear: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtiene los años disponibles en las actividades para filtros
     */
    public function getAvailableYears() {
        $sql = "SELECT DISTINCT anio FROM actividades ORDER BY anio DESC";
        try {
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            error_log("Error en Actividad::getAvailableYears: " . $e->getMessage());
            return [];
        }
    }

    // =====================================================
    // MÉTODOS CRUD PARA EL PANEL DE ADMINISTRACIÓN
    // =====================================================

    /**
     * Obtiene todas las actividades con sus imágenes (sin agrupar)
     */
    public function getAll() {
        $sql = "SELECT a.id, a.titulo, a.descripcion, a.anio, a.estado, a.fecha_actividad, ai.id AS img_id, ai.ruta_imagen 
                FROM actividades a 
                LEFT JOIN actividad_imagenes ai ON a.id = ai.actividad_id
                ORDER BY a.anio DESC, a.fecha_actividad DESC, a.id ASC";
        try {
            $stmt = $this->db->query($sql);
            $rows = $stmt->fetchAll();

            $activities = [];
            foreach ($rows as $row) {
                $id = $row['id'];
                if (!isset($activities[$id])) {
                    $activities[$id] = [
                        'id' => $row['id'],
                        'titulo' => $row['titulo'],
                        'descripcion' => $row['descripcion'],
                        'anio' => $row['anio'],
                        'estado' => $row['estado'],
                        'fecha_actividad' => $row['fecha_actividad'],
                        'imagenes' => []
                    ];
                }
                if (!empty($row['ruta_imagen'])) {
                    $activities[$id]['imagenes'][] = [
                        'id' => $row['img_id'],
                        'ruta' => $row['ruta_imagen']
                    ];
                }
            }
            return array_values($activities);
        } catch (PDOException $e) {
            error_log("Error en Actividad::getAll: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtiene una actividad por su ID
     */
    public function getById($id) {
        $sql = "SELECT a.*, ai.id AS img_id, ai.ruta_imagen 
                FROM actividades a 
                LEFT JOIN actividad_imagenes ai ON a.id = ai.actividad_id 
                WHERE a.id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id]);
            $rows = $stmt->fetchAll();

            if (empty($rows)) return null;

            $activity = [
                'id' => $rows[0]['id'],
                'titulo' => $rows[0]['titulo'],
                'descripcion' => $rows[0]['descripcion'],
                'anio' => $rows[0]['anio'],
                'estado' => $rows[0]['estado'],
                'fecha_actividad' => $rows[0]['fecha_actividad'],
                'imagenes' => []
            ];
            foreach ($rows as $row) {
                if (!empty($row['ruta_imagen'])) {
                    $activity['imagenes'][] = [
                        'id' => $row['img_id'],
                        'ruta' => $row['ruta_imagen']
                    ];
                }
            }
            return $activity;
        } catch (PDOException $e) {
            error_log("Error en Actividad::getById: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Crea una nueva actividad y devuelve su ID
     */
    public function create($titulo, $descripcion, $anio, $estado, $fecha_actividad) {
        $sql = "INSERT INTO actividades (titulo, descripcion, anio, estado, fecha_actividad) 
                VALUES (:titulo, :descripcion, :anio, :estado, :fecha)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'titulo' => $titulo,
                'descripcion' => $descripcion,
                'anio' => $anio,
                'estado' => $estado,
                'fecha' => $fecha_actividad
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error en Actividad::create: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualiza una actividad existente
     */
    public function update($id, $titulo, $descripcion, $anio, $estado, $fecha_actividad) {
        $sql = "UPDATE actividades SET titulo = :titulo, descripcion = :descripcion, anio = :anio, estado = :estado, fecha_actividad = :fecha WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'titulo' => $titulo,
                'descripcion' => $descripcion,
                'anio' => $anio,
                'estado' => $estado,
                'fecha' => $fecha_actividad,
                'id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Error en Actividad::update: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina una actividad (las imágenes se eliminan en cascada por FK)
     */
    public function delete($id) {
        $sql = "DELETE FROM actividades WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Error en Actividad::delete: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Agrega una imagen a una actividad
     */
    public function addImage($actividad_id, $ruta_imagen) {
        $sql = "INSERT INTO actividad_imagenes (actividad_id, ruta_imagen) VALUES (:act_id, :ruta)";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'act_id' => $actividad_id,
                'ruta' => $ruta_imagen
            ]);
        } catch (PDOException $e) {
            error_log("Error en Actividad::addImage: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina una imagen específica por su ID
     */
    public function deleteImage($img_id) {
        // Primero obtener la ruta para eliminar el archivo físico
        $sql = "SELECT ruta_imagen FROM actividad_imagenes WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $img_id]);
            $row = $stmt->fetch();
            
            if ($row) {
                // Eliminar el archivo físico si existe
                $filePath = __DIR__ . '/../../' . $row['ruta_imagen'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $sql = "DELETE FROM actividad_imagenes WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['id' => $img_id]);
        } catch (PDOException $e) {
            error_log("Error en Actividad::deleteImage: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene las rutas de imágenes de una actividad (para eliminar archivos antes de borrar la actividad)
     */
    public function getImagesByActivity($actividad_id) {
        $sql = "SELECT ruta_imagen FROM actividad_imagenes WHERE actividad_id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $actividad_id]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            error_log("Error en Actividad::getImagesByActivity: " . $e->getMessage());
            return [];
        }
    }
}
