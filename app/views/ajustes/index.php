<?php $activePage = 'ajustes'; ?>
<?php require_once APP_ROOT . '/app/views/layouts/header.php'; ?>
<?php require_once APP_ROOT . '/app/views/layouts/sidebar.php'; ?>

<div id="main">

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <div id="toastExito" class="toast align-items-center text-bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body" id="toastMensaje">Operación exitosa</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class=" page-heading col-md-7">
                    <h3>Ajustes
                        <i class="bi bi-gear-fill"></i>
                    </h3>
                    <p class="text-subtitle text-muted mb-0">Configuración del sistema</p>
                </div>

                <div class="col-md-5 d-flex justify-content-end align-items-center gap-4 pe-5">

                    <!-- Notificaciones -->
                    <div class="dropdown d-flex align-items-center">
                        <a href="#" class="position-relative text-decoration-none d-flex align-items-center"
                            id="notifDropdown" data-bs-toggle="dropdown">
                            <i class="bi bi-bell-fill fs-4 text-primary"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                id="notifBadge" style="display:none; font-size:0.65rem;"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end shadow"
                            style="width:350px; max-height:450px; overflow-y:auto;">
                            <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                                <h6 class="mb-0 fw-bold">Notificaciones</h6>
                                <a href="#" class="small text-primary" id="btnMarcarTodas">Marcar todas leídas</a>
                            </div>
                            <div id="notifLista">
                                <div class="text-center py-3 text-muted small">Cargando...</div>
                            </div>
                        </div>
                    </div>

                    <!-- Usuario -->
                    <div class="dropdown d-flex align-items-center">
                        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center gap-2 p-30 m-110"
                            data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-4 me-3"></i>
                            <span class="fw-extrabold"><?= Auth::usuario() ?></span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Perfil</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="<?= BASE_URL ?>auth/logout">
                                    <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>








        <div class="row g-4 mt-1">

            <!-- Usuarios -->
            <div class="col-md-8">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>Usuarios</h5>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoUsuario">
                            <i class="bi bi-plus-circle me-1"></i>Nuevo Usuario
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover text-center">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Usuario</th>
                                        <th>Rol</th>
                                        <th>Último Acceso</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($usuarios as $u): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($u->nombre) ?></td>
                                            <td><span class="badge bg-secondary"><?= htmlspecialchars($u->usuario) ?></span></td>
                                            <td><span class="badge bg-<?= $u->rol == 'admin' ? 'primary' : 'info' ?>"><?= $u->rol ?></span></td>
                                            <td><?= $u->ultimo_acceso ? date('d/m/Y H:i', strtotime($u->ultimo_acceso)) : 'Nunca' ?></td>
                                            <td>
                                                <span class="badge bg-<?= $u->activo ? 'success' : 'danger' ?>">
                                                    <?= $u->activo ? 'Activo' : 'Inactivo' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-warning btn-editar-usuario"
                                                    data-id="<?= $u->id ?>"
                                                    data-nombre="<?= htmlspecialchars($u->nombre) ?>"
                                                    data-usuario="<?= htmlspecialchars($u->usuario) ?>"
                                                    data-rol="<?= $u->rol ?>">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>
                                                <button class="btn btn-sm btn-info btn-password-usuario"
                                                    data-id="<?= $u->id ?>"
                                                    data-nombre="<?= htmlspecialchars($u->nombre) ?>">
                                                    <i class="bi bi-key-fill"></i>
                                                </button>
                                                <?php if ($u->id != $_SESSION['usuario_id']): ?>
                                                    <button class="btn btn-sm btn-<?= $u->activo ? 'danger' : 'success' ?> btn-toggle-usuario"
                                                        data-id="<?= $u->id ?>"
                                                        data-activo="<?= $u->activo ?>">
                                                        <i class="bi bi-<?= $u->activo ? 'slash-circle' : 'check-circle' ?>-fill"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel derecho -->
            <div class="col-md-4">

                <!-- Mi contraseña -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-shield-lock-fill me-2"></i>Mi Contraseña</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Contraseña Actual</label>
                            <input type="password" class="form-control" id="mi_password_actual">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="mi_password_nueva">
                            <small class="text-muted">Mínimo 8 caracteres</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="mi_password_confirmar">
                        </div>
                        <button class="btn btn-primary w-100" id="btnMiPassword">
                            <i class="bi bi-shield-check me-1"></i>Actualizar Contraseña
                        </button>
                    </div>
                </div>

                <!-- Configuración general -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-gear-fill me-2"></i>Configuración General</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Tiempo de Sesión (horas)</label>
                            <input type="number" class="form-control" id="config_expiracion"
                                min="1" max="24"
                                value="<?= isset($_SESSION['config_expiracion']) ? $_SESSION['config_expiracion'] / 3600 : 8 ?>">
                            <small class="text-muted">Entre 1 y 24 horas</small>
                        </div>
                        <button class="btn btn-primary w-100" id="btnGuardarConfig">
                            <i class="bi bi-save me-1"></i>Guardar Configuración
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nuevo Usuario -->
<div class="modal fade" id="modalNuevoUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-plus-fill me-2"></i>Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nuevo_nombre">
                </div>
                <div class="mb-3">
                    <label class="form-label">Usuario <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nuevo_usuario">
                </div>
                <div class="mb-3">
                    <label class="form-label">Contraseña <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="nuevo_password">
                    <small class="text-muted">Mínimo 8 caracteres</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Rol</label>
                    <select class="form-select" id="nuevo_rol">
                        <option value="admin">Administrador</option>
                        <option value="tecnico">Técnico</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnCrearUsuario">Crear Usuario</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Usuario -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-gear me-2"></i>Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editar_id">
                <div class="mb-3">
                    <label class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="editar_nombre">
                </div>
                <div class="mb-3">
                    <label class="form-label">Usuario <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="editar_usuario">
                </div>
                <div class="mb-3">
                    <label class="form-label">Rol</label>
                    <select class="form-select" id="editar_rol">
                        <option value="admin">Administrador</option>
                        <option value="tecnico">Técnico</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" id="btnEditarUsuario">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cambiar Password Usuario -->
<div class="modal fade" id="modalPasswordUsuario" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-key-fill me-2"></i>Cambiar Contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="pass_usuario_id">
                <p class="text-muted small">Usuario: <strong id="pass_usuario_nombre"></strong></p>
                <div class="mb-3">
                    <label class="form-label">Nueva Contraseña</label>
                    <input type="password" class="form-control" id="pass_nueva">
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirmar</label>
                    <input type="password" class="form-control" id="pass_confirmar">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnCambiarPassword">Cambiar</button>
            </div>
        </div>
    </div>
</div>

<script>
    const BASE_URL = '<?= BASE_URL ?>';

    function mostrarToast(mensaje, tipo = 'success') {
        const toastEl = document.getElementById('toastExito');
        toastEl.className = `toast align-items-center text-bg-${tipo} border-0`;
        document.getElementById('toastMensaje').textContent = mensaje;
        new bootstrap.Toast(toastEl).show();
    }

    // Crear usuario
    document.getElementById('btnCrearUsuario').addEventListener('click', function() {
        $.ajax({
            url: BASE_URL + 'ajustes/crearUsuario',
            method: 'POST',
            dataType: 'json',
            data: {
                nombre: document.getElementById('nuevo_nombre').value.trim(),
                usuario: document.getElementById('nuevo_usuario').value.trim(),
                password: document.getElementById('nuevo_password').value,
                rol: document.getElementById('nuevo_rol').value
            },
            success: function(res) {
                if (res.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalNuevoUsuario'));
                    modal.hide();
                    document.getElementById('modalNuevoUsuario').addEventListener('hidden.bs.modal', function() {
                        mostrarToast(res.mensaje);
                        setTimeout(() => location.reload(), 800);
                    }, {
                        once: true
                    });
                } else {
                    mostrarToast(res.mensaje, 'danger');
                }
            }
        });
    });

    // Abrir editar
    document.querySelectorAll('.btn-editar-usuario').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('editar_id').value = this.dataset.id;
            document.getElementById('editar_nombre').value = this.dataset.nombre;
            document.getElementById('editar_usuario').value = this.dataset.usuario;
            document.getElementById('editar_rol').value = this.dataset.rol;
            new bootstrap.Modal(document.getElementById('modalEditarUsuario')).show();
        });
    });

    // Editar usuario
    document.getElementById('btnEditarUsuario').addEventListener('click', function() {
        $.ajax({
            url: BASE_URL + 'ajustes/editarUsuario',
            method: 'POST',
            dataType: 'json',
            data: {
                id: document.getElementById('editar_id').value,
                nombre: document.getElementById('editar_nombre').value.trim(),
                usuario: document.getElementById('editar_usuario').value.trim(),
                rol: document.getElementById('editar_rol').value
            },
            success: function(res) {
                if (res.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarUsuario'));
                    modal.hide();
                    document.getElementById('modalEditarUsuario').addEventListener('hidden.bs.modal', function() {
                        mostrarToast(res.mensaje);
                        setTimeout(() => location.reload(), 800);
                    }, {
                        once: true
                    });
                } else {
                    mostrarToast(res.mensaje, 'danger');
                }
            }
        });
    });

    // Abrir cambiar password usuario
    document.querySelectorAll('.btn-password-usuario').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('pass_usuario_id').value = this.dataset.id;
            document.getElementById('pass_usuario_nombre').textContent = this.dataset.nombre;
            document.getElementById('pass_nueva').value = '';
            document.getElementById('pass_confirmar').value = '';
            new bootstrap.Modal(document.getElementById('modalPasswordUsuario')).show();
        });
    });

    // Cambiar password usuario
    document.getElementById('btnCambiarPassword').addEventListener('click', function() {
        $.ajax({
            url: BASE_URL + 'ajustes/cambiarPassword',
            method: 'POST',
            dataType: 'json',
            data: {
                id: document.getElementById('pass_usuario_id').value,
                password: document.getElementById('pass_nueva').value,
                confirm: document.getElementById('pass_confirmar').value
            },
            success: function(res) {
                if (res.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalPasswordUsuario'));
                    modal.hide();
                    document.getElementById('modalPasswordUsuario').addEventListener('hidden.bs.modal', function() {
                        mostrarToast(res.mensaje);
                    }, {
                        once: true
                    });
                } else {
                    mostrarToast(res.mensaje, 'danger');
                }
            }
        });
    });

    // Toggle activo/inactivo
    document.querySelectorAll('.btn-toggle-usuario').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            $.ajax({
                url: BASE_URL + 'ajustes/toggleUsuario',
                method: 'POST',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function(res) {
                    if (res.success) {
                        mostrarToast(res.mensaje);
                        setTimeout(() => location.reload(), 800);
                    } else {
                        mostrarToast(res.mensaje, 'danger');
                    }
                }
            });
        });
    });

    // Mi contraseña
    document.getElementById('btnMiPassword').addEventListener('click', function() {
        $.ajax({
            url: BASE_URL + 'ajustes/miPassword',
            method: 'POST',
            dataType: 'json',
            data: {
                password_actual: document.getElementById('mi_password_actual').value,
                password_nueva: document.getElementById('mi_password_nueva').value,
                password_confirmar: document.getElementById('mi_password_confirmar').value
            },
            success: function(res) {
                if (res.success) {
                    document.getElementById('mi_password_actual').value = '';
                    document.getElementById('mi_password_nueva').value = '';
                    document.getElementById('mi_password_confirmar').value = '';
                    mostrarToast(res.mensaje);
                } else {
                    mostrarToast(res.mensaje, 'danger');
                }
            }
        });
    });

    // Guardar configuración
    document.getElementById('btnGuardarConfig').addEventListener('click', function() {
        $.ajax({
            url: BASE_URL + 'ajustes/guardarConfig',
            method: 'POST',
            dataType: 'json',
            data: {
                expiracion: document.getElementById('config_expiracion').value
            },
            success: function(res) {
                mostrarToast(res.mensaje, res.success ? 'success' : 'danger');
            }
        });
    });
</script>

<?php require_once APP_ROOT . '/app/views/layouts/footer.php'; ?>