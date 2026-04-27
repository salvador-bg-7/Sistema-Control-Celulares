<?php $activePage = 'gastos'; ?>
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
                    <h3>
                        Gastos
                        <i class="bi bi-cash-stack"></i>
                    </h3>
                    <p class="text-subtitle text-muted">Registro de gastos del taller</p>
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



        <section class="row mb-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 d-flex justify-content-center">
                                <div class="stats-icon red mb-2">
                                    <i class="fa-solid fa-arrow-trend-down"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-danger font-extrabold text-center">Gastos del Mes</h6>
                                <h6 class="font-extrabold mb-0 text-center text-danger">
                                    $<?= number_format($totalMes, 2) ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 d-flex justify-content-center">
                                <div class="stats-icon purple mb-2">
                                    <i class="fa-solid fa-money-bill-trend-up"></i>
                                </div>
                            </div>
                            <div class="col-md-8 text-center">
                                <h6 class="text-warning font-extrabold text-center">Gasto más Alto</h6>
                                <?php if ($gastoMasAlto): ?>
                                    <h6 class="font-extrabold mb-0 text-center text-warning">
                                        $<?= number_format($gastoMasAlto->monto, 2) ?>
                                    </h6>
                                    <small class="text-warning text-center">
                                        <?= htmlspecialchars($gastoMasAlto->concepto) ?></small>
                                <?php else: ?>
                                    <h6 class="font-extrabold mb-0 text-center text-danger">$0.00</h6>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 d-flex justify-content-center">
                                <div class="stats-icon blue mb-2">
                                    <i class="fa-solid fa-money-check-dollar"></i>
                                </div>
                            </div>
                            <div class="col-md-8 text-center">
                                <h6 class="text-primary font-semibold">Categoría Mayor Gasto</h6>
                                <?php if ($categoriaMas): ?>
                                    <h6 class="font-extrabold mb-0 text-center"><?= htmlspecialchars($categoriaMas->categoria) ?></h6>
                                    <small class="text-muted text-center">$<?= number_format($categoriaMas->total, 2) ?></small>
                                <?php else: ?>
                                    <h6 class="font-extrabold mb-0 text-center text-danger">Sin datos</h6>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="col-md-4 p-0">
                        <h5 class="mb-0">
                            <i class="fa-solid fa-list-ul"></i>
                            Listado de Gastos
                        </h5>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <div class="search-box">
                            <input type="text" class="form-control form-control-sm table-search-manual"
                                placeholder="Buscar...">
                        </div>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalNuevoGasto">
                            <i class="fa-solid fa-file-circle-plus fs-4 me-3"></i> Nuevo Gasto
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-center" id="tablaGastos">
                            <thead>
                                <tr>
                                    <th><i class="fa-solid fa-hashtag"></i> ID</th>
                                    <th><i class="fa-solid fa-file-pen"></i> Concepto</th>
                                    <th><i class="fa-solid fa-tag"></i> Categoría</th>
                                    <th><i class="fa-solid fa-coins"></i> Monto</th>
                                    <th><i class="fa-solid fa-credit-card"></i> Método Pago</th>
                                    <th><i class="fa-solid fa-calendar-days"></i> Fecha</th>
                                    <th><i class="fa-solid fa-sticky-note"></i> Notas</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($gastos)): ?>
                                    <?php foreach ($gastos as $g): ?>
                                        <tr>
                                            <td><?= $g->id ?></td>
                                            <td><?= htmlspecialchars($g->concepto) ?></td>
                                            <td><span class="badge bg-danger"><?= $g->categoria ?></span></td>
                                            <td class="text-primary fw-bold">$<?= number_format($g->monto, 2) ?></td>
                                            <td>
                                                <?php $badge = $g->metodo_pago == 'Efectivo' ? 'success' : 'dark'; ?>
                                                <span class="badge bg-<?= $badge ?>"><?= $g->metodo_pago ?></span>
                                            </td>
                                            <td><?= date('d/m/Y', strtotime($g->fecha)) ?></td>
                                            <td><?= htmlspecialchars($g->notas) ?: '-' ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary btn-editar"
                                                    data-id="<?= $g->id ?>"
                                                    data-concepto="<?= htmlspecialchars($g->concepto) ?>"
                                                    data-categoria="<?= $g->categoria ?>"
                                                    data-monto="<?= $g->monto ?>"
                                                    data-metodo="<?= $g->metodo_pago ?>"
                                                    data-fecha="<?= $g->fecha ?>"
                                                    data-notas="<?= htmlspecialchars($g->notas) ?>">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>
                                                <button class="btn btn-sm btn-primary btn-eliminar"
                                                    data-id="<?= $g->id ?>"
                                                    data-concepto="<?= htmlspecialchars($g->concepto) ?>">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No hay gastos registrados</td>
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

<!-- Modal Nuevo Gasto -->
<div class="modal fade" id="modalNuevoGasto" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-file-circle-plus fs-4 me-3"></i>
                    Nuevo Gasto
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <i class="fa-solid fa-file-pen"></i>
                    <label class="form-label">Concepto <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nuevo_concepto">
                </div>
                <div class="mb-3">
                    <i class="fa-solid fa-tag"></i>
                    <label class="form-label">Categoría <span class="text-danger">*</span></label>
                    <select class="form-select" id="nuevo_categoria">
                        <option value="">Seleccionar...</option>
                        <option value="Renta">Renta</option>
                        <option value="Servicios">Servicios</option>
                        <option value="Compra de refacciones">Compra de refacciones</option>
                        <option value="Herramientas">Herramientas</option>
                        <option value="Salarios">Salarios</option>
                        <option value="Otros">Otros</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <i class="fa-solid fa-coins"></i>
                        <label class="form-label">Monto <span class="text-info">*</span></label>
                        <input type="number" class="form-control" id="nuevo_monto" min="0" step="0.01">
                    </div>
                    <div class="col-md-6 mb-3">
                        <i class="fa-solid fa-credit-card"></i>
                        <label class="form-label">Método de Pago <span class="text-danger">*</span></label>
                        <select class="form-select" id="nuevo_metodo">
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia">Transferencia</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <i class="fa-solid fa-calendar-days"></i>
                    <label class="form-label">Fecha <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="nuevo_fecha" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="mb-3">
                    <i class="fa-solid fa-sticky-note"></i>
                    <label class="form-label">Notas</label>
                    <textarea class="form-control" id="nuevo_notas" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarGasto">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Gasto -->
<div class="modal fade" id="modalEditarGasto" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-file-pen fs-4 me-3"></i>
                    Editar Gasto
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editar_id">
                <div class="mb-3">
                    <i class="fa-solid fa-file-pen"></i>
                    <label class="form-label">Concepto <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="editar_concepto">
                </div>
                <div class="mb-3">
                    <i class="fa-solid fa-tag"></i>
                    <label class="form-label">Categoría <span class="text-danger">*</span></label>
                    <select class="form-select" id="editar_categoria">
                        <option value="Renta">Renta</option>
                        <option value="Servicios">Servicios</option>
                        <option value="Compra de refacciones">Compra de refacciones</option>
                        <option value="Herramientas">Herramientas</option>
                        <option value="Salarios">Salarios</option>
                        <option value="Otros">Otros</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <i class="fa-solid fa-coins"></i>
                        <label class="form-label">Monto <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="editar_monto" min="0" step="0.01">
                    </div>
                    <div class="col-md-6 mb-3">
                        <i class="fa-solid fa-credit-card"></i>
                        <label class="form-label">Método de Pago <span class="text-danger">*</span></label>
                        <select class="form-select" id="editar_metodo">
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia">Transferencia</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <i class="fa-solid fa-calendar-days"></i>
                    <label class="form-label">Fecha <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="editar_fecha">
                </div>
                <div class="mb-3">
                    <i class="fa-solid fa-sticky-note"></i>
                    <label class="form-label">Notas</label>
                    <textarea class="form-control" id="editar_notas" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnActualizarGasto">
                    <i class="fa-solid fa-file-pen fs-5 me-2"></i>
                    Actualizar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Eliminar -->
<div class="modal fade" id="modalEliminarGasto" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-trash-can fs-5 me-2"></i>
                    Eliminar Gasto
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="eliminar_id">
                <p>¿Eliminar el gasto <strong id="eliminar_concepto"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmarEliminar">
                    <i class="fa-solid fa-trash-can fs-5 me-2"></i>
                    Eliminar
                </button>
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

    // bucador manual tablaGastos
    document.querySelector('.table-search-manual').addEventListener('keyup', function() {
        const term = this.value.toLowerCase().trim();
        const rows = document.querySelectorAll('#tablaGastos tbody tr');
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
        let noResults = document.querySelector('#tablaGastos .no-results');
        if (found === 0) {
            if (!noResults) {
                const tr = document.createElement('tr');
                tr.className = 'no-results';
                tr.innerHTML = `<td colspan="7" class="text-center py-3 text-muted">Sin resultados para "<strong>${term}</strong>"</td>`;
                document.querySelector('#tablaGastos tbody').appendChild(tr);
            }
        } else {
            if (noResults) noResults.remove();
        }
    });




    document.getElementById('btnGuardarGasto').addEventListener('click', function() {
        const concepto = document.getElementById('nuevo_concepto').value.trim();
        const categoria = document.getElementById('nuevo_categoria').value;
        const monto = document.getElementById('nuevo_monto').value;
        const fecha = document.getElementById('nuevo_fecha').value;
        if (!concepto || !categoria || !monto || !fecha) {
            alert('Concepto, categoría, monto y fecha son obligatorios');
            return;
        }
        $.ajax({
            url: BASE_URL + 'gastos/guardar',
            method: 'POST',
            dataType: 'json',
            data: {
                concepto: concepto,
                categoria: categoria,
                monto: monto,
                metodo_pago: document.getElementById('nuevo_metodo').value,
                fecha: fecha,
                notas: document.getElementById('nuevo_notas').value.trim()
            },
            success: function(res) {
                if (res.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalNuevoGasto'));
                    modal.hide();
                    document.getElementById('modalNuevoGasto').addEventListener('hidden.bs.modal', function() {
                        mostrarToast(res.mensaje);
                        setTimeout(() => location.reload(), 800);
                    }, {
                        once: true
                    });
                } else {
                    alert(res.mensaje);
                }
            }
        });
    });

    document.querySelectorAll('.btn-editar').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('editar_id').value = this.dataset.id;
            document.getElementById('editar_concepto').value = this.dataset.concepto;
            document.getElementById('editar_categoria').value = this.dataset.categoria;
            document.getElementById('editar_monto').value = this.dataset.monto;
            document.getElementById('editar_metodo').value = this.dataset.metodo;
            document.getElementById('editar_fecha').value = this.dataset.fecha;
            document.getElementById('editar_notas').value = this.dataset.notas;
            new bootstrap.Modal(document.getElementById('modalEditarGasto')).show();
        });
    });

    document.getElementById('btnActualizarGasto').addEventListener('click', function() {
        $.ajax({
            url: BASE_URL + 'gastos/editar',
            method: 'POST',
            dataType: 'json',
            data: {
                id: document.getElementById('editar_id').value,
                concepto: document.getElementById('editar_concepto').value.trim(),
                categoria: document.getElementById('editar_categoria').value,
                monto: document.getElementById('editar_monto').value,
                metodo_pago: document.getElementById('editar_metodo').value,
                fecha: document.getElementById('editar_fecha').value,
                notas: document.getElementById('editar_notas').value.trim()
            },
            success: function(res) {
                if (res.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarGasto'));
                    modal.hide();
                    document.getElementById('modalEditarGasto').addEventListener('hidden.bs.modal', function() {
                        mostrarToast(res.mensaje);
                        setTimeout(() => location.reload(), 800);
                    }, {
                        once: true
                    });
                } else {
                    alert(res.mensaje);
                }
            }
        });
    });

    document.querySelectorAll('.btn-eliminar').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('eliminar_id').value = this.dataset.id;
            document.getElementById('eliminar_concepto').textContent = this.dataset.concepto;
            new bootstrap.Modal(document.getElementById('modalEliminarGasto')).show();
        });
    });

    document.getElementById('btnConfirmarEliminar').addEventListener('click', function() {
        $.ajax({
            url: BASE_URL + 'gastos/eliminar',
            method: 'POST',
            dataType: 'json',
            data: {
                id: document.getElementById('eliminar_id').value
            },
            success: function(res) {
                if (res.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalEliminarGasto'));
                    modal.hide();
                    document.getElementById('modalEliminarGasto').addEventListener('hidden.bs.modal', function() {
                        mostrarToast(res.mensaje);
                        setTimeout(() => location.reload(), 800);
                    }, {
                        once: true
                    });
                } else {
                    alert(res.mensaje);
                }
            }
        });
    });

    document.querySelectorAll('#tablaGastos th').forEach(function(th, index) {
        if (index === 7) return;
        th.style.cursor = 'pointer';
        th.dataset.orden = 'asc';
        th.addEventListener('click', function() {
            const orden = this.dataset.orden;
            const tbody = document.querySelector('#tablaGastos tbody');
            const filas = Array.from(tbody.querySelectorAll('tr'));
            document.querySelectorAll('#tablaGastos th').forEach(t => {
                t.innerHTML = t.innerHTML.replace(/ <i class="bi bi-caret-.*?"><\/i>/, '');
            });
            filas.sort(function(a, b) {
                const celdaA = a.querySelectorAll('td')[index]?.innerText.trim() || '';
                const celdaB = b.querySelectorAll('td')[index]?.innerText.trim() || '';
                const numA = parseFloat(celdaA.replace(/[$,]/g, ''));
                const numB = parseFloat(celdaB.replace(/[$,]/g, ''));
                const esNumero = !isNaN(numA) && !isNaN(numB);
                if (esNumero) {
                    return orden === 'asc' ? numA - numB : numB - numA;
                } else {
                    return orden === 'asc' ? celdaA.localeCompare(celdaB, 'es') : celdaB.localeCompare(celdaA, 'es');
                }
            });
            filas.forEach(fila => tbody.appendChild(fila));
            const icono = orden === 'asc' ? 'bi-caret-up-fill' : 'bi-caret-down-fill';
            this.innerHTML += ` <i class="bi ${icono}"></i>`;
            this.dataset.orden = orden === 'asc' ? 'desc' : 'asc';
        });
    });
</script>

<?php require_once APP_ROOT . '/app/views/layouts/footer.php'; ?>