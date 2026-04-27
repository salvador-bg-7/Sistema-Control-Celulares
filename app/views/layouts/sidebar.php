<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative" style="padding: 25px 25px;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo" style="width: 100%;">
                    <a href="<?= BASE_URL ?>">
                        <img src="<?= BASE_URL ?>assets/images/logo.png" alt="DrDigital" class="sidebar-logo-img">
                    </a>
                </div>
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block">
                        <i class="bi bi-x bi-middle" style="color:white"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menú Principal <i class="bi bi-activity"></i></li>

                <li class="sidebar-item <?= (isset($activePage) && $activePage == 'dashboard') ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>" class="sidebar-link">
                        <i class="bi bi-activity"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item <?= (isset($activePage) && $activePage == 'clientes') ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>clientes" class="sidebar-link">
                        <i class="bi bi-person-square"></i>
                        <span>Clientes</span>
                    </a>
                </li>

                <li class="sidebar-item <?= (isset($activePage) && $activePage == 'ordenes') ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>ordenes" class="sidebar-link">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                        <span>Órdenes de Trabajo</span>
                    </a>
                </li>

                <!-- <li class="sidebar-item <?= (isset($activePage) && $activePage == 'inventario') ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>inventario" class="sidebar-link">
                        <i class="fa-solid fa-boxes-stacked"></i>
                        <span>Inventario</span>
                    </a>
                </li> -->

                <li class="sidebar-title">Finanzas
                    <i class="fa-solid fa-money-check-dollar"></i>
                </li>

                <li class="sidebar-item <?= (isset($activePage) && $activePage == 'caja') ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>caja" class="sidebar-link">
                        <i class="bi bi-cash-coin"></i>
                        <span>Caja</span>
                    </a>
                </li>


                <?php if (Auth::esAdmin()): ?>
                    <li class="sidebar-item <?= (isset($activePage) && $activePage == 'gastos') ? 'active' : '' ?>">
                        <a href="<?= BASE_URL ?>gastos" class="sidebar-link">
                            <i class="bi bi-cash-stack"></i>
                            <span>Gastos</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (Auth::esAdmin()): ?>
                    <li class="sidebar-item <?= (isset($activePage) && $activePage == 'pagos') ? 'active' : '' ?>">
                        <a href="<?= BASE_URL ?>pagos" class="sidebar-link">
                            <i class="bi bi-credit-card-fill"></i>
                            <span>Pagos</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (Auth::esAdmin()): ?>
                    <li class="sidebar-item <?= (isset($activePage) && $activePage == 'reportes') ? 'active' : '' ?>">
                        <a href="<?= BASE_URL ?>reportes" class="sidebar-link">
                            <i class="fa-solid fa-newspaper"></i>
                            <span>Reportes</span>
                        </a>
                    </li>
                <?php endif; ?>

                <li class="sidebar-title">
                    Sistema
                    <i class="fa-solid fa-computer"></i>
                </li>


                <li class="sidebar-item <?= (isset($activePage) && $activePage == 'ajustes') ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>ajustes" class="sidebar-link">
                        <i class="bi bi-gear-fill"></i>
                        <span>Ajustes</span>
                    </a>
                </li>



            </ul>
        </div>
    </div>
</div>