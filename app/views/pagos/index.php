<?php $activePage = 'pagos'; ?>
<?php require_once APP_ROOT . '/app/views/layouts/header.php'; ?>
<?php require_once APP_ROOT . '/app/views/layouts/sidebar.php'; ?>

<div id="main">

    <div class="page-heading">

        <div class="page-title">
            <div class="row">
                <div class=" page-heading col-md-7">
                    <h3>Pagos
                        <i class="bi bi-credit-card-fill"></i>
                    </h3>
                    <p class="text-subtitle text-muted">Resumen financiero del taller</p>
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
        <section class="section mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-5 mb-2">
                            <i class="bi bi-calendar-event-fill fs-5 me-2"></i>
                            <label class="form-label">Desde</label>
                            <input type="date" class="form-control" id="filtro_desde" value="<?= $desde ?>">
                        </div>
                        <div class="col-md-5 mb-2">
                            <i class="bi bi-calendar-event-fill fs-5 me-2"></i>
                            <label class="form-label">Hasta</label>
                            <input type="date" class="form-control" id="filtro_hasta" value="<?= $hasta ?>">
                        </div>
                        <div class="col-md-2 mb-2">
                            <button class="btn btn-primary w-100" id="btnFiltrar">
                                <i class="bi bi-funnel-fill me-1"></i> Filtrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tarjetas resumen -->
        <section class="row mb-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 d-flex justify-content-center">
                                <div class="stats-icon green">
                                    <i class="fa-solid fa-arrow-trend-up"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h4 class="font-semibold text-center font-extrabold text-success">
                                    Total Ingresos</h4>
                                <h4 class="font-extrabold mb-0 text-success text-center">$<?= number_format($totalIngresos, 2) ?></h4>
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
                                <div class="stats-icon red">
                                    <i class="fa-solid fa-arrow-trend-down"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h4 class="text-danger font-extrabold text-center">Total Gastos</h4>
                                <h4 class="font-extrabold mb-0 text-danger text-center">$<?= number_format($totalGastos, 2) ?></h4>
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
                                <div class="stats-icon <?= $balance >= 0 ? 'blue' : 'red' ?> mb-2">
                                    <i class="fa-solid fa-scale-unbalanced-flip"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-primary font-extrabold text-center">Balance</h6>
                                <h6 class="font-extrabold mb-0 text-center <?= $balance >= 0 ? 'text-primary' : 'text-danger' ?>">
                                    $<?= number_format($balance, 2) ?>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gráficas -->
        <section class="row mb-3">
            <!-- Ingresos por día -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 text-center">
                            <i class="fa-solid fa-calendar-days fs-5 me-2"></i>
                            Ingresos por Día
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="graficaDia" height="138"></canvas>
                    </div>
                </div>
            </div>
            <!-- Dona Efectivo vs Transferencia -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 text-center">
                            <i class="fa-solid fa-money-bills fs-5 me-2"></i>
                            Método de Pago
                        </h5>
                    </div>
                    <div class="card-body d-flex justify-content-center">
                        <canvas id="graficaMetodo" height="200" width="200"></canvas>
                    </div>
                </div>
            </div>
            <!-- Ingresos vs Gastos por mes -->
            <div class="col-md-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 text-center">
                            <i class="fa-solid fa-chart-line fs-4 me-2"></i>
                            Ingresos vs Gastos por Mes (<?= date('Y') ?>)
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="graficaMes" height="100"></canvas>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tablas -->
        <section class="row">
            <!-- Ingresos -->
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-arrow-up-circle-fill text-success fs-4 me-2"></i>Ingresos</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover text-center">
                                <thead>
                                    <tr>
                                        <th><i class="fa-solid fa-hashtag"></i> Folio</th>
                                        <th><i class="fa-solid fa-user"></i> Cliente</th>
                                        <th><i class="fa-solid fa-mobile-screen-button"></i> Equipo</th>
                                        <th><i class="fa-solid fa-coins"></i> Monto</th>
                                        <th><i class="fa-solid fa-credit-card"></i> Método</th>
                                        <th><i class="fa-solid fa-calendar-days"></i> Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($ingresos)): ?>
                                        <?php foreach ($ingresos as $i): ?>
                                            <tr>
                                                <td><span class="badge bg-primary"><?= $i->folio ?></span></td>
                                                <td><?= htmlspecialchars($i->cliente_nombre) ?></td>
                                                <td><?= htmlspecialchars($i->marca) ?> <?= htmlspecialchars($i->modelo) ?></td>
                                                <td class="text-success fw-bold">$<?= number_format($i->monto, 2) ?></td>
                                                <td>
                                                    <?php $b = $i->metodo_pago == 'Efectivo' ? 'success' : 'info'; ?>
                                                    <span class="badge bg-<?= $b ?>"><?= $i->metodo_pago ?></span>
                                                </td>
                                                <td><?= date('d/m/Y H:i', strtotime($i->fecha_cobro)) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No hay ingresos en este período</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gastos -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-arrow-down-circle-fill text-danger fs-4 me-2"></i>Gastos</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover text-center">
                                <thead>
                                    <tr>
                                        <th><i class="fa-solid fa-file-signature"></i> Concepto</th>
                                        <th><i class="fa-solid fa-tag"></i> Categoría</th>
                                        <th><i class="fa-solid fa-coins"></i> Monto</th>
                                        <th><i class="fa-solid fa-credit-card"></i> Método</th>
                                        <th><i class="fa-solid fa-calendar-days"></i> Fecha</th>
                                        <th><i class="fa-solid fa-sticky-note"></i> Notas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($gastos)): ?>
                                        <?php foreach ($gastos as $g): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($g->concepto) ?></td>
                                                <td><span class="badge bg-danger"><?= $g->categoria ?></span></td>
                                                <td class="text-danger fw-bold">$<?= number_format($g->monto, 2) ?></td>
                                                <td>
                                                    <?php $b = $g->metodo_pago == 'Efectivo' ? 'success' : 'info'; ?>
                                                    <span class="badge bg-<?= $b ?>"><?= $g->metodo_pago ?></span>
                                                </td>
                                                <td><?= date('d/m/Y', strtotime($g->fecha)) ?></td>
                                                <td><?= htmlspecialchars($g->notas) ?: '-' ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No hay gastos en este período</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<?php
// Preparar datos para gráficas
$diasLabels = [];
$diasData = [];
foreach ($ingresosDia as $d) {
    $diasLabels[] = date('d/m', strtotime($d->dia));
    $diasData[] = (float)$d->total;
}

$mesesLabels = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
$ingresosMesData = array_fill(0, 12, 0);
$gastosMesData = array_fill(0, 12, 0);
foreach ($ingresosMes as $m) {
    $ingresosMesData[$m->mes - 1] = (float)$m->total;
}
foreach ($gastosMes as $m) {
    $gastosMesData[$m->mes - 1] = (float)$m->total;
}

$metodoLabels = [];
$metodoData = [];
$metodoColores = [];
foreach ($totalesMetodo as $t) {
    $metodoLabels[] = $t->metodo_pago;
    $metodoData[] = (float)$t->total;
    $metodoColores[] = $t->metodo_pago == 'Efectivo' ? '#5DDAB4' : '#215243';
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const BASE_URL = '<?= BASE_URL ?>';

    // Gráfica ingresos por día
    new Chart(document.getElementById('graficaDia'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($diasLabels) ?>,
            datasets: [{
                label: 'Ingresos',
                data: <?= json_encode($diasData) ?>,
                backgroundColor: '#5ddab5af',
                borderColor: '#5DDAB4',
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Gráfica método de pago (dona)
    new Chart(document.getElementById('graficaMetodo'), {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($metodoLabels) ?>,
            datasets: [{
                data: <?= json_encode($metodoData) ?>,
                backgroundColor: <?= json_encode($metodoColores) ?>
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

    // Gráfica ingresos vs gastos por mes
    new Chart(document.getElementById('graficaMes'), {
        type: 'line',
        data: {
            labels: <?= json_encode($mesesLabels) ?>,
            datasets: [{
                    label: 'Ingresos',
                    data: <?= json_encode($ingresosMesData) ?>,
                    borderColor: '#5DDAB4',
                    backgroundColor: 'rgba(40,167,69,0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Gastos',
                    data: <?= json_encode($gastosMesData) ?>,
                    borderColor: '#FF7976',
                    backgroundColor: 'rgba(220,53,69,0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Filtrar por fechas
    document.getElementById('btnFiltrar').addEventListener('click', function() {
        const desde = document.getElementById('filtro_desde').value;
        const hasta = document.getElementById('filtro_hasta').value;
        if (!desde || !hasta) {
            alert('Selecciona ambas fechas');
            return;
        }
        window.location.href = BASE_URL + 'pagos?desde=' + desde + '&hasta=' + hasta;
    });
</script>

<?php require_once APP_ROOT . '/app/views/layouts/footer.php'; ?>