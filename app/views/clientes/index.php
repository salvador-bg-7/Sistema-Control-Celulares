<?php $activePage = 'clientes'; ?>
<?php require_once APP_ROOT . '/app/views/layouts/header.php'; ?>
<?php require_once APP_ROOT . '/app/views/layouts/sidebar.php'; ?>

<div id="main">

    <div class="page-title">
        <div class="row align-items-center">
            <div class="page-heading col-md-7">
                <h3>Clientes
                    <i class="bi bi-person-square"></i>
                </h3>
                <p class="text-subtitle text-muted mb-0">Gestión de clientes registrados</p>
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



    <section class="section">
        <div class="row g-4 align-items-start">


            <!-- Card listado -->
            <div class="col-md-8">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fa-solid fa-list fs-4 me-2"></i>
                            Listado de Clientes</h5>
                        <div style="width: 220px;">
                            <div class="search-box">
                                <input type="text" class="form-control form-control-sm table-search-manual"
                                    placeholder="Buscar...">
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover text-center" id="tablaClientes">
                                <thead>
                                    <tr class="font">
                                        <th><i class="fa-solid fa-hashtag"></i> ID</th>
                                        <th><i class="fa-solid fa-address-card"></i> Nombre</th>
                                        <th><i class="fa-solid fa-phone"></i> Teléfono</th>
                                        <th><i class="fa-solid fa-calendar-check"></i> Fecha Registro</th>
                                        <th><i class="fa-solid fa-bars"></i> Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($clientes)): ?>
                                        <?php foreach ($clientes as $c): ?>
                                            <tr>
                                                <td><?= $c->id ?></td>
                                                <td><?= htmlspecialchars($c->nombre) ?></td>
                                                <td><?= htmlspecialchars($c->telefono) ?></td>
                                                <td><?= date('d/m/Y', strtotime($c->fecha_registro)) ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary btn-editar"
                                                        data-id="<?= $c->id ?>"
                                                        data-nombre="<?= htmlspecialchars($c->nombre) ?>"
                                                        data-telefono="<?= htmlspecialchars($c->telefono) ?>"
                                                        data-email="<?= htmlspecialchars($c->email) ?>"
                                                        data-direccion="<?= htmlspecialchars($c->direccion) ?>">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </button>

                                                    <?php if (Auth::esAdmin()): ?>
                                                        <button class="btn btn-sm btn-primary btn-eliminar"
                                                            data-id="<?= $c->id ?>"
                                                            data-nombre="<?= htmlspecialchars($c->nombre) ?>">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    <?php endif; ?>

                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No hay clientes registrados</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card formulario -->
            <div class="col-md-4 pe-4" style="position: sticky; top: 20px; z-index: 50;">
                <div style="top: 20px;">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                            <div class="d-flex align-items-center gap-3">
                                <i class="fa-solid fa-user-plus fs-2 me-2 text-primary"></i>
                                <div>
                                    <h5 class="mb-0 fw-bold text-primary">Nuevo Cliente</h5>
                                </div>
                            </div>
                            <div class="border-top my-4 mb-0"></div>
                        </div>

                        <div class=" card-body px-4 py-3">
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-primary">
                                    <i class="fa-solid fa-address-card me-2 text-primary"></i>
                                    Nombre <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control rounded-3 border-0 bg-body py-2"
                                    id="nuevo_nombre" placeholder="Ingresa el nombre del cliente">
                            </div>
                            <br>

                            <div class="mb-2">
                                <label class="form-label fw-semibold text-primary">
                                    <i class="fa-solid fa-phone me-2 text-primary"></i>
                                    Teléfono <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control rounded-3 border-0 bg-body py-2"
                                    id="nuevo_telefono" maxlength="10" placeholder="Ingresa el teléfono"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                            </div>
                        </div>
                        <br>

                        <div class="card-footer bg-white border-0 px-4 pb-4 pt-2">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button"
                                    class="btn btn-danger rounded-3 px-4 me-3" id="btnCancelar">
                                    Cancelar
                                </button>
                                <button type="button"
                                    class="btn btn-primary rounded-3 px-4"
                                    id="btnGuardarCliente">
                                    <i class="fa-solid fa-user-plus me-2"></i>Guardar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>






    <!-- toast de exito -->
    <div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 9999">
        <div id="toastExito" class="toast align-items-center text-bg-primary border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body" id="toastMensaje">Operación exitosa</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>





    <!-- Modal Editar Cliente -->
    <div class="modal fade" id="modalEditarCliente" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title">
                        <i class="fa-solid fa-user-pen fs-4 me-3"></i>
                        <span class="ps-2">Editar Cliente</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editar_id">
                    <div class="mb-3">
                        <i class="fa-solid fa-address-card"></i>
                        <label class="form-label">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editar_nombre">
                    </div>
                    <div class="mb-3">
                        <i class="fa-solid fa-phone"></i>
                        <label class="form-label">Teléfono <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editar_telefono" maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnActualizarCliente">
                        <i class="fa-solid fa-user-pen me-1"></i>
                        Actualizar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar -->
    <div class="modal fade" id="modalEliminarCliente" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-trash-can fs-4 me-2"></i>
                        <span class="ps-2">Eliminar Cliente</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="eliminar_id">
                    <p>¿Eliminar a <strong id="eliminar_nombre"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnConfirmarEliminar">
                        <i class="fa-solid fa-trash-can"></i>
                        Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const BASE_URL = '<?= BASE_URL ?>';

        //limpiador de los input al cancelar
        document.getElementById('btnCancelar').addEventListener('click', function() {
            document.getElementById('nuevo_nombre').value = '';
            document.getElementById('nuevo_telefono').value = '';
        });


        // funcion toast
        function mostrarToast(mensaje) {
            document.getElementById('toastMensaje').textContent = mensaje;
            const toast = new bootstrap.Toast(document.getElementById('toastExito'));
            toast.show();
        }

        function mostrarToastError(mensaje) {
            document.getElementById('toastMensaje').textContent = mensaje;
            const toastEl = document.getElementById('toastExito');
            toastEl.classList.remove('text-bg-primary');
            toastEl.classList.add('text-bg-danger');
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
            setTimeout(() => {
                toastEl.classList.remove('text-bg-danger');
                toastEl.classList.add('text-bg-primary');
            }, 4000);
        }

        // Buscador manual
        document.querySelector('.table-search-manual').addEventListener('keyup', function() {
            const term = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('#tablaClientes tbody tr');
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
            let noResults = document.querySelector('#tablaClientes .no-results');
            if (found === 0) {
                if (!noResults) {
                    const tr = document.createElement('tr');
                    tr.className = 'no-results';
                    tr.innerHTML = `<td colspan="5" class="text-center py-3 text-muted">Sin resultados para "<strong>${term}</strong>"</td>`;
                    document.querySelector('#tablaClientes tbody').appendChild(tr);
                }
            } else {
                if (noResults) noResults.remove();
            }
        });

        // filtro de columnas
        document.querySelectorAll('#tablaClientes th').forEach(function(th, index) {
            if (index === 4) return; // omite columna Acciones
            th.style.cursor = 'pointer';
            th.dataset.orden = 'asc';
            th.title = 'Click para ordenar';
            th.addEventListener('click', function() {
                const orden = this.dataset.orden;
                const tbody = document.querySelector('#tablaClientes tbody');
                const filas = Array.from(tbody.querySelectorAll('tr:not(.no-results)'));
                document.querySelectorAll('#tablaClientes th').forEach(t => {
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



        // Guardar nuevo cliente
        document.getElementById('btnGuardarCliente').addEventListener('click', function() {
            const nombre = document.getElementById('nuevo_nombre').value.trim();
            const telefono = document.getElementById('nuevo_telefono').value.trim();
            if (!nombre || !telefono) {
                alert('Nombre y teléfono son obligatorios');
                return;
            }
            $.ajax({
                url: BASE_URL + 'clientes/guardar',
                method: 'POST',
                dataType: 'json',
                data: {
                    nombre: nombre,
                    telefono: telefono,
                },
                success: function(res) {
                    if (res.success) {
                        document.getElementById('nuevo_nombre').value = '';
                        document.getElementById('nuevo_telefono').value = '';
                        mostrarToast(res.mensaje);
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        mostrarToastError(res.mensaje);
                    }
                }
            });
        });




        // Abrir modal editar
        document.querySelectorAll('.btn-editar').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.getElementById('editar_id').value = this.dataset.id;
                document.getElementById('editar_nombre').value = this.dataset.nombre;
                document.getElementById('editar_telefono').value = this.dataset.telefono;

                new bootstrap.Modal(document.getElementById('modalEditarCliente')).show();
            });
        });

        // Actualizar cliente
        document.getElementById('btnActualizarCliente').addEventListener('click', function() {
            $.ajax({
                url: BASE_URL + 'clientes/editar',
                method: 'POST',
                dataType: 'json',
                data: {
                    id: document.getElementById('editar_id').value,
                    nombre: document.getElementById('editar_nombre').value.trim(),
                    telefono: document.getElementById('editar_telefono').value.trim(),

                },
                success: function(res) {
                    if (res.success) {
                        const modalEditar = bootstrap.Modal.getInstance(document.getElementById('modalEditarCliente'));
                        modalEditar.hide();
                        document.getElementById('modalEditarCliente').addEventListener('hidden.bs.modal', function() {
                            mostrarToast(res.mensaje);
                            setTimeout(() => location.reload(), 1000);
                        }, {
                            once: true
                        });
                    } else {
                        mostrarToastError(res.mensaje);
                    }
                }
            });
        });

        // Abrir modal eliminar
        document.querySelectorAll('.btn-eliminar').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.getElementById('eliminar_id').value = this.dataset.id;
                document.getElementById('eliminar_nombre').textContent = this.dataset.nombre;
                new bootstrap.Modal(document.getElementById('modalEliminarCliente')).show();
            });
        });

        // Confirmar eliminar
        document.getElementById('btnConfirmarEliminar').addEventListener('click', function() {
            $.ajax({
                url: BASE_URL + 'clientes/eliminar',
                method: 'POST',
                dataType: 'json',
                data: {
                    id: document.getElementById('eliminar_id').value
                },
                success: function(res) {
                    if (res.success) {
                        const modalEliminar = bootstrap.Modal.getInstance(document.getElementById('modalEliminarCliente'));
                        modalEliminar.hide();
                        document.getElementById('modalEliminarCliente').addEventListener('hidden.bs.modal', function() {
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



        // Notificaciones
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
                    if (res.notificaciones.length === 0) {
                        lista.innerHTML = '<div class="text-center py-3 text-muted small"><i class="bi bi-check-circle me-1"></i>Sin notificaciones</div>';
                        return;
                    }
                    lista.innerHTML = res.notificaciones.map(n => {
                        const cfg = iconos[n.tipo] || {
                            icon: 'bi-bell',
                            color: 'primary'
                        };
                        return `<div class="dropdown-item py-2 border-bottom notif-item" style="white-space:normal;cursor:pointer;" data-id="${n.id}">
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi ${cfg.icon} text-${cfg.color} fs-5 mt-1"></i>
                        <div>
                            <p class="mb-0 small">${n.mensaje}</p>
                            <span class="text-muted" style="font-size:0.7rem;">${n.fecha}</span>
                        </div>
                    </div>
                </div>`;
                    }).join('');
                    document.querySelectorAll('.notif-item').forEach(function(item) {
                        item.addEventListener('click', function() {
                            $.post(BASE_URL + 'notificaciones/marcarLeida', {
                                id: this.dataset.id
                            }, cargarNotificaciones);
                        });
                    });
                }
            });
        }
        cargarNotificaciones();
        setInterval(cargarNotificaciones, 60000);
        document.getElementById('btnMarcarTodas').addEventListener('click', function(e) {
            e.preventDefault();
            $.post(BASE_URL + 'notificaciones/marcarTodas', cargarNotificaciones);
        });
    </script>

    <?php require_once APP_ROOT . '/app/views/layouts/footer.php'; ?>