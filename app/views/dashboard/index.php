<?php $activePage = 'dashboard'; ?>
<?php require_once APP_ROOT . '/app/views/layouts/header.php'; ?>
<?php require_once APP_ROOT . '/app/views/layouts/sidebar.php'; ?>

<?php
// Preparar datos gráfica 6 meses 
$meses6 = [];
for ($i = 5; $i >= 0; $i--) {
    $meses6[] = date('Y-m', strtotime("-$i months"));
}
$ingresosData6 = array_fill(0, 6, 0);
$gastosData6   = array_fill(0, 6, 0);
foreach ($ingresosMes6 as $r) {
    $idx = array_search($r->mes, $meses6);
    if ($idx !== false) $ingresosData6[$idx] = (float)$r->total;
}
foreach ($gastosMes6 as $r) {
    $idx = array_search($r->mes, $meses6);
    if ($idx !== false) $gastosData6[$idx] = (float)$r->total;
}
$meses6Labels = array_map(fn($m) => date('M Y', strtotime($m . '-01')), $meses6);

$badges = [
    'Recibido'       => 'secondary',
    'En reparación'  => 'danger',
    'Listo'          => 'success',
    'Entregado'      => 'primary'
];
?>

<div id="main">

    <div class="page-title">
        <div class="row ms-1">
            <div class="page-heading col-md-7">
                <h3>
                    Dashboard
                    <i class="bi bi-activity"></i>
                </h3>
                <p class="text-subtitle text-muted">Resumen general de Dr. Digital</p>
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


    <!-- inicia cntenido de pagina -->
    <div class="page-content">

        <!-- 4 Tarjetas -->
        <section class="row mb-3">
            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body px-4">
                        <div class="row">
                            <div class="col-md-4 d-flex justify-content-center">
                                <div class="stats-icon blue mb-2">
                                    <i class="fa-solid fa-users"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h4 class="text-primary font-extrabold text-center">
                                    Clientes</h4>
                                <h4 class="font-extrabold mb-0 text-center">
                                    <?= $totalClientes ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body px-4">
                        <div class="row">
                            <div class="col-md-4 d-flex justify-content-center">
                                <div class="stats-icon purple mb-2">
                                    <i class="fa-solid fa-screwdriver-wrench"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h4 class="text-warning font-extrabold text-center">
                                    Órdenes Activas</h4>
                                <h4 class="font-extrabold mb-0 text-center text-warning">
                                    <?= $ordenesActivas ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (Auth::esAdmin()): ?>
                <div class="col-6 col-lg-3">
                    <div class="card">
                        <div class="card-body px-4">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center">
                                    <div class="stats-icon green mb-2">
                                        <i class="fa-solid fa-file-invoice-dollar"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-success font-extrabold text-center">
                                        Ingresos del Mes</h6>
                                    <h6 class="font-extrabold mb-0 text-center text-success">
                                        $<?= number_format($ingresosMes, 2) ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (Auth::esAdmin()): ?>
                <div class="col-6 col-lg-3">
                    <div class="card">
                        <div class="card-body px-4">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center">
                                    <div class="stats-icon red mb-2">
                                        <i class="fa-solid fa-hand-holding-dollar"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-danger font-extrabold text-center">
                                        Gastos del Mes</h6>
                                    <h6 class="font-extrabold mb-0 text-center text-danger">
                                        $<?= number_format($gastosMes, 2) ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </section>



        <!-- Cards órdenes recientes y antiguas -->
        <section class="row mb-3">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fa-regular fa-clock fa-lg"></i>

                            </i>Órdenes Recientes</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th><i class="fa-solid fa-hashtag"></i> Folio</th>
                                        <th><i class="fa-solid fa-user"></i> Cliente</th>
                                        <th><i class="fa-solid fa-mobile-screen-button"></i> Equipo</th>
                                        <th><i class="fa-solid fa-wrench"></i> Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($ordenesRecientes)): ?>
                                        <?php foreach ($ordenesRecientes as $o): ?>
                                            <tr>
                                                <td><span class="badge bg-primary"><?= $o->folio ?></span></td>
                                                <td><?= htmlspecialchars($o->cliente_nombre) ?></td>
                                                <td><?= htmlspecialchars($o->marca) ?> <?= htmlspecialchars($o->modelo) ?></td>
                                                <td><span class="badge bg-<?= $badges[$o->estado] ?? 'secondary' ?>"><?= $o->estado ?></span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">Sin órdenes</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="<?= BASE_URL ?>ordenes" class="btn btn-sm btn-primary">Ver todas</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fa-regular fa-calendar-xmark fa-lg"></i>
                            Órdenes más Antiguas Activas</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th><i class="fa-solid fa-hashtag"></i> Folio</th>
                                        <th><i class="fa-solid fa-user"></i> Cliente</th>
                                        <th><i class="fa-solid fa-mobile-screen-button"></i> Equipo</th>
                                        <th><i class="fa-solid fa-calendar"></i> Días</th>
                                        <th><i class="fa-solid fa-wrench"></i> Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($ordenesAntiguas)): ?>
                                        <?php foreach ($ordenesAntiguas as $o): ?>
                                            <?php $dias = (int)((time() - strtotime($o->fecha_ingreso)) / 86400); ?>
                                            <tr>
                                                <td><span class="badge bg-primary"><?= $o->folio ?></span></td>
                                                <td><?= htmlspecialchars($o->cliente_nombre) ?></td>
                                                <td><?= htmlspecialchars($o->marca) ?> <?= htmlspecialchars($o->modelo) ?></td>
                                                <td><span class="badge bg-<?= $dias > 7 ? 'danger' : 'warning' ?>"><?= $dias ?>d</span></td>
                                                <td><span class="badge bg-<?= $badges[$o->estado] ?? 'secondary' ?>"><?= $o->estado ?></span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Sin órdenes activas</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="<?= BASE_URL ?>ordenes" class="btn btn-sm btn-primary">Ver todas</a>
                    </div>
                </div>
            </div>
        </section>

        <?php if (Auth::esAdmin()): ?>
            <!-- Gráfica Ingresos vs Gastos 6 meses -->
            <section class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 text-center"><i class="fa-solid fa-chart-line fs-3 me-3"></i>
                                Ingresos vs Gastos — Últimos 6 Meses</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="graficaSeis" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('graficaSeis'), {
        type: 'line',
        data: {
            labels: <?= json_encode($meses6Labels) ?>,
            datasets: [{
                    label: 'Ingresos',
                    data: <?= json_encode($ingresosData6) ?>,
                    borderColor: '#5DDAB4',
                    backgroundColor: '#4aa78b67',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Gastos',
                    data: <?= json_encode($gastosData6) ?>,
                    borderColor: '#FF7976',
                    backgroundColor: '#d1626156',
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
</script>

<?php require_once APP_ROOT . '/app/views/layouts/footer.php'; ?>