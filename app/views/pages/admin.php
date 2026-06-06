<?php
/**
 * Vista del Panel de Administración
 * Modo Login: formulario centrado de inicio de sesión
 * Modo Dashboard: gestión completa CRUD de actividades y miembros
 */
?>

<?php if (!$isLoggedIn): ?>
<!-- ====================================================== -->
<!-- FORMULARIO DE INICIO DE SESIÓN -->
<!-- ====================================================== -->
<div class="admin-login-wrapper">
    <div class="admin-login-card">
        <div class="login-logo">
            <img src="public/img/logo_club.png" alt="Logo SSC" class="login-logo-img">
        </div>
        <h2 class="login-title">Panel de Administración</h2>
        <p class="login-subtitle">Statistical Solutions Club - ESPOCH</p>
        
        <?php if (!empty($loginError)): ?>
            <div class="admin-alert admin-alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($loginError); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="?page=admin" class="login-form" autocomplete="off">
            <input type="hidden" name="action" value="login">
            <div class="admin-form-group">
                <label for="login-user"><i class="fas fa-user"></i> Usuario</label>
                <input type="text" id="login-user" name="usuario" placeholder="Ingrese su usuario" required autofocus>
            </div>
            <div class="admin-form-group">
                <label for="login-pass"><i class="fas fa-lock"></i> Contraseña</label>
                <div class="password-wrapper">
                    <input type="password" id="login-pass" name="password" placeholder="Ingrese su contraseña" required>
                    <button type="button" class="toggle-password" onclick="togglePasswordVisibility()">
                        <i class="fas fa-eye" id="eye-icon"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn-admin-login">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </button>
        </form>
        <p class="login-footer-text">Acceso exclusivo para administradores autorizados</p>
    </div>
</div>

<?php else: ?>
<!-- ====================================================== -->
<!-- DASHBOARD DE ADMINISTRACIÓN -->
<!-- ====================================================== -->
<div class="admin-dashboard">
    <!-- Barra superior del admin -->
    <header class="admin-topbar">
        <div class="admin-topbar-left">
            <img src="public/img/logo_club.png" alt="Logo" class="admin-topbar-logo">
            <div>
                <h1 class="admin-topbar-title">Panel de Administración</h1>
                <p class="admin-topbar-sub">Statistical Solutions Club</p>
            </div>
        </div>
        <div class="admin-topbar-right">
            <span class="admin-user-badge">
                <i class="fas fa-user-shield"></i> <?php echo htmlspecialchars($dashboardData['admin_user'] ?? 'Admin'); ?>
            </span>
            <form method="POST" action="?page=admin" style="display:inline;">
                <input type="hidden" name="action" value="logout">
                <button type="submit" class="btn-admin-logout">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </button>
            </form>
            <a href="?page=home" class="btn-admin-back" title="Volver al sitio público">
                <i class="fas fa-globe"></i> Ver Sitio
            </a>
        </div>
    </header>

    <!-- Mensajes de éxito/notificación -->
    <?php if (!empty($msg)): ?>
        <div class="admin-alert admin-alert-success">
            <i class="fas fa-check-circle"></i>
            <?php 
                $msgs = [
                    'creado' => '¡Registro creado exitosamente!',
                    'actualizado' => '¡Registro actualizado exitosamente!',
                    'eliminado' => '¡Registro eliminado exitosamente!',
                    'imagen_eliminada' => '¡Imagen eliminada exitosamente!'
                ];
                echo $msgs[$msg] ?? 'Operación realizada con éxito.';
            ?>
        </div>
    <?php endif; ?>

    <!-- Pestañas de Navegación -->
    <div class="admin-tabs">
        <a href="?page=admin&tab=actividades" class="admin-tab <?php echo ($activeTab === 'actividades') ? 'active' : ''; ?>">
            <i class="fas fa-project-diagram"></i> Actividades
        </a>
        <a href="?page=admin&tab=miembros" class="admin-tab <?php echo ($activeTab === 'miembros') ? 'active' : ''; ?>">
            <i class="fas fa-users"></i> Miembros
        </a>
    </div>

    <!-- Contenido de la Pestaña Activa -->
    <div class="admin-content">

        <?php if ($activeTab === 'actividades'): ?>
        <!-- ====================================================== -->
        <!-- GESTIÓN DE ACTIVIDADES -->
        <!-- ====================================================== -->
        
        <?php if ($editActividad): ?>
        <!-- Formulario de Edición de Actividad -->
        <div class="admin-panel-card">
            <div class="admin-panel-header">
                <h3><i class="fas fa-edit"></i> Editar Actividad</h3>
                <a href="?page=admin&tab=actividades" class="btn-admin-sm btn-admin-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
            <form method="POST" action="?page=admin" enctype="multipart/form-data" class="admin-form">
                <input type="hidden" name="action" value="editar_actividad">
                <input type="hidden" name="id" value="<?php echo $editActividad['id']; ?>">
                
                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label>Título de la Actividad</label>
                        <input type="text" name="titulo" value="<?php echo htmlspecialchars($editActividad['titulo']); ?>" required>
                    </div>
                    <div class="admin-form-group">
                        <label>Año</label>
                        <input type="number" name="anio" value="<?php echo $editActividad['anio']; ?>" min="2020" max="2030" required>
                    </div>
                </div>
                
                <div class="admin-form-group">
                    <label>Descripción</label>
                    <textarea name="descripcion" rows="4" required><?php echo htmlspecialchars($editActividad['descripcion']); ?></textarea>
                </div>
                
                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label>Estado</label>
                        <select name="estado" required>
                            <option value="realizada" <?php echo $editActividad['estado'] === 'realizada' ? 'selected' : ''; ?>>Realizada</option>
                            <option value="por_realizar" <?php echo $editActividad['estado'] === 'por_realizar' ? 'selected' : ''; ?>>Por Realizar</option>
                        </select>
                    </div>
                    <div class="admin-form-group">
                        <label>Fecha de Actividad</label>
                        <input type="date" name="fecha_actividad" value="<?php echo $editActividad['fecha_actividad']; ?>">
                    </div>
                </div>

                <!-- Imágenes existentes -->
                <?php if (!empty($editActividad['imagenes'])): ?>
                <div class="admin-form-group">
                    <label>Imágenes Actuales</label>
                    <div class="admin-images-grid">
                        <?php foreach ($editActividad['imagenes'] as $img): ?>
                            <div class="admin-image-item">
                                <img src="<?php echo htmlspecialchars($img['ruta']); ?>" alt="Imagen de actividad">
                                <form method="POST" action="?page=admin" class="admin-img-delete-form">
                                    <input type="hidden" name="action" value="eliminar_imagen_actividad">
                                    <input type="hidden" name="img_id" value="<?php echo $img['id']; ?>">
                                    <input type="hidden" name="act_id" value="<?php echo $editActividad['id']; ?>">
                                    <button type="submit" class="btn-admin-img-delete" title="Eliminar imagen" onclick="return confirm('¿Eliminar esta imagen?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="admin-form-group">
                    <label>Agregar Nuevas Imágenes</label>
                    <input type="file" name="imagenes[]" multiple accept="image/*" class="admin-file-input">
                    <small class="admin-help-text">Puedes seleccionar varias imágenes a la vez (JPG, PNG, GIF, WEBP)</small>
                </div>
                
                <div class="admin-form-actions">
                    <button type="submit" class="btn-admin btn-admin-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                    <a href="?page=admin&tab=actividades" class="btn-admin btn-admin-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>

        <?php else: ?>
        <!-- Formulario de Creación de Actividad -->
        <div class="admin-panel-card">
            <div class="admin-panel-header">
                <h3><i class="fas fa-plus-circle"></i> Nueva Actividad</h3>
            </div>
            <form method="POST" action="?page=admin" enctype="multipart/form-data" class="admin-form" id="form-nueva-actividad">
                <input type="hidden" name="action" value="crear_actividad">
                
                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label>Título de la Actividad</label>
                        <input type="text" name="titulo" placeholder="Ej: Taller de Machine Learning" required>
                    </div>
                    <div class="admin-form-group">
                        <label>Año</label>
                        <input type="number" name="anio" value="<?php echo date('Y'); ?>" min="2020" max="2030" required>
                    </div>
                </div>
                
                <div class="admin-form-group">
                    <label>Descripción</label>
                    <textarea name="descripcion" rows="4" placeholder="Describa la actividad en detalle..." required></textarea>
                </div>
                
                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label>Estado</label>
                        <select name="estado" required>
                            <option value="por_realizar">Por Realizar</option>
                            <option value="realizada">Realizada</option>
                        </select>
                    </div>
                    <div class="admin-form-group">
                        <label>Fecha de Actividad</label>
                        <input type="date" name="fecha_actividad">
                    </div>
                </div>
                
                <div class="admin-form-group">
                    <label>Imágenes</label>
                    <input type="file" name="imagenes[]" multiple accept="image/*" class="admin-file-input">
                    <small class="admin-help-text">Puedes seleccionar varias imágenes a la vez (JPG, PNG, GIF, WEBP)</small>
                </div>
                
                <div class="admin-form-actions">
                    <button type="submit" class="btn-admin btn-admin-primary">
                        <i class="fas fa-plus"></i> Crear Actividad
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabla de Actividades Existentes -->
        <div class="admin-panel-card">
            <div class="admin-panel-header">
                <h3><i class="fas fa-list"></i> Actividades Registradas (<?php echo count($dashboardData['actividades']); ?>)</h3>
            </div>
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Año</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Imágenes</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($dashboardData['actividades'])): ?>
                            <tr><td colspan="7" class="admin-no-data">No hay actividades registradas.</td></tr>
                        <?php else: ?>
                            <?php foreach ($dashboardData['actividades'] as $act): ?>
                                <tr>
                                    <td><span class="admin-id-badge">#<?php echo $act['id']; ?></span></td>
                                    <td class="admin-td-title"><?php echo htmlspecialchars($act['titulo']); ?></td>
                                    <td><span class="admin-year-badge"><?php echo $act['anio']; ?></span></td>
                                    <td>
                                        <span class="admin-status-badge <?php echo $act['estado'] === 'realizada' ? 'badge-success' : 'badge-warning'; ?>">
                                            <?php echo $act['estado'] === 'realizada' ? 'Realizada' : 'Por Realizar'; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $act['fecha_actividad'] ? date('d/m/Y', strtotime($act['fecha_actividad'])) : '—'; ?></td>
                                    <td>
                                        <span class="admin-count-badge">
                                            <i class="fas fa-image"></i> <?php echo count($act['imagenes']); ?>
                                        </span>
                                    </td>
                                    <td class="admin-td-actions">
                                        <a href="?page=admin&tab=actividades&edit=<?php echo $act['id']; ?>" class="btn-admin-sm btn-admin-edit" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="?page=admin" style="display:inline;" onsubmit="return confirm('¿Está seguro de eliminar esta actividad? Se eliminarán también todas las imágenes asociadas.')">
                                            <input type="hidden" name="action" value="eliminar_actividad">
                                            <input type="hidden" name="id" value="<?php echo $act['id']; ?>">
                                            <button type="submit" class="btn-admin-sm btn-admin-delete" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

        <?php elseif ($activeTab === 'miembros'): ?>
        <!-- ====================================================== -->
        <!-- GESTIÓN DE MIEMBROS -->
        <!-- ====================================================== -->
        
        <?php if ($editMiembro): ?>
        <!-- Formulario de Edición de Miembro -->
        <div class="admin-panel-card">
            <div class="admin-panel-header">
                <h3><i class="fas fa-user-edit"></i> Editar Miembro</h3>
                <a href="?page=admin&tab=miembros" class="btn-admin-sm btn-admin-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
            <form method="POST" action="?page=admin" enctype="multipart/form-data" class="admin-form">
                <input type="hidden" name="action" value="editar_miembro">
                <input type="hidden" name="id" value="<?php echo $editMiembro['id']; ?>">

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label>Nombre Completo</label>
                        <input type="text" name="nombre" value="<?php echo htmlspecialchars($editMiembro['nombre']); ?>" required>
                    </div>
                    <div class="admin-form-group">
                        <label>Cargo</label>
                        <input type="text" name="cargo" value="<?php echo htmlspecialchars($editMiembro['cargo']); ?>" required>
                    </div>
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label>Tipo</label>
                        <select name="tipo" required>
                            <option value="directivo" <?php echo $editMiembro['tipo'] === 'directivo' ? 'selected' : ''; ?>>Directivo</option>
                            <option value="asesor" <?php echo $editMiembro['tipo'] === 'asesor' ? 'selected' : ''; ?>>Asesor</option>
                        </select>
                    </div>
                    <div class="admin-form-group">
                        <label>Orden de Aparición</label>
                        <input type="number" name="orden" value="<?php echo $editMiembro['orden']; ?>" min="0" max="99">
                    </div>
                </div>

                <!-- Imagen actual -->
                <div class="admin-form-group">
                    <label>Imagen Actual</label>
                    <div class="admin-current-image">
                        <img src="<?php echo htmlspecialchars($editMiembro['ruta_imagen']); ?>" alt="<?php echo htmlspecialchars($editMiembro['nombre']); ?>">
                    </div>
                </div>
                
                <div class="admin-form-group">
                    <label>Cambiar Imagen (opcional)</label>
                    <input type="file" name="imagen" accept="image/*" class="admin-file-input">
                    <small class="admin-help-text">Deje vacío para mantener la imagen actual</small>
                </div>
                
                <div class="admin-form-actions">
                    <button type="submit" class="btn-admin btn-admin-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                    <a href="?page=admin&tab=miembros" class="btn-admin btn-admin-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>

        <?php else: ?>
        <!-- Formulario de Creación de Miembro -->
        <div class="admin-panel-card">
            <div class="admin-panel-header">
                <h3><i class="fas fa-user-plus"></i> Nuevo Miembro</h3>
            </div>
            <form method="POST" action="?page=admin" enctype="multipart/form-data" class="admin-form">
                <input type="hidden" name="action" value="crear_miembro">
                
                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label>Nombre Completo</label>
                        <input type="text" name="nombre" placeholder="Ej: Juan Pérez" required>
                    </div>
                    <div class="admin-form-group">
                        <label>Cargo</label>
                        <input type="text" name="cargo" placeholder="Ej: Presidente, Apoyo Docente..." required>
                    </div>
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label>Tipo</label>
                        <select name="tipo" required>
                            <option value="directivo">Directivo</option>
                            <option value="asesor">Asesor</option>
                        </select>
                    </div>
                    <div class="admin-form-group">
                        <label>Orden de Aparición</label>
                        <input type="number" name="orden" value="0" min="0" max="99">
                    </div>
                </div>
                
                <div class="admin-form-group">
                    <label>Imagen del Miembro</label>
                    <input type="file" name="imagen" accept="image/*" class="admin-file-input">
                    <small class="admin-help-text">Si no se selecciona, se usará un avatar por defecto</small>
                </div>
                
                <div class="admin-form-actions">
                    <button type="submit" class="btn-admin btn-admin-primary">
                        <i class="fas fa-plus"></i> Agregar Miembro
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabla de Miembros Existentes -->
        <div class="admin-panel-card">
            <div class="admin-panel-header">
                <h3><i class="fas fa-users-cog"></i> Miembros Registrados (<?php echo count($dashboardData['miembros']); ?>)</h3>
            </div>
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>Cargo</th>
                            <th>Tipo</th>
                            <th>Orden</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($dashboardData['miembros'])): ?>
                            <tr><td colspan="7" class="admin-no-data">No hay miembros registrados.</td></tr>
                        <?php else: ?>
                            <?php foreach ($dashboardData['miembros'] as $m): ?>
                                <tr>
                                    <td><span class="admin-id-badge">#<?php echo $m['id']; ?></span></td>
                                    <td>
                                        <img src="<?php echo htmlspecialchars($m['ruta_imagen']); ?>" alt="<?php echo htmlspecialchars($m['nombre']); ?>" class="admin-table-avatar">
                                    </td>
                                    <td class="admin-td-title"><?php echo htmlspecialchars($m['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($m['cargo']); ?></td>
                                    <td>
                                        <span class="admin-type-badge <?php echo $m['tipo'] === 'asesor' ? 'badge-asesor' : 'badge-directivo'; ?>">
                                            <?php echo $m['tipo'] === 'asesor' ? 'Asesor' : 'Directivo'; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $m['orden']; ?></td>
                                    <td class="admin-td-actions">
                                        <a href="?page=admin&tab=miembros&edit_miembro=<?php echo $m['id']; ?>" class="btn-admin-sm btn-admin-edit" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="?page=admin" style="display:inline;" onsubmit="return confirm('¿Está seguro de eliminar a este miembro?')">
                                            <input type="hidden" name="action" value="eliminar_miembro">
                                            <input type="hidden" name="id" value="<?php echo $m['id']; ?>">
                                            <button type="submit" class="btn-admin-sm btn-admin-delete" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
