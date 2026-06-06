<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistical Solutions Club - ESPOCH</title>
    <!-- FontAwesome para iconos modernos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts: Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <!-- Estilos de la aplicación -->
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <div class="container">
        <!-- BARRA LATERAL (Sidebar) -->
        <?php include __DIR__ . '/../partials/header.php'; ?>

        <!-- CONTENIDO PRINCIPAL -->
        <main class="main-content">
            <!-- Cabecera Superior -->
            <header class="top-header">
                <div class="header-title">
                    <h1 id="page-title">
                        <?php 
                            switch($page) {
                                case 'home': echo 'Statistical Solutions Club'; break;
                                case 'quienes': echo '¿Quiénes Somos?'; break;
                                case 'actividades': echo 'Actividades y Proyectos'; break;
                                case 'contacto': echo 'Contacto SSC'; break;
                                default: echo 'Statistical Solutions Club';
                            }
                        ?>
                    </h1>
                    <p id="page-subtitle">
                        <?php 
                            switch($page) {
                                case 'home': echo 'Comunidad de Estadística y Ciencia de Datos - ESPOCH'; break;
                                case 'quienes': echo 'Conoce nuestra historia, misión, visión y equipo de trabajo'; break;
                                case 'actividades': echo 'Explora las actividades realizadas y planificadas por año'; break;
                                case 'contacto': echo '¿Tienes preguntas? Ponte en contacto con nosotros'; break;
                                default: echo 'Comunidad de Estadística y Ciencia de Datos - ESPOCH';
                            }
                        ?>
                    </p>
                </div>
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <div>
                        <h4>Miembro SSC</h4>
                        <p>ESPOCH - Riobamba</p>
                    </div>
                </div>
            </header>

            <!-- Sección Activa de Contenido Dinámico -->
            <section class="page-section">
                <?php include $contentView; ?>
            </section>
            
            <!-- PIE DE PÁGINA (Footer) -->
            <?php include __DIR__ . '/../partials/footer.php'; ?>
        </main>
    </div>

    <!-- Script Cliente para interacciones visuales -->
    <script src="public/js/app.js"></script>
</body>
</html>
