<?php $activePage = 'caja'; ?>
<?php require_once APP_ROOT . '/app/views/layouts/header.php'; ?>
<?php require_once APP_ROOT . '/app/views/layouts/sidebar.php'; ?>

<div id="main">

    <!-- Toast -->
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
                    <h3>Caja
                        <i class="bi bi-cash-coin"></i>
                    </h3>
                    <p class="text-subtitle text-muted">Registro de cobros de órdenes de trabajo</p>
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



        <!-- Tarjetas resumen -->
        <section class="row mb-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body px-4">
                        <div class="row">
                            <div class="col-md-4 d-flex justify-content-center">
                                <div class="stats-icon green mb-2">
                                    <i class="fa-solid fa-money-bills"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-success font-extrabold text-center">
                                    Ingresos del Día</h6>
                                <h6 class="font-extrabold mb-0 text-success text-center">$<?= number_format($totalDia, 2) ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (Auth::esAdmin()): ?>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body px-4">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center ">
                                    <div class="stats-icon blue mb-2">
                                        <i class="fa-solid fa-money-check-dollar"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-primary font-extrabold text-center">
                                        Ingresos del Mes</h6>
                                    <h6 class="font-extrabold mb-0 text-center">$<?= number_format($totalMes, 2) ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body px-4">
                        <div class="row">
                            <div class="col-md-4 d-flex justify-content-center">
                                <div class="stats-icon red mb-2">
                                    <i class="fa-solid fa-file-invoice-dollar"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-danger font-extrabold text-center">
                                    Órdenes por Cobrar</h6>
                                <h6 class="font-extrabold mb-0 text-center text-danger"><?= count($ordenesListas) ?></h6>
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
                            <i class="fa-solid fa-money-bill-transfer"></i>
                            Historial de Cobros
                        </h5>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="search-box">
                            <input type="text" class="form-control form-control-sm table-search-manual"
                                placeholder="Buscar...">
                        </div>

                        <?php if (!empty($ordenesListas)): ?>
                            <button class="btn btn-success" id="btnAbrirCobrar">
                                <i class="bi bi-cash-coin fs-5 me-2"></i> Registrar Cobro
                            </button>
                        <?php else: ?>
                            <span class="text-primary font-extrabold">No hay órdenes listas por cobrar</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-center" id="tablaCaja">
                            <thead>
                                <tr>
                                    <th><i class="fa-solid fa-hashtag"></i> Folio</th>
                                    <th><i class="fa-solid fa-user"></i> Cliente</th>
                                    <th><i class="fa-solid fa-mobile-screen-button"></i> Equipo</th>
                                    <th><i class="fa-solid fa-coins"></i> Monto</th>
                                    <th><i class="fa-solid fa-credit-card"></i> Método Pago</th>
                                    <th><i class="fa-solid fa-calendar-check"></i> Fecha Cobro</th>
                                    <th><i class="fa-solid fa-sticky-note"></i> Notas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($cobros)): ?>
                                    <?php foreach ($cobros as $c): ?>
                                        <tr>
                                            <td><span class="badge bg-primary"><?= $c->folio ?></span></td>
                                            <td><?= htmlspecialchars($c->cliente_nombre) ?></td>
                                            <td><?= htmlspecialchars($c->marca) ?> <?= htmlspecialchars($c->modelo) ?></td>
                                            <td class="fw-bold text-primary">$<?= number_format($c->monto, 2) ?></td>
                                            <td>
                                                <?php $badgeMetodo = $c->metodo_pago == 'Efectivo' ? 'success' : 'secondary'; ?>
                                                <span class="badge bg-<?= $badgeMetodo ?>"><?= $c->metodo_pago ?></span>
                                            </td>
                                            <td><?= date('d/m/Y H:i', strtotime($c->fecha_cobro)) ?></td>
                                            <td><?= htmlspecialchars($c->notas) ?: '-' ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No hay cobros registrados</td>
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


<!-- Modal Cobrar -->
<div class="modal fade" id="modalCobrar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-receipt fs-3 me-2"></i>
                    Registrar Cobro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <!-- Selector orden -->
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-solid fa-file-circle-plus"></i>
                        Orden de Trabajo
                        <span class="text-danger">*</span></label>
                    <select class="form-select" id="cobrar_orden_id">
                        <option value="">Seleccionar orden...</option>
                        <?php foreach ($ordenesListas as $o): ?>
                            <option value="<?= $o->id ?>"
                                data-monto="<?= $o->costo_final ?>"
                                data-anticipo="<?= $o->anticipo ?>"
                                data-folio="<?= $o->folio ?>"
                                data-cliente="<?= htmlspecialchars($o->cliente_nombre) ?>"
                                data-equipo="<?= htmlspecialchars($o->marca) ?> <?= htmlspecialchars($o->modelo) ?>">
                                <?= $o->folio ?> — <?= htmlspecialchars($o->cliente_nombre) ?> | <?= htmlspecialchars($o->marca) ?> <?= htmlspecialchars($o->modelo) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Ticket (oculto hasta seleccionar orden) -->
                <div id="ticketCobro" style="display:none;">

                    <!-- Info orden -->
                    <div class="bg-primary rounded p-3 mb-3 text-center">
                        <h4 class="fw-estrabold mb-1 text-white"
                            id="ticket_folio">
                        </h4>
                        <hr class="my-2 border-light">
                        <div class="d-flex gap-2 align-items-center justify-content-center">
                            <i class="fa-solid fa-user text-white fs-4"></i>
                            <h6 class="text-white fs-5 mb-0" id="ticket_cliente"></h6>
                            <h6 class="text-white fs-5 mb-0"> - </h6>
                            <h6 class="text-white fs-5 mb-0" id="ticket_equipo"></h6>
                        </div>
                    </div>

                    <!-- Desglose -->
                    <div class="px-2">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-primary fw-semibold">
                                <i class="fa-solid fa-money-bills"></i>
                                Costo Total
                            </span>
                            <span class="fw-bold" id="ticket_total"></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-primary fw-semibold">
                                <i class="fa-solid fa-money-bill-1-wave"></i>
                                Anticipo
                            </span>
                            <span class="fw-bold text-primary" id="ticket_anticipo"></span>
                        </div>

                        <hr class="my-2">

                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-bold fs-5">
                                A Pagar</span>
                            <span class="fw-bold fs-5 text-primary" id="ticket_apagar"></span>
                        </div>

                        <hr class="my-2">

                        <!-- Monto editable -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fa-solid fa-money-check-dollar"></i>
                                Monto a Cobrar <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="cobrar_monto" min="0" step="0.01">
                            <small class="text-success">Puedes modificar si hay descuento o ajuste</small>
                        </div>

                        <!-- Método de pago -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fa-solid fa-credit-card"></i>
                                Método de Pago <span class="text-danger">*</span></label>
                            <select class="form-select" id="cobrar_metodo">
                                <option value="Efectivo">Efectivo</option>
                                <option value="Transferencia">Transferencia</option>
                            </select>
                        </div>

                        <!-- Notas -->
                        <div class="mb-2">
                            <label class="form-label fw-semibold">
                                <i class="fa-solid fa-note-sticky"></i>
                                Notas</label>
                            <textarea class="form-control" id="cobrar_notas" rows="2"></textarea>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnConfirmarCobro" style="display:none;">
                    <i class="bi bi-cash-coin me-1"></i>Confirmar Cobro
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

    // buscador manual
    document.querySelector('.table-search-manual').addEventListener('keyup', function() {
        const term = this.value.toLowerCase().trim();
        const rows = document.querySelectorAll('#tablaCaja tbody tr');
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
        let noResults = document.querySelector('#tablaCaja .no-results');
        if (found === 0) {
            if (!noResults) {
                const tr = document.createElement('tr');
                tr.className = 'no-results';
                tr.innerHTML = `<td colspan="5" class="text-center py-3 text-muted">Sin resultados para 
                "<strong>${term}</strong>"</td>`;
                document.querySelector('#tablaCaja tbody').appendChild(tr);
            }
        } else {
            if (noResults) noResults.remove();
        }
    });






    // Autocompletar monto al seleccionar orden
    document.getElementById('cobrar_orden_id').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const ticket = document.getElementById('ticketCobro');
        const btnCobro = document.getElementById('btnConfirmarCobro');

        if (!this.value) {
            ticket.style.display = 'none';
            btnCobro.style.display = 'none';
            return;
        }

        const costoFinal = parseFloat(selected.dataset.monto) || 0;
        const anticipo = parseFloat(selected.dataset.anticipo) || 0;
        const apagar = costoFinal - anticipo;
        const total = anticipo + apagar;

        document.getElementById('ticket_folio').textContent = selected.dataset.folio;
        document.getElementById('ticket_cliente').textContent = selected.dataset.cliente;
        document.getElementById('ticket_equipo').textContent = selected.dataset.equipo;
        document.getElementById('ticket_total').textContent = '$' + costoFinal.toFixed(2);
        document.getElementById('ticket_anticipo').textContent = '- $' + anticipo.toFixed(2);
        document.getElementById('ticket_apagar').textContent = '$' + apagar.toFixed(2);
        document.getElementById('cobrar_monto').value = apagar > 0 ? apagar.toFixed(2) : '0.00';

        // Mostrar total sumado
        let totalEl = document.getElementById('ticket_total_sumado');
        if (!totalEl) {
            const div = document.createElement('div');
            div.className = 'd-flex justify-content-between mb-2';
            div.innerHTML = `<span class="text-muted">Total Cobrado</span>
                         <span class="fw-semibold text-success" id="ticket_total_sumado">$${total.toFixed(2)}</span>`;
            document.getElementById('ticket_apagar').closest('.d-flex').after(div);
        } else {
            totalEl.textContent = '$' + total.toFixed(2);
        }

        ticket.style.display = 'block';
        btnCobro.style.display = 'inline-block';
    });


    // Modal cobro manual
    document.getElementById('btnAbrirCobrar').addEventListener('click', function() {
        const modalEl = document.getElementById('modalCobrar');
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    });

    // Confirmar cobro
    document.getElementById('btnConfirmarCobro').addEventListener('click', function() {
        const orden_id = document.getElementById('cobrar_orden_id').value;
        const monto = document.getElementById('cobrar_monto').value;
        if (!orden_id || !monto) {
            alert('Orden y monto son obligatorios');
            return;
        }
        $.ajax({
            url: BASE_URL + 'caja/cobrar',
            method: 'POST',
            dataType: 'json',
            data: {
                orden_id: orden_id,
                monto: monto,
                metodo_pago: document.getElementById('cobrar_metodo').value,
                notas: document.getElementById('cobrar_notas').value.trim()
            },
            success: function(res) {
                if (res.success) {
                    const modalEl = document.getElementById('modalCobrar');
                    modalEl.addEventListener('hidden.bs.modal', function() {
                        mostrarToast(res.mensaje);
                        setTimeout(() => location.reload(), 800);
                    }, {
                        once: true
                    });
                    bootstrap.Modal.getInstance(modalEl).hide();
                } else {
                    alert(res.mensaje);
                }
            }
        });
    });

    // Ordenamiento tabla
    document.querySelectorAll('#tablaCaja th').forEach(function(th, index) {
        th.style.cursor = 'pointer';
        th.dataset.orden = 'asc';
        th.title = 'Click para ordenar';
        th.addEventListener('click', function() {
            const orden = this.dataset.orden;
            const tbody = document.querySelector('#tablaCaja tbody');
            const filas = Array.from(tbody.querySelectorAll('tr'));
            document.querySelectorAll('#tablaCaja th').forEach(t => {
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