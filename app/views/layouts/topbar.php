<header class="mb-0">
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block">
                <i class="bi bi-justify fs-3"></i>
            </a>
            <div class="navbar-nav ms-auto d-flex align-items-center">

                <!-- Notificaciones -->
                <div class="nav-item dropdown me-3">
                    <a href="#" class="nav-link position-relative" id="notifDropdown" data-bs-toggle="dropdown">
                        <i class="bi bi-bell-fill fs-5 text-primary"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notifBadge" style="display:none; font-size:0.65rem;"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow" style="width:350px; max-height:450px; overflow-y:auto;" id="notifMenu">
                        <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                            <h6 class="mb-0 fw-bold">Notificaciones</h6>
                            <a href="#" class="small text-primary" id="btnMarcarTodas">Marcar todas como leídas</a>
                        </div>
                        <div id="notifLista">
                            <div class="text-center py-3 text-muted small">Cargando...</div>
                        </div>
                    </div>
                </div>

                <!-- Usuario -->
                <div class="nav-item dropdown me-1">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-5"></i>
                        <span class="ms-1">Admin</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Perfil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>auth/logout"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>

<script>
    const BASE_URL = '<?= BASE_URL ?>';

    function cargarNotificaciones() {
        $.ajax({
            url: BASE_URL + 'notificaciones/getNotificaciones',
            method: 'GET',
            dataType: 'json',
            success: function(res) {
                const badge = document.getElementById('notifBadge');
                const lista = document.getElementById('notifLista');

                if (res.total > 0) {
                    badge.style.display = 'block';
                    badge.textContent = res.total > 9 ? '9+' : res.total;
                } else {
                    badge.style.display = 'none';
                }

                if (res.notificaciones.length === 0) {
                    lista.innerHTML = '<div class="text-center py-3 text-muted small"><i class="bi bi-check-circle me-1"></i>Sin notificaciones pendientes</div>';
                    return;
                }

                const iconos = {
                    'orden_lista': {
                        icon: 'bi-cash-coin',
                        color: 'success'
                    },
                    'stock_bajo': {
                        icon: 'bi-exclamation-triangle-fill',
                        color: 'warning'
                    },
                    'orden_antigua': {
                        icon: 'bi-clock-history',
                        color: 'danger'
                    }
                };

                lista.innerHTML = res.notificaciones.map(n => {
                    const cfg = iconos[n.tipo] || {
                        icon: 'bi-bell',
                        color: 'primary'
                    };
                    return `
                <div class="dropdown-item py-2 border-bottom notif-item" style="white-space:normal; cursor:pointer;" data-id="${n.id}">
                    <div class="d-flex align-items-start gap-2">
                        <div class="mt-1">
                            <i class="bi ${cfg.icon} text-${cfg.color} fs-5"></i>
                        </div>
                        <div>
                            <p class="mb-0 small">${n.mensaje}</p>
                            <span class="text-muted" style="font-size:0.7rem;">${n.fecha}</span>
                        </div>
                    </div>
                </div>`;
                }).join('');

                // Marcar leída al click
                document.querySelectorAll('.notif-item').forEach(function(item) {
                    item.addEventListener('click', function() {
                        const id = this.dataset.id;
                        $.post(BASE_URL + 'notificaciones/marcarLeida', {
                            id: id
                        }, function() {
                            cargarNotificaciones();
                        });
                    });
                });
            }
        });
    }

    // Cargar al inicio y cada 60 segundos
    cargarNotificaciones();
    setInterval(cargarNotificaciones, 60000);

    // Marcar todas
    document.getElementById('btnMarcarTodas').addEventListener('click', function(e) {
        e.preventDefault();
        $.post(BASE_URL + 'notificaciones/marcarTodas', function() {
            cargarNotificaciones();
        });
    });
</script>