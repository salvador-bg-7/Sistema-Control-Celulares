<?php $activePage = 'reportes'; ?>
<?php require_once APP_ROOT . '/app/views/layouts/header.php'; ?>
<?php require_once APP_ROOT . '/app/views/layouts/sidebar.php'; ?>

<?php
$badges = [
    'Recibido'       => 'secondary',
    'En diagnóstico' => 'info',
    'En reparación'  => 'warning',
    'Listo'          => 'success',
    'Entregado'      => 'dark'
];

$categoriasData = [];
$categoriasLabels = [];
$categoriasColores = ['#dc3545', '#fd7e14', '#ffc107', '#28a745', '#17a2b8', '#6f42c1'];
foreach ($gastosPorCategoria as $i => $g) {
    $categoriasLabels[] = $g->categoria;
    $categoriasData[] = (float)$g->total;
}

$estadosLabels = [];
$estadosData = [];
$estadosColores = ['#6c757d', '#17a2b8', '#ffc107', '#28a745', '#343a40'];
foreach ($ordenesPorEstado as $e) {
    $estadosLabels[] = $e->estado;
    $estadosData[] = (int)$e->total;
}
?>

<div id="main">

    <div class="page-title col-12">
        <div class="row">
            <div class=" page-heading col-md-7">
                <h3>Reportes
                    <i class="fa-solid fa-newspaper"></i>
                </h3>
                <p class="text-subtitle text-muted">Análisis y reportes del taller</p>
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











    <!-- Filtros -->
    <section class="section">
        <div class="card">
            <div class="card-body col-12">
                <div class="row align-items-end">
                    <div class="col-3 mb-2">
                        <i class="fa-solid fa-calendar-days fs-5 me-2"></i>
                        <label class="form-label">Desde</label>
                        <input type="date" class="form-control" id="filtro_desde" value="<?= $desde ?>">
                    </div>
                    <div class="col-3 mb-2">
                        <i class="fa-solid fa-calendar-days fs-5 me-2"></i>
                        <label class="form-label">Hasta</label>
                        <input type="date" class="form-control" id="filtro_hasta" value="<?= $hasta ?>">
                    </div>
                    <div class="col-3 mb-2">
                        <label class="form-label">
                            <i class="fa-solid fa-list-check fs-5 me-2"></i>
                            Estado de Orden
                        </label>
                        <select class="form-select" id="filtro_estado">
                            <option value="">Todos</option>
                            <option value="Recibido" <?= $estado == 'Recibido' ? 'selected' : '' ?>>Recibido</option>
                            <option value="En reparación" <?= $estado == 'En reparación' ? 'selected' : '' ?>>En reparación</option>
                            <option value="Listo" <?= $estado == 'Listo' ? 'selected' : '' ?>>Listo</option>
                            <option value="Entregado" <?= $estado == 'Entregado' ? 'selected' : '' ?>>Entregado</option>
                        </select>
                    </div>
                    <div class="col-3 mb-2">
                        <button class="btn btn-primary w-100" id="btnFiltrar">
                            <i class="bi bi-funnel-fill me-1"></i> Filtrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tarjetas resumen -->
    <section class="row col-12">
        <div class="col-3">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 d-flex justify-content-center">
                            <div class="stats-icon blue mb-2">
                                <i class="fa-solid fa-screwdriver-wrench"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-primary font-extrabold text-center">Órdenes</h6>
                            <h6 class="font-extrabold mb-0 text-center"><?= count($ordenes) ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 d-flex justify-content-center">
                            <div class="stats-icon green mb-2">
                                <i class="fa-solid fa-arrow-trend-up"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-success font-extrabold text-center">Ingresos</h6>
                            <h6 class="font-extrabold mb-0 text-success text-center">$<?= number_format($totalIngresos, 2) ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 d-flex justify-content-center">
                            <div class="stats-icon red mb-2">
                                <i class="fa-solid fa-arrow-trend-down"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-danger font-extrabold text-center">Gastos</h6>
                            <h6 class="font-extrabold mb-0 text-danger text-center">$<?= number_format($totalGastos, 2) ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 d-flex justify-content-center">
                            <div class="stats-icon <?= ($totalIngresos - $totalGastos) >= 0 ? 'purple' : 'red' ?> mb-2">
                                <i class="fa-solid fa-scale-unbalanced-flip"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-warning font-extrabold text-center">Balance</h6>
                            <h6 class="text-warning font-extrabold mb-0 text-center <?= ($totalIngresos - $totalGastos) >= 0 ? 'text-info' : 'text-danger' ?>">
                                $<?= number_format($totalIngresos - $totalGastos, 2) ?>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gráficas -->
    <section class="row col-12">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 text-center">
                        <i class="fa-solid fa-chart-pie"></i>
                        Órdenes por Estado
                    </h5>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <canvas id="graficaEstados" height="200" width="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 text-center text-danger">
                        <i class="fa-solid fa-chart-pie"></i>
                        Gastos por Categoría
                    </h5>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <canvas id="graficaCategorias" height="200" width="200"></canvas>
                </div>
            </div>
        </div>
    </section>

    <!-- Reporte Órdenes -->
    <section class="section">
        <div class="card ">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fa-solid fa-screwdriver-wrench fs-5 me-2"></i>
                    Reporte de Órdenes
                </h5>
                <button class="btn btn-sm btn-success"
                    onclick="imprimirSeccion('seccionOrdenes', 'Reporte de Órdenes')">
                    <i class="fa-solid fa-print fs-5 me-3"></i>
                    Imprimir
                </button>
            </div>
            <div class="card-body" id="seccionOrdenes">
                <div class="table-responsive">
                    <table class="table table-hover table-sm text-center">
                        <thead>
                            <tr>
                                <th><i class="fa-solid fa-hashtag"></i> Folio</th>
                                <th><i class="fa-solid fa-user"></i> Cliente</th>
                                <th><i class="fa-solid fa-wave-square"></i> Marca</th>
                                <th><i class="fa-solid fa-mobile-screen-button"></i> Modelo</th>
                                <th><i class="fa-solid fa-exclamation-triangle"></i> Falla</th>
                                <th><i class="fa-solid fa-wrench"></i> Estado</th>
                                <th><i class="fa-solid fa-dollar-sign"></i> Costo Final</th>
                                <th><i class="fa-solid fa-calendar-days"></i> Fecha Ingreso</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($ordenes)): ?>
                                <?php foreach ($ordenes as $o): ?>
                                    <tr>
                                        <td><span class="badge bg-primary"><?= $o->folio ?></span></td>
                                        <td class="fw-bold"><?= htmlspecialchars($o->cliente_nombre) ?></td>
                                        <td><?= htmlspecialchars($o->marca) ?></td>
                                        <td><?= htmlspecialchars($o->modelo) ?></td>
                                        <td><?= htmlspecialchars(substr($o->falla_reportada, 0, 40)) ?>...</td>
                                        <td><span class="badge bg-<?= $badges[$o->estado] ?? 'secondary' ?>"><?= $o->estado ?></span></td>
                                        <td class="fw-bold">$<?= number_format($o->costo_final, 2) ?></td>
                                        <td><?= date('d/m/Y', strtotime($o->fecha_ingreso)) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">Sin órdenes en este período</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Reporte Ingresos -->
    <section class="section mb-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-arrow-up-circle-fill text-success fs-4 me-2"></i>
                    Reporte de Ingresos</h5>
                <button class="btn btn-sm btn-success" onclick="imprimirSeccion('seccionIngresos', 'Reporte de Ingresos')">
                    <i class="fa-solid fa-print fs-5 me-3"></i>
                    Imprimir
                </button>
            </div>
            <div class="card-body" id="seccionIngresos">
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th> <i class="fa-solid fa-hashtag"></i> Folio</th>
                                <th> <i class="fa-solid fa-user"></i> Cliente</th>
                                <th> <i class="fa-solid fa-mobile-screen-button"></i> Equipo</th>
                                <th> <i class="fa-solid fa-dollar-sign"></i> Monto</th>
                                <th> <i class="fa-solid fa-credit-card"></i> Método</th>
                                <th> <i class="fa-solid fa-calendar-days"></i> Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($ingresos)): ?>
                                <?php foreach ($ingresos as $i): ?>
                                    <tr>
                                        <td><span class="badge bg-primary"><?= $i->folio ?></span></td>
                                        <td class="fw-bold"><?= htmlspecialchars($i->cliente_nombre) ?></td>
                                        <td><?= htmlspecialchars($i->marca) ?> <?= htmlspecialchars($i->modelo) ?></td>
                                        <td class="text-success fw-bold">$<?= number_format($i->monto, 2) ?></td>
                                        <td><span class="badge bg-<?= $i->metodo_pago == 'Efectivo' ? 'success' : 'info' ?>"><?= $i->metodo_pago ?></span></td>
                                        <td><?= date('d/m/Y', strtotime($i->fecha_cobro)) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="table-primary fw-bold">
                                    <td colspan="3" class="text-end text-primary">Total:</td>
                                    <td>$<?= number_format($totalIngresos, 2) ?></td>
                                    <td colspan="2"></td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Sin ingresos en este período</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Reporte Gastos -->
    <section class="section mb-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-arrow-down-circle-fill text-danger fs-4 me-2"></i>
                    Reporte de Gastos</h5>
                <button class="btn btn-sm btn-success" onclick="imprimirSeccion('seccionGastos', 'Reporte de Gastos')">
                    <i class="fa-solid fa-print fs-5 me-3"></i>
                    Imprimir
                </button>
            </div>
            <div class="card-body" id="seccionGastos">
                <div class="table-responsive">
                    <table class="table table-hover table-sm text-center">
                        <thead>
                            <tr>
                                <th> <i class="fa-solid fa-tag"></i> Concepto</th>
                                <th> <i class="fa-solid fa-list"></i> Categoría</th>
                                <th> <i class="fa-solid fa-dollar-sign"></i> Monto</th>
                                <th> <i class="fa-solid fa-credit-card"></i> Método</th>
                                <th> <i class="fa-solid fa-calendar-days"></i> Fecha</th>
                                <th> <i class="fa-solid fa-sticky-note"></i> Notas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($gastos)): ?>
                                <?php foreach ($gastos as $g): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($g->concepto) ?></td>
                                        <td><span class="badge bg-danger"><?= $g->categoria ?></span></td>
                                        <td class="text-danger fw-bold">$<?= number_format($g->monto, 2) ?></td>
                                        <td><span class="badge bg-<?= $g->metodo_pago == 'Efectivo' ? 'success' : 'info' ?>"><?= $g->metodo_pago ?></span></td>
                                        <td><?= date('d/m/Y', strtotime($g->fecha)) ?></td>
                                        <td><?= htmlspecialchars($g->notas) ?: '-' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="table-danger fw-bold">
                                    <td colspan="2" class="text-end">Total:</td>
                                    <td>$<?= number_format($totalGastos, 2) ?></td>
                                    <td colspan="3"></td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Sin gastos en este período</td>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const BASE_URL = '<?= BASE_URL ?>';

    // Gráfica órdenes por estado
    new Chart(document.getElementById('graficaEstados'), {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($estadosLabels) ?>,
            datasets: [{
                data: <?= json_encode($estadosData) ?>,
                backgroundColor: <?= json_encode(array_slice($estadosColores, 0, count($estadosLabels))) ?>
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Gráfica gastos por categoría
    new Chart(document.getElementById('graficaCategorias'), {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($categoriasLabels) ?>,
            datasets: [{
                data: <?= json_encode($categoriasData) ?>,
                backgroundColor: <?= json_encode(array_slice($categoriasColores, 0, count($categoriasLabels))) ?>
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Filtrar
    document.getElementById('btnFiltrar').addEventListener('click', function() {
        const desde = document.getElementById('filtro_desde').value;
        const hasta = document.getElementById('filtro_hasta').value;
        const estado = document.getElementById('filtro_estado').value;
        if (!desde || !hasta) {
            alert('Selecciona ambas fechas');
            return;
        }
        window.location.href = BASE_URL + 'reportes?desde=' + desde + '&hasta=' + hasta + '&estado=' + estado;
    });

    // Imprimir sección
    function imprimirSeccion(idSeccion, titulo) {
        const contenido = document.getElementById(idSeccion).innerHTML;
        const ventana = window.open('', '_blank');
        ventana.document.write(`
        <html>
        <head>
            <title>${titulo}</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
            <style>body { padding: 20px; } @media print { .no-print { display: none; } }</style>
        </head>
        <body>
            <h4 class="mb-3">DrDigital — ${titulo}</h4>
            <p class="text-muted">Período: <?= $desde ?> al <?= $hasta ?></p>
            ${contenido}
            <script>window.print();<\/script>
        </body>
        </html>
    `);
        ventana.document.close();
    }
</script>

<?php require_once APP_ROOT . '/app/views/layouts/footer.php'; ?>