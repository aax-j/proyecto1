<?php
/**
 * Vista - Actividades y Proyectos (Realizados y Por Realizar)
 * Se conecta y visualiza datos dinámicos desde la base de datos MySQL
 */
?>
<div class="actividades-wrapper">
    <!-- Barra de Filtros Interactivos -->
    <div class="actividades-filters">
        <div class="filter-group">
            <span class="filter-label"><i class="fas fa-calendar-alt"></i> Año:</span>
            <div class="filter-buttons" id="year-filters">
                <button class="btn-filter active" data-filter="year" data-value="all">Todos</button>
                <?php if (!empty($anios)): ?>
                    <?php foreach ($anios as $year): ?>
                        <button class="btn-filter" data-filter="year" data-value="<?php echo $year; ?>"><?php echo $year; ?></button>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="filter-group">
            <span class="filter-label"><i class="fas fa-filter"></i> Estado:</span>
            <div class="filter-buttons" id="status-filters">
                <button class="btn-filter active" data-filter="status" data-value="all">Todas</button>
                <button class="btn-filter" data-filter="status" data-value="realizada">Realizadas</button>
                <button class="btn-filter" data-filter="status" data-value="por_realizar">Por Realizar</button>
            </div>
        </div>
    </div>

    <!-- Contenedor del Listado y Línea de Tiempo -->
    <div class="actividades-timeline" id="actividades-list">
        <?php if (empty($actividades_por_anio)): ?>
            <div class="no-data-card">
                <i class="fas fa-database"></i>
                <h3>No se encontraron actividades</h3>
                <p>La base de datos se encuentra vacía o el servidor MySQL está apagado. Ejecuta el script `db/schema.sql` para poblar las tablas.</p>
            </div>
        <?php else: ?>
            <?php foreach ($actividades_por_anio as $anio => $actividades): ?>
                <div class="anio-section" data-anio-section="<?php echo $anio; ?>">
                    <h2 class="anio-title"><i class="fas fa-calendar-check"></i> Actividades del Año <?php echo $anio; ?></h2>
                    
                    <div class="cards-container">
                        <?php foreach ($actividades as $act): ?>
                            <div class="card activity-card" data-card-anio="<?php echo $act['anio']; ?>" data-card-estado="<?php echo $act['estado']; ?>">
                                
                                <!-- Encabezado de la Tarjeta -->
                                <div class="card-header <?php echo $act['estado'] === 'realizada' ? 'status-realizada' : 'status-por-realizar'; ?>">
                                    <h3><?php echo htmlspecialchars($act['titulo']); ?></h3>
                                    <span class="activity-badge">
                                        <?php echo $act['estado'] === 'realizada' ? '<i class="fas fa-check-circle"></i> Realizada' : '<i class="fas fa-hourglass-start"></i> Por Realizar'; ?>
                                    </span>
                                </div>
                                
                                <!-- Contenido de la Tarjeta -->
                                <div class="card-body">
                                    <p class="activity-desc"><?php echo nl2br(htmlspecialchars($act['descripcion'])); ?></p>
                                    
                                    <?php if (!empty($act['fecha_actividad'])): ?>
                                        <div class="activity-meta">
                                            <i class="far fa-calendar-alt"></i> Fecha: <span><?php echo date('d/m/Y', strtotime($act['fecha_actividad'])); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Sección de Imágenes (Imagen o Imágenes) -->
                                    <h4 class="gallery-title"><i class="far fa-images"></i> Registro Visual:</h4>
                                    <?php if (!empty($act['imagenes'])): ?>
                                        <div class="activity-gallery <?php echo count($act['imagenes']) === 1 ? 'single-image' : 'multiple-images'; ?>">
                                            <?php foreach ($act['imagenes'] as $idx => $ruta): ?>
                                                <div class="gallery-item" onclick="openLightbox('<?php echo htmlspecialchars($ruta); ?>', '<?php echo htmlspecialchars($act['titulo']); ?>')">
                                                    <img src="<?php echo htmlspecialchars($ruta); ?>" alt="Foto <?php echo $idx+1; ?> - <?php echo htmlspecialchars($act['titulo']); ?>" class="gallery-img">
                                                    <div class="gallery-overlay">
                                                        <i class="fas fa-expand-alt"></i>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="no-images">
                                            <i class="fas fa-image"></i>
                                            <p>No se cargaron fotografías para este registro.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- MODAL LIGHTBOX DE IMÁGENES (PREMIUM) -->
<div id="imageLightbox" class="lightbox" onclick="closeLightbox()">
    <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
    <div class="lightbox-content-wrapper" onclick="event.stopPropagation()">
        <img id="lightbox-img" src="" alt="Ampliado" class="lightbox-img">
        <div id="lightbox-caption" class="lightbox-caption"></div>
    </div>
</div>
