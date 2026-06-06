<?php
require_once __DIR__ . '/../models/ClubData.php';
require_once __DIR__ . '/../models/Actividad.php';

/**
 * Controlador Principal del Proyecto MVC
 */
class PageController {
    
    /**
     * Renderiza la página solicitada envolviéndola en el layout principal
     */
    public function render($page) {
        // Páginas permitidas
        $allowed_pages = ['home', 'quienes', 'actividades', 'contacto', 'admin'];
        
        // Si no está permitida o no se especifica, redirige a inicio (home)
        if (empty($page) || !in_array($page, $allowed_pages)) {
            $page = 'home';
        }

        // ---- MANEJO ESPECIAL DEL PANEL ADMIN ----
        if ($page === 'admin') {
            require_once __DIR__ . '/AdminController.php';
            $adminCtrl = new AdminController();
            
            // Procesar acciones POST (login, logout, CRUD)
            $loginError = $adminCtrl->handlePostActions();
            
            $isLoggedIn = $adminCtrl->isLoggedIn();
            $dashboardData = [];
            $editActividad = null;
            $editMiembro = null;

            if ($isLoggedIn) {
                $dashboardData = $adminCtrl->getDashboardData();
                
                // Si se está editando una actividad
                if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
                    $editActividad = $adminCtrl->getActividad(intval($_GET['edit']));
                }
                // Si se está editando un miembro
                if (isset($_GET['edit_miembro']) && is_numeric($_GET['edit_miembro'])) {
                    $editMiembro = $adminCtrl->getMiembro(intval($_GET['edit_miembro']));
                }
            }

            $activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'actividades';
            $msg = isset($_GET['msg']) ? $_GET['msg'] : null;

            // Cargar layout de administración (sin sidebar)
            include __DIR__ . '/../views/layouts/admin_layout.php';
            return;
        }

        // Inicializar contenedor de datos para la vista
        $data = [];

        // Obtener datos del Modelo según la página cargada
        switch ($page) {
            case 'home':
                $data['stats'] = ClubData::getStats();
                $data['skill_bars'] = ClubData::getSkillBars();
                $data['social_links'] = ClubData::getSocialLinks();
                break;
            case 'quienes':
                require_once __DIR__ . '/../models/Miembro.php';
                $miembroModel = new Miembro();
                $data['members'] = $miembroModel->getDirectivos();
                $data['advisors'] = $miembroModel->getAsesores();
                $data['values'] = ClubData::getValues();
                break;
            case 'actividades':
                $actividadModel = new Actividad();
                // Obtener actividades agrupadas por año (todas, incluyendo realizadas y por realizar)
                $data['actividades_por_anio'] = $actividadModel->getGroupedByYear();
                $data['anios'] = $actividadModel->getAvailableYears();
                break;
            case 'contacto':
                $data['social_links'] = ClubData::getSocialLinks();
                break;
        }

        // Extraer variables para que estén disponibles de forma limpia en las vistas
        extract($data);

        // Definir la vista interna que cargará el layout
        $viewFile = __DIR__ . "/../views/pages/{$page}.php";
        
        if (file_exists($viewFile)) {
            $contentView = $viewFile;
            // Cargar el layout principal que incluye cabecera, sidebar y pie de página
            include __DIR__ . '/../views/layouts/main.php';
        } else {
            // Error 404 amigable
            http_response_code(404);
            die("Error 404: La vista solicitada '{$page}' no existe en el sistema.");
        }
    }
}

