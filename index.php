<?php
/**
 * Front Controller - Punto de Entrada de la Aplicación
 */

// Habilitar reporte de errores para desarrollo (desactivar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Cargar el controlador principal
require_once __DIR__ . '/app/controllers/PageController.php';

// Obtener la página solicitada del parámetro GET 'page' (por defecto 'home')
$page = isset($_GET['page']) ? trim($_GET['page']) : 'home';

// Instanciar el controlador y despachar la vista correspondientes
$controller = new PageController();
$controller->render($page);
