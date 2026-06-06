<?php
/**
 * Componente Parcial - Sidebar Lateral Izquierdo (Menú de navegación y Logo)
 */
$currentPage = isset($_GET['page']) ? trim($_GET['page']) : 'home';
?>
<aside class="sidebar">
    <!-- Contenedor del Logo -->
    <div class="logo">
        <div class="logo-img-wrapper">
            <img src="public/img/logo_club.png" alt="Logo Statistical Solutions Club" class="club-logo">
        </div>
        <h2>Statistical</h2>
        <p>Solutions Club</p>
    </div>
    
    <!-- Menú de Navegación -->
    <ul class="nav-menu">
        <li class="nav-item">
            <a href="?page=home" class="nav-link <?php echo ($currentPage === 'home' || $currentPage === '') ? 'active' : ''; ?>">
                <i class="fas fa-home"></i>
                <span>Inicio</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="?page=quienes" class="nav-link <?php echo ($currentPage === 'quienes') ? 'active' : ''; ?>">
                <i class="fas fa-users"></i>
                <span>Quiénes Somos</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="?page=actividades" class="nav-link <?php echo ($currentPage === 'actividades') ? 'active' : ''; ?>">
                <i class="fas fa-project-diagram"></i>
                <span>Actividades</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="?page=contacto" class="nav-link <?php echo ($currentPage === 'contacto') ? 'active' : ''; ?>">
                <i class="fas fa-envelope"></i>
                <span>Contacto</span>
            </a>
        </li>
    </ul>
</aside>
