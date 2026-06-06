<?php
/**
 * Vista – Inicio (Home)
 */
?>
<!-- HERO SECTION -->
<div class="hero-banner">
    <canvas id="heroCanvas" class="hero-canvas"></canvas>
    <div class="hero-overlay-content">
        <span class="hero-tag"><i class="fas fa-chart-bar"></i> Statistical Solutions Club</span>
        <h1>Transformando Datos en Conocimiento</h1>
        <p>Somos la comunidad de estadística y ciencia de datos de la ESPOCH. Fomentamos el análisis cuantitativo, el modelado matemático y la programación aplicada a resolver retos de la vida real.</p>
        <div class="hero-buttons">
            <a href="?page=actividades" class="btn btn-filled">Explorar Actividades</a>
            <a href="?page=quienes" class="btn btn-outlined">Conócenos</a>
        </div>
    </div>
</div>

<!-- SECCIÓN ESTADÍSTICAS -->
<div class="stats-grid">
    <?php foreach ($stats as $stat): ?>
        <div class="stat-card">
            <div class="stat-icon-circle">
                <i class="<?php echo $stat['icon']; ?>"></i>
            </div>
            <div class="stat-detail">
                <h3><?php echo $stat['value']; ?></h3>
                <p><?php echo $stat['label']; ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- SECCIÓN HABILIDADES (SKILLS) -->
<div class="skills-section">
    <div class="skills-intro">
        <h2>Capacidades Técnicas</h2>
        <p>Formamos de manera práctica a nuestros miembros para que dominen las herramientas de vanguardia en el análisis moderno.</p>
    </div>
    
    <div class="skills-container">
        <?php foreach ($skill_bars as $skill): ?>
            <div class="skill-item">
                <div class="skill-labels">
                    <span class="skill-name"><?php echo $skill['name']; ?></span>
                    <span class="skill-value"><?php echo $skill['percent']; ?>%</span>
                </div>
                <div class="skill-progress-bg">
                    <div class="skill-progress-bar" style="width: <?php echo $skill['percent']; ?>%"></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
