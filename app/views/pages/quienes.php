<?php
/**
 * Vista – Quiénes Somos
 */
?>
<div class="quienes-wrapper">
    <!-- MISIÓN Y VISIÓN -->
    <div class="mision-vision-container">
        <div class="mv-item card-mv-left">
            <div class="mv-header-icon bg-primary">
                <i class="fas fa-bullseye"></i>
            </div>
            <h3>Nuestra Misión</h3>
            <p>Promover el interés y el conocimiento en estadística y análisis de datos entre sus miembros, la comunidad politécnica de la ESPOCH y la sociedad, impulsando la formación integral en métodos cuantitativos y tecnológicos.</p>
        </div>
        
        <div class="mv-item card-mv-right">
            <div class="mv-header-icon bg-secondary">
                <i class="fas fa-eye"></i>
            </div>
            <h3>Nuestra Visión</h3>
            <p>Consolidarnos como un grupo académico líder y referente dentro de la ESPOCH y la región, capacitando a los estudiantes en ciencia de datos e investigación aplicada, fomentando el autoaprendizaje y el trabajo colaborativo.</p>
        </div>
    </div>

    <!-- VALORES DEL CLUB -->
    <div class="values-wrapper">
        <h2 class="section-title">Valores que Nos Guían</h2>
        <div class="values-grid">
            <?php foreach ($values as $val): ?>
                <div class="value-card">
                    <div class="val-icon-box">
                        <i class="<?php echo $val['icon']; ?>"></i>
                    </div>
                    <h4><?php echo htmlspecialchars($val['title']); ?></h4>
                    <p><?php echo htmlspecialchars($val['desc']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- DIRECTIVA ESTUDIANTIL -->
    <div class="team-wrapper">
        <h2 class="section-title">Directiva Estudiantil</h2>
        <div class="team-grid">
            <?php foreach ($members as $member): ?>
                <div class="team-card">
                    <div class="team-img-container">
                        <img src="<?php echo htmlspecialchars($member['ruta_imagen']); ?>" alt="<?php echo htmlspecialchars($member['nombre']); ?>" class="team-img">
                    </div>
                    <div class="team-info">
                        <h4><?php echo htmlspecialchars($member['nombre']); ?></h4>
                        <p class="role-badge"><?php echo htmlspecialchars($member['cargo']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- DOCENTES ASESORES -->
    <div class="team-wrapper">
        <h2 class="section-title">Asesores Académicos</h2>
        <div class="team-grid advisor-grid">
            <?php foreach ($advisors as $adv): ?>
                <div class="team-card advisor-card">
                    <div class="team-img-container">
                        <img src="<?php echo htmlspecialchars($adv['ruta_imagen']); ?>" alt="<?php echo htmlspecialchars($adv['nombre']); ?>" class="team-img">
                    </div>
                    <div class="team-info">
                        <h4><?php echo htmlspecialchars($adv['nombre']); ?></h4>
                        <p class="role-badge advisor-badge"><?php echo htmlspecialchars($adv['cargo']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
