<?php $activePage = 'inventario'; ?>
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
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Inventario</h3>
                    <p class="text-subtitle text-muted">Gestión de refacciones y productos</p>
                </div>
            </div>
        </div>

        <!-- Alerta stock bajo -->
        <?php if (!empty($stockBajo)): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong><?= count($stockBajo) ?> producto(s) con stock bajo:</strong>
                <?= implode(', ', array_map(fn($p) => htmlspecialchars($p->nombre) . ' (' . $p->cantidad . ')', $stockBajo)) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Listado de Inventario</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoProducto">
                        <i class="bi bi-plus-circle me-1"></i> Nuevo Producto
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tablaInventario">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Cantidad</th>
                                    <th>Stock Mín.</th>
                                    <th>P. Compra</th>
                                    <th>P. Venta</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($inventario)): ?>
                                    <?php foreach ($inventario as $p): ?>
                                        <?php $stockAlerta = $p->cantidad <= $p->stock_minimo ? 'table-warning' : ''; ?>
                                        <tr class="<?= $stockAlerta ?>">
                                            <td><?= $p->id ?></td>
                                            <td><?= htmlspecialchars($p->nombre) ?></td>
                                            <td><span class="badge bg-secondary"><?= $p->categoria ?></span></td>
                                            <td>
                                                <?php if ($p->cantidad <= $p->stock_minimo): ?>
                                                    <span class="text-danger fw-bold"><?= $p->cantidad ?> <i class="bi bi-exclamation-circle"></i></span>
                                                <?php else: ?>
                                                    <?= $p->cantidad ?>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $p->stock_minimo ?></td>
                                            <td>$<?= number_format($p->precio_compra, 2) ?></td>
                                            <td>$<?= number_format($p->precio_venta, 2) ?></td>
                                            <td><?= htmlspecialchars($p->descripcion) ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning btn-editar"
                                                    data-id="<?= $p->id ?>"
                                                    data-nombre="<?= htmlspecialchars($p->nombre) ?>"
                                                    data-categoria="<?= $p->categoria ?>"
                                                    data-cantidad="<?= $p->cantidad ?>"
                                                    data-precio_compra="<?= $p->precio_compra ?>"
                                                    data-precio_venta="<?= $p->precio_venta ?>"
                                                    data-stock_minimo="<?= $p->stock_minimo ?>"
                                                    data-descripcion="<?= htmlspecialchars($p->descripcion) ?>">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger btn-eliminar"
                                                    data-id="<?= $p->id ?>"
                                                    data-nombre="<?= htmlspecialchars($p->nombre) ?>">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center">No hay productos registrados</td>
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

<!-- Modal Nuevo Producto -->
<div class="modal fade" id="modalNuevoProducto" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nuevo_nombre">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Categoría <span class="text-danger">*</span></label>
                        <select class="form-select" id="nuevo_categoria">
                            <option value="">Seleccionar...</option>
                            <option value="Pantallas">Pantallas</option>
                            <option value="Baterías">Baterías</option>
                            <option value="Centro de Carga">Centro de Carga</option>
                            <option value="Herramientas">Herramientas</option>
                            <option value="Flexor">Flexor</option>
                            <option value="Otros">Otros</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cantidad <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="nuevo_cantidad" min="0">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Stock Mínimo</label>
                        <input type="number" class="form-control" id="nuevo_stock_minimo" min="0" value="1">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Precio Compra</label>
                        <input type="number" class="form-control" id="nuevo_precio_compra" min="0" step="0.01">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Precio Venta</label>
                        <input type="number" class="form-control" id="nuevo_precio_venta" min="0" step="0.01">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" id="nuevo_descripcion" rows="2"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarProducto">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Producto -->
<div class="modal fade" id="modalEditarProducto" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editar_id">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editar_nombre">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Categoría <span class="text-danger">*</span></label>
                        <select class="form-select" id="editar_categoria">
                            <option value="Pantallas">Pantallas</option>
                            <option value="Baterías">Baterías</option>
                            <option value="Centro de Carga">Centro de Carga</option>
                            <option value="Herramientas">Herramientas</option>
                            <option value="Flexor">Flexor</option>
                            <option value="Otros">Otros</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cantidad <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="editar_cantidad" min="0">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Stock Mínimo</label>
                        <input type="number" class="form-control" id="editar_stock_minimo" min="0">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Precio Compra</label>
                        <input type="number" class="form-control" id="editar_precio_compra" min="0" step="0.01">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Precio Venta</label>
                        <input type="number" class="form-control" id="editar_precio_venta" min="0" step="0.01">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" id="editar_descripcion" rows="2"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" id="btnActualizarProducto">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Eliminar -->
<div class="modal fade" id="modalEliminarProducto" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="eliminar_id">
                <p>¿Eliminar el producto <strong id="eliminar_nombre"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
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

    // Guardar producto
    document.getElementById('btnGuardarProducto').addEventListener('click', function() {
        const nombre = document.getElementById('nuevo_nombre').value.trim();
        const categoria = document.getElementById('nuevo_categoria').value;
        const cantidad = document.getElementById('nuevo_cantidad').value;
        if (!nombre || !categoria || cantidad === '') {
            alert('Nombre, categoría y cantidad son obligatorios');
            return;
        }
        $.ajax({
            url: BASE_URL + 'inventario/guardar',
            method: 'POST',
            dataType: 'json',
            data: {
                nombre: nombre,
                categoria: categoria,
                cantidad: cantidad,
                precio_compra: document.getElementById('nuevo_precio_compra').value,
                precio_venta: document.getElementById('nuevo_precio_venta').value,
                stock_minimo: document.getElementById('nuevo_stock_minimo').value,
                descripcion: document.getElementById('nuevo_descripcion').value.trim()
            },
            success: function(res) {
                if (res.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalNuevoProducto'));
                    modal.hide();
                    document.getElementById('modalNuevoProducto').addEventListener('hidden.bs.modal', function() {
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

    // Abrir modal editar
    document.querySelectorAll('.btn-editar').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('editar_id').value = this.dataset.id;
            document.getElementById('editar_nombre').value = this.dataset.nombre;
            document.getElementById('editar_categoria').value = this.dataset.categoria;
            document.getElementById('editar_cantidad').value = this.dataset.cantidad;
            document.getElementById('editar_precio_compra').value = this.dataset.precio_compra;
            document.getElementById('editar_precio_venta').value = this.dataset.precio_venta;
            document.getElementById('editar_stock_minimo').value = this.dataset.stock_minimo;
            document.getElementById('editar_descripcion').value = this.dataset.descripcion;
            new bootstrap.Modal(document.getElementById('modalEditarProducto')).show();
        });
    });

    // Actualizar producto
    document.getElementById('btnActualizarProducto').addEventListener('click', function() {
        $.ajax({
            url: BASE_URL + 'inventario/editar',
            method: 'POST',
            dataType: 'json',
            data: {
                id: document.getElementById('editar_id').value,
                nombre: document.getElementById('editar_nombre').value.trim(),
                categoria: document.getElementById('editar_categoria').value,
                cantidad: document.getElementById('editar_cantidad').value,
                precio_compra: document.getElementById('editar_precio_compra').value,
                precio_venta: document.getElementById('editar_precio_venta').value,
                stock_minimo: document.getElementById('editar_stock_minimo').value,
                descripcion: document.getElementById('editar_descripcion').value.trim()
            },
            success: function(res) {
                if (res.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarProducto'));
                    modal.hide();
                    document.getElementById('modalEditarProducto').addEventListener('hidden.bs.modal', function() {
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

    // Abrir modal eliminar
    document.querySelectorAll('.btn-eliminar').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('eliminar_id').value = this.dataset.id;
            document.getElementById('eliminar_nombre').textContent = this.dataset.nombre;
            new bootstrap.Modal(document.getElementById('modalEliminarProducto')).show();
        });
    });

    // Confirmar eliminar
    document.getElementById('btnConfirmarEliminar').addEventListener('click', function() {
        $.ajax({
            url: BASE_URL + 'inventario/eliminar',
            method: 'POST',
            dataType: 'json',
            data: {
                id: document.getElementById('eliminar_id').value
            },
            success: function(res) {
                if (res.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalEliminarProducto'));
                    modal.hide();
                    document.getElementById('modalEliminarProducto').addEventListener('hidden.bs.modal', function() {
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

    // Ordenamiento de tabla
    document.querySelectorAll('#tablaInventario th').forEach(function(th, index) {
        if (index === 8) return;
        th.style.cursor = 'pointer';
        th.dataset.orden = 'asc';
        th.title = 'Click para ordenar';
        th.addEventListener('click', function() {
            const orden = this.dataset.orden;
            const tbody = document.querySelector('#tablaInventario tbody');
            const filas = Array.from(tbody.querySelectorAll('tr'));
            document.querySelectorAll('#tablaInventario th').forEach(t => {
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