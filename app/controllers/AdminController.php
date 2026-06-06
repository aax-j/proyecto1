<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Actividad.php';
require_once __DIR__ . '/../models/Miembro.php';

/**
 * Controlador del Panel de Administración
 * Gestiona autenticación (SHA1), sesiones y operaciones CRUD
 */
class AdminController {

    private $db;
    private $actividadModel;
    private $miembroModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = Database::connect();
        $this->actividadModel = new Actividad();
        $this->miembroModel = new Miembro();
    }

    /**
     * Verifica si el administrador ha iniciado sesión
     */
    public function isLoggedIn() {
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }

    /**
     * Procesa el inicio de sesión con SHA1
     */
    public function login($usuario, $password) {
        $hash = sha1($password);
        $sql = "SELECT id, usuario FROM usuarios WHERE usuario = :usuario AND password = :password";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'usuario' => $usuario,
                'password' => $hash
            ]);
            $user = $stmt->fetch();
            if ($user) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_user'] = $user['usuario'];
                $_SESSION['admin_id'] = $user['id'];
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error en AdminController::login: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Cierra la sesión del administrador
     */
    public function logout() {
        session_destroy();
        header('Location: ?page=admin');
        exit;
    }

    /**
     * Procesa todas las acciones POST del panel de administración
     */
    public function handlePostActions() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

        $action = isset($_POST['action']) ? $_POST['action'] : '';

        // ---- AUTENTICACIÓN ----
        if ($action === 'login') {
            $usuario = trim($_POST['usuario'] ?? '');
            $password = $_POST['password'] ?? '';
            if ($this->login($usuario, $password)) {
                header('Location: ?page=admin');
                exit;
            } else {
                return 'Usuario o contraseña incorrectos.';
            }
        }

        if ($action === 'logout') {
            $this->logout();
        }

        // Las siguientes acciones requieren autenticación
        if (!$this->isLoggedIn()) return 'Acceso denegado.';

        // ---- CRUD ACTIVIDADES ----
        if ($action === 'crear_actividad') {
            $titulo = trim($_POST['titulo'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $anio = intval($_POST['anio'] ?? date('Y'));
            $estado = $_POST['estado'] ?? 'por_realizar';
            $fecha = $_POST['fecha_actividad'] ?? null;

            $actId = $this->actividadModel->create($titulo, $descripcion, $anio, $estado, $fecha);
            if ($actId && !empty($_FILES['imagenes']['name'][0])) {
                $this->uploadActivityImages($actId, $_FILES['imagenes']);
            }
            header('Location: ?page=admin&tab=actividades&msg=creado');
            exit;
        }

        if ($action === 'editar_actividad') {
            $id = intval($_POST['id'] ?? 0);
            $titulo = trim($_POST['titulo'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $anio = intval($_POST['anio'] ?? date('Y'));
            $estado = $_POST['estado'] ?? 'por_realizar';
            $fecha = $_POST['fecha_actividad'] ?? null;

            $this->actividadModel->update($id, $titulo, $descripcion, $anio, $estado, $fecha);
            
            // Si se suben nuevas imágenes
            if (!empty($_FILES['imagenes']['name'][0])) {
                $this->uploadActivityImages($id, $_FILES['imagenes']);
            }
            header('Location: ?page=admin&tab=actividades&msg=actualizado');
            exit;
        }

        if ($action === 'eliminar_actividad') {
            $id = intval($_POST['id'] ?? 0);
            // Eliminar archivos de imágenes del servidor
            $imagenes = $this->actividadModel->getImagesByActivity($id);
            foreach ($imagenes as $ruta) {
                $filePath = __DIR__ . '/../../' . $ruta;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            $this->actividadModel->delete($id);
            header('Location: ?page=admin&tab=actividades&msg=eliminado');
            exit;
        }

        if ($action === 'eliminar_imagen_actividad') {
            $img_id = intval($_POST['img_id'] ?? 0);
            $act_id = intval($_POST['act_id'] ?? 0);
            $this->actividadModel->deleteImage($img_id);
            header('Location: ?page=admin&tab=actividades&edit=' . $act_id . '&msg=imagen_eliminada');
            exit;
        }

        // ---- CRUD MIEMBROS ----
        if ($action === 'crear_miembro') {
            $nombre = trim($_POST['nombre'] ?? '');
            $cargo = trim($_POST['cargo'] ?? '');
            $tipo = $_POST['tipo'] ?? 'directivo';
            $orden = intval($_POST['orden'] ?? 0);
            $ruta_imagen = 'public/img/equipo/default_avatar.png'; // Default

            if (!empty($_FILES['imagen']['name'])) {
                $ruta_imagen = $this->uploadMemberImage($_FILES['imagen']);
            }

            $this->miembroModel->create($nombre, $cargo, $tipo, $ruta_imagen, $orden);
            header('Location: ?page=admin&tab=miembros&msg=creado');
            exit;
        }

        if ($action === 'editar_miembro') {
            $id = intval($_POST['id'] ?? 0);
            $nombre = trim($_POST['nombre'] ?? '');
            $cargo = trim($_POST['cargo'] ?? '');
            $tipo = $_POST['tipo'] ?? 'directivo';
            $orden = intval($_POST['orden'] ?? 0);
            $ruta_imagen = null;

            if (!empty($_FILES['imagen']['name'])) {
                // Eliminar imagen antigua
                $miembro = $this->miembroModel->getById($id);
                if ($miembro && !empty($miembro['ruta_imagen'])) {
                    $oldPath = __DIR__ . '/../../' . $miembro['ruta_imagen'];
                    if (file_exists($oldPath) && strpos($miembro['ruta_imagen'], 'default_avatar') === false) {
                        unlink($oldPath);
                    }
                }
                $ruta_imagen = $this->uploadMemberImage($_FILES['imagen']);
            }

            $this->miembroModel->update($id, $nombre, $cargo, $tipo, $ruta_imagen, $orden);
            header('Location: ?page=admin&tab=miembros&msg=actualizado');
            exit;
        }

        if ($action === 'eliminar_miembro') {
            $id = intval($_POST['id'] ?? 0);
            $this->miembroModel->delete($id);
            header('Location: ?page=admin&tab=miembros&msg=eliminado');
            exit;
        }

        return null;
    }

    /**
     * Sube imágenes de actividades al servidor
     */
    private function uploadActivityImages($actividadId, $files) {
        $uploadDir = __DIR__ . '/../../public/img/actividades/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileCount = count($files['name']);
        for ($i = 0; $i < $fileCount; $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($files['name'][$i], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                if (!in_array($ext, $allowed)) continue;

                $filename = 'act_' . $actividadId . '_' . time() . '_' . $i . '.' . $ext;
                $destPath = $uploadDir . $filename;
                
                if (move_uploaded_file($files['tmp_name'][$i], $destPath)) {
                    $rutaRelativa = 'public/img/actividades/' . $filename;
                    $this->actividadModel->addImage($actividadId, $rutaRelativa);
                }
            }
        }
    }

    /**
     * Sube una imagen de miembro al servidor
     */
    private function uploadMemberImage($file) {
        $uploadDir = __DIR__ . '/../../public/img/equipo/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if ($file['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array($ext, $allowed)) {
                return 'public/img/equipo/default_avatar.png';
            }

            $filename = 'miembro_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
            $destPath = $uploadDir . $filename;

            if (move_uploaded_file($file['tmp_name'], $destPath)) {
                return 'public/img/equipo/' . $filename;
            }
        }
        return 'public/img/equipo/default_avatar.png';
    }

    /**
     * Obtiene los datos para las vistas del panel de administración
     */
    public function getDashboardData() {
        return [
            'actividades' => $this->actividadModel->getAll(),
            'miembros' => $this->miembroModel->getAll(),
            'admin_user' => $_SESSION['admin_user'] ?? 'Admin'
        ];
    }

    /**
     * Obtiene una actividad para editar
     */
    public function getActividad($id) {
        return $this->actividadModel->getById($id);
    }

    /**
     * Obtiene un miembro para editar
     */
    public function getMiembro($id) {
        return $this->miembroModel->getById($id);
    }
}
