<?php $activePage = 'ordenes'; ?>
<?php require_once APP_ROOT . '/app/views/layouts/header.php'; ?>
<?php require_once APP_ROOT . '/app/views/layouts/sidebar.php'; ?>

<div id="main">

    <!-- Toast -->
    <div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 9999">
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
                <div class="page-heading col-md-7">
                    <h3> Órdenes de Trabajo
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </h3>
                    <p class="text-subtitle text-muted">Gestión de órdenes de reparación</p>
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





        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">

                </div>
            </div>
        </div>


        <!-- inicia tabla de ordenes -->
        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="col-md-4 p-0">
                        <h5 class="mb-0">
                            <i class="fa-solid fa-list-check me-2"></i>
                            Listado de Órdenes
                        </h5>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <div class="search-box">
                            <input type="text" class="form-control form-control-sm table-search-manual"
                                placeholder="Buscar...">
                        </div>

                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevaOrden">
                            <i class="fa-solid fa-file-circle-plus me-2"></i>
                            Nueva Orden de Trabajo
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-center" id="tablaOrdenes">
                            <thead>
                                <tr>
                                    <th><i class="fa-solid fa-hashtag"></i> Folio</th>
                                    <th><i class="fa-solid fa-user"></i> Cliente</th>
                                    <th><i class="fa-solid fa-wave-square"></i> Marca</th>
                                    <th><i class="fa-solid fa-mobile-screen-button"></i> Modelo</th>
                                    <th><i class="fa-solid fa-wrench"></i> Estado</th>
                                    <th><i class="fa-solid fa-circle-dollar-to-slot"></i> Costo Final</th>
                                    <th><i class="fa-solid fa-calendar-plus"></i> Fecha Ingreso</th>
                                    <th><i class="fa-solid fa-calendar-check"></i> Entrega Estimada</th>
                                    <th><i class="fa-solid fa-bars"></i> Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($ordenes)): ?>
                                    <?php foreach ($ordenes as $o): ?>
                                        <tr>
                                            <td><span class="badge bg-primary"><?= $o->folio ?></span></td>
                                            <td><?= htmlspecialchars($o->cliente_nombre) ?></td>
                                            <td><?= htmlspecialchars($o->marca) ?></td>
                                            <td><?= htmlspecialchars($o->modelo) ?></td>
                                            <td>
                                                <?php
                                                $badges = [
                                                    'Recibido'       => 'secondary',
                                                    'En reparación'  => 'danger',
                                                    'Listo'          => 'success',
                                                    'Entregado'      => 'primary',
                                                ];
                                                $badge = $badges[$o->estado] ?? 'secondary';
                                                ?>
                                                <span class="badge bg-<?= $badge ?>"><?= $o->estado ?></span>
                                            </td>
                                            <td>$<?= number_format($o->costo_final, 2) ?></td>
                                            <td><?= date('d/m/Y', strtotime($o->fecha_ingreso)) ?></td>
                                            <td><?= $o->fecha_entrega_estimada ? date('d/m/Y', strtotime($o->fecha_entrega_estimada)) : '-' ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary btn-ver"
                                                    data-id="<?= $o->id ?>">
                                                    <i class="bi bi-eye-fill"></i>
                                                </button>
                                                <button class="btn btn-sm btn-primary btn-editar"
                                                    data-id="<?= $o->id ?>"
                                                    data-cliente="<?= $o->cliente_id ?>"
                                                    data-marca="<?= htmlspecialchars($o->marca) ?>"
                                                    data-modelo="<?= htmlspecialchars($o->modelo) ?>"
                                                    data-falla="<?= htmlspecialchars($o->falla_reportada) ?>"
                                                    data-detalles="<?= htmlspecialchars($o->detalles) ?>"
                                                    data-anticipo="<?= $o->anticipo ?>"
                                                    data-costo_estimado="<?= $o->costo_estimado ?>"
                                                    data-costo_final="<?= $o->costo_final ?>"
                                                    data-estado="<?= $o->estado ?>"
                                                    data-fecha="<?= $o->fecha_entrega_estimada ?>">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>

                                                <?php if (Auth::esAdmin()): ?>
                                                    <button class="btn btn-sm btn-primary btn-eliminar"
                                                        data-id="<?= $o->id ?>"
                                                        data-folio="<?= $o->folio ?>">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                <?php endif; ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center">No hay órdenes registradas</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Modal Nueva Orden -->
<div class="modal fade" id="modalNuevaOrden" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-file-circle-plus fs-4 me-4"></i>
                    Nueva Orden de Trabajo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <i class="fa-solid fa-user me-1"></i>
                        <label class="form-label">Cliente <span class="text-danger">*</span></label>
                        <select class="form-select" id="nuevo_cliente_id">
                            <option value="">Seleccionar cliente...</option>
                            <?php foreach ($clientes as $c): ?>
                                <option value="<?= $c->id ?>" data-telefono="<?= htmlspecialchars($c->telefono) ?>">
                                    <?= htmlspecialchars($c->nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <i class="fa-solid fa-wave-square me-1"></i>
                        <label class="form-label">Marca <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nuevo_marca">
                    </div>
                    <div class="col-md-3 mb-3">
                        <i class="fa-solid fa-mobile-screen-button me-1"></i>
                        <label class="form-label">Modelo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nuevo_modelo">
                    </div>
                    <div class="col-md-12 mb-3">
                        <i class="fa-solid fa-wrench me-1"></i>
                        <label class="form-label">Falla Reportada <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="nuevo_falla" rows="2"></textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <i class="fa-solid fa-circle-info me-1"></i>
                        <label class="form-label">Detalles</label>
                        <textarea class="form-control" id="nuevo_detalles" rows="2"></textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <i class="fa-solid fa-hand-holding-dollar me-1"></i>
                        <label class="form-label">Anticipo</label>
                        <input type="number" class="form-control" id="nuevo_anticipo" min="0" step="0.01" value="0">
                    </div>
                    <div class="col-md-4 mb-3">
                        <i class="fa-solid fa-circle-dollar-to-slot me-1"></i>
                        <label class="form-label">Costo Estimado</label>
                        <input type="number" class="form-control" id="nuevo_costo_estimado" min="0" step="0.01">
                    </div>
                    <div class="col-md-4 mb-3">
                        <i class="fa-solid fa-circle-dollar-to-slot me-1"></i>
                        <label class="form-label">Costo Final</label>
                        <input type="number" class="form-control" id="nuevo_costo_final" min="0" step="0.01">
                    </div>
                    <div class="col-md-6 mb-3">
                        <i class="fa-solid fa-calendar-check me-1"></i>
                        <label class="form-label">Fecha Entrega Estimada</label>
                        <input type="date" class="form-control" id="nuevo_fecha_entrega">
                    </div>
                    <div class="col-md-6 mb-3">
                        <i class="fa-solid fa-list-ul me-1"></i>
                        <label class="form-label">Estado</label>
                        <select class="form-select" id="nuevo_estado">
                            <option value="Recibido">Recibido</option>
                            <option value="En reparación">En reparación</option>
                            <option value="Listo">Listo</option>
                            <option value="Entregado">Entregado</option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarOrden">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Orden -->
<div class="modal fade" id="modalEditarOrden" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-file-pen fs-4 me-3"></i>
                    Editar Orden de Trabajo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editar_id">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <i class="fa-solid fa-user me-1"></i>
                        <label class="form-label">Cliente <span class="text-danger">*</span></label>
                        <select class="form-select" id="editar_cliente_id">
                            <option value="">Seleccionar cliente...</option>
                            <?php foreach ($clientes as $c): ?>
                                <option value="<?= $c->id ?>" data-telefono="<?= htmlspecialchars($c->telefono) ?>">
                                    <?= htmlspecialchars($c->nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <i class="fa-solid fa-wave-square me-1"></i>
                        <label class="form-label">Marca <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editar_marca">
                    </div>
                    <div class="col-md-3 mb-3">
                        <i class="fa-solid fa-mobile-screen-button me-1"></i>
                        <label class="form-label">Modelo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editar_modelo">
                    </div>
                    <div class="col-md-12 mb-3">
                        <i class="fa-solid fa-wrench me-1"></i>
                        <label class="form-label">Falla Reportada <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="editar_falla" rows="2"></textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <i class="fa-solid fa-circle-info me-1"></i>
                        <label class="form-label">Detalles</label>
                        <textarea class="form-control" id="editar_detalles" rows="2"></textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <i class="fa-solid fa-hand-holding-dollar me-1"></i>
                        <label class="form-label">Anticipo</label>
                        <input type="number" class="form-control" id="editar_anticipo" min="0" step="0.01" value="0">
                    </div>
                    <div class="col-md-4 mb-3">
                        <i class="fa-solid fa-circle-dollar-to-slot me-1"></i>
                        <label class="form-label">Costo Estimado</label>
                        <input type="number" class="form-control" id="editar_costo_estimado" min="0" step="0.01">
                    </div>
                    <div class="col-md-4 mb-3">
                        <i class="fa-solid fa-circle-dollar-to-slot me-1"></i>
                        <label class="form-label">Costo Final</label>
                        <input type="number" class="form-control" id="editar_costo_final" min="0" step="0.01">
                    </div>
                    <div class="col-md-6 mb-3">
                        <i class="fa-solid fa-calendar-check me-1"></i>
                        <label class="form-label">Fecha Entrega Estimada</label>
                        <input type="date" class="form-control" id="editar_fecha_entrega">
                    </div>
                    <div class="col-md-6 mb-3">
                        <i class="fa-solid fa-list-ul me-1"></i>
                        <label class="form-label">Estado</label>
                        <select class="form-select" id="editar_estado">
                            <option value="Recibido">Recibido</option>
                            <option value="En reparación">En reparación</option>
                            <option value="Listo">Listo</option>
                            <option value="Entregado">Entregado</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnActualizarOrden">
                    <i class="fa-solid fa-file-pen me-1"></i>
                    Actualizar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ver Orden -->
<div class="modal fade" id="modalVerOrden" tabindex="-1" aria-labelledby="modalVerOrdenLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 520px;">
        <div class="modal-content border-0 shadow-lg rounded-4">

            <div class="modal-header border-0 pb-0 px-4 pt-4 modal-ver-orden-header">
                <div class="w-100">
                    <div class="d-flex justify-content-center align-items-start flex-wrap gap-3">
                        <div>
                            <h3 class="modal-title mb-1 fw-extrabold" id="modalVerOrdenLabel">
                                <i class="fa-solid fa-screwdriver-wrench fs-3 me-4"></i>
                                Orden de Trabajo:
                                <span id="ver_folio" class="badge fs-6 text-center text-decoration-underline"></span>
                            </h3>
                            <br>
                        </div>

                    </div>
                </div>

            </div>

            <div class="modal-body px-4 py-4 modal-ver-orden-body">

                <div class="seccion-orden">
                    <div class="seccion-titulo">
                        <i class="fa-solid fa-user"></i>
                        <span>Datos del Cliente</span>
                    </div>

                    <div class="fila-dato">
                        <span class="dato-label">Nombre:</span>
                        <span class="dato-value" id="ver_cliente"></span>
                    </div>
                    <div class="fila-dato">
                        <span class="dato-label">Teléfono:</span>
                        <span class="dato-value" id="ver_telefono"></span>
                    </div>
                </div>

                <div class="seccion-orden">
                    <div class="seccion-titulo">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                        <span>Datos del Equipo</span>
                    </div>


                    <div class="fila-dato">
                        <span class="dato-label">Marca</span>
                        <span class="dato-value" id="ver_marca"></span>
                    </div>
                    <div class="fila-dato">
                        <span class="dato-label">Modelo</span>
                        <span class="dato-value" id="ver_modelo"></span>
                    </div>

                </div>

                <div class="seccion-orden">
                    <div class="seccion-titulo">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>Falla Reportada</span>
                    </div>
                    <div class="bloque-texto" id="ver_diagnostico"></div>
                </div>

                <div class="seccion-orden">
                    <div class="seccion-titulo">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                        <span>Diagnóstico</span>
                    </div>
                    <div class="bloque-texto" id="ver_servicio"></div>
                </div>

                <div class="seccion-orden">
                    <div class="seccion-titulo">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <span>Seguimiento</span>
                    </div>

                    <div class="fila-dato">
                        <span class="dato-label">Estado</span>
                        <span class="badge rounded-pill px-3 py-2 bg-warning text-dark" id="ver_estado"></span>
                    </div>
                    <div class="fila-dato">
                        <span class="dato-label">Fecha de ingreso</span>
                        <span class="dato-value" id="ver_fecha_ingreso"></span>
                    </div>
                    <div class="fila-dato">
                        <span class="dato-label">Fecha estimada</span>
                        <span class="dato-value" id="ver_fecha_estimada"></span>
                    </div>

                </div>

                <div class="seccion-orden">
                    <div class="seccion-titulo">
                        <i class="fa-solid fa-money-bill-wave"></i>
                        <span>Costos</span>
                    </div>

                    <div class="fila-dato">
                        <span class="dato-label">Anticipo</span>
                        <span class="dato-value" id="ver_anticipo"></span>
                    </div>
                    <div class="fila-dato">
                        <span class="dato-label">Total</span>
                        <span class="dato-value text-primary fw-bold" id="ver_total"></span>
                    </div>
                </div>


            </div>

            <div class="modal-footer border-0 px-4 pb-4 pt-0 justify-content-center">
                <button type="button" class="btn btn-primary rounded-3 px-4" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>







<!-- Modal Eliminar -->
<div class="modal fade" id="modalEliminarOrden" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-trash-can fs-4 me-3"></i>
                    Eliminar Orden de Trabajo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="eliminar_id">
                <p>¿Eliminar la orden <strong id="eliminar_folio"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmarEliminar">
                    <i class="fa-solid fa-trash-can me-1"></i>
                    Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script>
    const BASE_URL = '<?= BASE_URL ?>';

    function mostrarToast(mensaje) {
        document.getElementById('toastMensaje').textContent = mensaje;
        const toast = new bootstrap.Toast(document.getElementById('toastExito'));
        toast.show();
    }

    // buscador manual 
    document.querySelector('.table-search-manual').addEventListener('keyup', function() {
        const term = this.value.toLowerCase().trim();
        const rows = document.querySelectorAll('#tablaOrdenes tbody tr');
        let found = 0;
        rows.forEach(function(row) {
            const text = row.textContent.toLowerCase();
            if (text.includes(term)) {
                row.style.display = '';
                found++;
            } else {
                row.style.display = 'none';
            }
        });
        let noResults = document.querySelector('#tablaOrdenes .no-results');
        if (found === 0) {
            if (!noResults) {
                const tr = document.createElement('tr');
                tr.className = 'no-results';
                tr.innerHTML = `<td colspan="9" class="text-center py-3 text-muted">Sin resultados para "<strong>${term}</strong>"</td>`;
                document.querySelector('#tablaOrdenes tbody').appendChild(tr);
            }
        } else {
            if (noResults) noResults.remove();
        }
    });




    // Guardar nueva orden
    document.getElementById('btnGuardarOrden').addEventListener('click', function() {
        const cliente_id = document.getElementById('nuevo_cliente_id').value;
        const marca = document.getElementById('nuevo_marca').value.trim();
        const modelo = document.getElementById('nuevo_modelo').value.trim();
        const falla = document.getElementById('nuevo_falla').value.trim();
        if (!cliente_id || !marca || !modelo || !falla) {
            alert('Cliente, marca, modelo y falla son obligatorios');
            return;
        }
        $.ajax({
            url: BASE_URL + 'ordenes/guardar',
            method: 'POST',
            dataType: 'json',
            data: {
                cliente_id: cliente_id,
                marca: marca,
                modelo: modelo,
                falla_reportada: falla,
                detalles: document.getElementById('nuevo_detalles').value.trim(),
                anticipo: document.getElementById('nuevo_anticipo').value,
                costo_estimado: document.getElementById('nuevo_costo_estimado').value,
                costo_final: document.getElementById('nuevo_costo_final').value,
                estado: document.getElementById('nuevo_estado').value,
                fecha_entrega_estimada: document.getElementById('nuevo_fecha_entrega').value
            },
            success: function(res) {
                if (res.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalNuevaOrden'));
                    modal.hide();
                    document.getElementById('modalNuevaOrden').addEventListener('hidden.bs.modal', function() {
                        mostrarToast(res.mensaje);
                        setTimeout(() => location.reload(), 1000);
                    }, {
                        once: true
                    });
                } else {
                    alert(res.mensaje);
                }
            }
        });
    });

    // Abrir modal editar
    document.querySelectorAll('.btn-editar').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('editar_id').value = this.dataset.id;
            document.getElementById('editar_cliente_id').value = this.dataset.cliente;
            document.getElementById('editar_marca').value = this.dataset.marca;
            document.getElementById('editar_modelo').value = this.dataset.modelo;
            document.getElementById('editar_falla').value = this.dataset.falla;
            document.getElementById('editar_detalles').value = this.dataset.detalles;
            document.getElementById('editar_anticipo').value = this.dataset.anticipo;
            document.getElementById('editar_costo_estimado').value = this.dataset.costo_estimado;
            document.getElementById('editar_costo_final').value = this.dataset.costo_final;
            document.getElementById('editar_estado').value = this.dataset.estado;
            document.getElementById('editar_fecha_entrega').value = this.dataset.fecha;
            new bootstrap.Modal(document.getElementById('modalEditarOrden')).show();
        });
    });





    // Actualizar orden
    document.getElementById('btnActualizarOrden').addEventListener('click', function() {
        $.ajax({
            url: BASE_URL + 'ordenes/editar',
            method: 'POST',
            dataType: 'json',
            data: {
                id: document.getElementById('editar_id').value,
                cliente_id: document.getElementById('editar_cliente_id').value,
                marca: document.getElementById('editar_marca').value.trim(),
                modelo: document.getElementById('editar_modelo').value.trim(),
                falla_reportada: document.getElementById('editar_falla').value.trim(),
                detalles: document.getElementById('editar_detalles').value.trim(),
                anticipo: document.getElementById('editar_anticipo').value,
                costo_estimado: document.getElementById('editar_costo_estimado').value,
                costo_final: document.getElementById('editar_costo_final').value,
                estado: document.getElementById('editar_estado').value,
                fecha_entrega_estimada: document.getElementById('editar_fecha_entrega').value
            },
            success: function(res) {
                if (res.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarOrden'));
                    modal.hide();
                    document.getElementById('modalEditarOrden').addEventListener('hidden.bs.modal', function() {
                        mostrarToast(res.mensaje);

                        // Enviar WhatsApp si estado es Listo
                        const estado = document.getElementById('editar_estado').value;
                        if (estado === 'Listo') {
                            const nombre = document.getElementById('editar_cliente_id').options[document.getElementById('editar_cliente_id').selectedIndex].text;
                            const marca = document.getElementById('editar_marca').value.trim();
                            const modelo = document.getElementById('editar_modelo').value.trim();
                            const telefono = document.getElementById('editar_cliente_id').options[document.getElementById('editar_cliente_id').selectedIndex].dataset.telefono;

                            const mensaje = `Hola ${nombre}, Nos comunicamos de parte de Dr. Digital para informarle que su ${marca} ${modelo} ya está listo, ya puede pasar a recogerlo.`;
                            const url = `https://wa.me/52${telefono}?text=${encodeURIComponent(mensaje)}`;
                            window.open(url, '_blank');
                        }

                        setTimeout(() => location.reload(), 1000);
                    }, {
                        once: true
                    });
                } else {
                    alert(res.mensaje);
                }
            }
        });
    });

    // Ver orden

    document.querySelectorAll('.btn-ver').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;

            $.ajax({
                url: BASE_URL + 'ordenes/getOrden',
                method: 'POST',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function(o) {
                    document.getElementById('ver_folio').textContent = o.folio || '';
                    document.getElementById('ver_cliente').textContent = o.cliente_nombre || '';
                    document.getElementById('ver_telefono').textContent = o.telefono || '-';

                    document.getElementById('ver_telefono').textContent = o.cliente_telefono;


                    document.getElementById('ver_marca').textContent = o.marca || '-';
                    document.getElementById('ver_modelo').textContent = o.modelo || '-';


                    document.getElementById('ver_diagnostico').textContent = o.falla_reportada || '-';
                    document.getElementById('ver_servicio').textContent = o.detalles || '-';

                    document.getElementById('ver_estado').textContent = o.estado || '-';
                    document.getElementById('ver_fecha_ingreso').textContent = o.fecha_ingreso || '-';
                    document.getElementById('ver_fecha_estimada').textContent = o.fecha_entrega_estimada || '-';

                    document.getElementById('ver_anticipo').textContent = '$' + parseFloat(o.anticipo).toFixed(2);
                    document.getElementById('ver_total').textContent = '$' + (parseFloat(o.costo_final || 0).toFixed(2));


                    new bootstrap.Modal(document.getElementById('modalVerOrden')).show();
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener la orden:', error);
                }
            });
        });
    });








    // Abrir modal eliminar
    document.querySelectorAll('.btn-eliminar').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('eliminar_id').value = this.dataset.id;
            document.getElementById('eliminar_folio').textContent = this.dataset.folio;
            new bootstrap.Modal(document.getElementById('modalEliminarOrden')).show();
        });
    });

    // Confirmar eliminar
    document.getElementById('btnConfirmarEliminar').addEventListener('click', function() {
        $.ajax({
            url: BASE_URL + 'ordenes/eliminar',
            method: 'POST',
            dataType: 'json',
            data: {
                id: document.getElementById('eliminar_id').value
            },
            success: function(res) {
                if (res.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalEliminarOrden'));
                    modal.hide();
                    document.getElementById('modalEliminarOrden').addEventListener('hidden.bs.modal', function() {
                        mostrarToast(res.mensaje);
                        setTimeout(() => location.reload(), 1000);
                    }, {
                        once: true
                    });
                } else {
                    alert(res.mensaje);
                }
            }
        });
    });

    // Ordenamiento de tabla
    document.querySelectorAll('#tablaOrdenes th').forEach(function(th, index) {
        // La última columna (Acciones) no se ordena
        if (index === 8) return;

        th.style.cursor = 'pointer';
        th.dataset.orden = 'asc';
        th.title = 'Click para ordenar';

        th.addEventListener('click', function() {
            const orden = this.dataset.orden;
            const tbody = document.querySelector('#tablaOrdenes tbody');
            const filas = Array.from(tbody.querySelectorAll('tr'));

            // Quitar indicadores previos
            document.querySelectorAll('#tablaOrdenes th').forEach(t => {
                t.innerHTML = t.innerHTML.replace(/ <i class="bi bi-caret-.*?"><\/i>/, '');
            });

            filas.sort(function(a, b) {
                const celdaA = a.querySelectorAll('td')[index]?.innerText.trim() || '';
                const celdaB = b.querySelectorAll('td')[index]?.innerText.trim() || '';

                // Detectar si es número o fecha
                const numA = parseFloat(celdaA.replace(/[$,]/g, ''));
                const numB = parseFloat(celdaB.replace(/[$,]/g, ''));
                const esNumero = !isNaN(numA) && !isNaN(numB);

                if (esNumero) {
                    return orden === 'asc' ? numA - numB : numB - numA;
                } else {
                    return orden === 'asc' ?
                        celdaA.localeCompare(celdaB, 'es') :
                        celdaB.localeCompare(celdaA, 'es');
                }
            });

            filas.forEach(fila => tbody.appendChild(fila));

            // Indicador visual
            const icono = orden === 'asc' ? 'bi-caret-up-fill' : 'bi-caret-down-fill';
            this.innerHTML += ` <i class="bi ${icono}"></i>`;
            this.dataset.orden = orden === 'asc' ? 'desc' : 'asc';
        });
    });
</script>

<?php require_once APP_ROOT . '/app/views/layouts/footer.php'; ?>