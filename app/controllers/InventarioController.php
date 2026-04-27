<?php
class InventarioController extends Controller
{

    private $model;

    public function __construct()
    {
        $this->model = $this->model('InventarioModel');
    }

    public function index()
    {
        $inventario = $this->model->getAll();
        $stockBajo = $this->model->getStockBajo();
        $this->view('inventario/index', [
            'inventario' => $inventario,
            'stockBajo'  => $stockBajo
        ]);
    }

    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'nombre'        => trim($_POST['nombre']),
                'categoria'     => $_POST['categoria'],
                'cantidad'      => intval($_POST['cantidad']),
                'precio_compra' => $_POST['precio_compra'] ?: 0,
                'precio_venta'  => $_POST['precio_venta'] ?: 0,
                'stock_minimo'  => intval($_POST['stock_minimo']),
                'descripcion'   => trim($_POST['descripcion'])
            ];
            if ($this->model->create($data)) {
                echo json_encode(['success' => true, 'mensaje' => 'Producto registrado correctamente']);
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'Error al registrar producto']);
            }
        }
        exit;
    }

    public function editar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $data = [
                'nombre'        => trim($_POST['nombre']),
                'categoria'     => $_POST['categoria'],
                'cantidad'      => intval($_POST['cantidad']),
                'precio_compra' => $_POST['precio_compra'] ?: 0,
                'precio_venta'  => $_POST['precio_venta'] ?: 0,
                'stock_minimo'  => intval($_POST['stock_minimo']),
                'descripcion'   => trim($_POST['descripcion'])
            ];
            if ($this->model->update($id, $data)) {
                echo json_encode(['success' => true, 'mensaje' => 'Producto actualizado correctamente']);
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'Error al actualizar producto']);
            }
        }
        exit;
    }

    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            if ($this->model->delete($id)) {
                echo json_encode(['success' => true, 'mensaje' => 'Producto eliminado correctamente']);
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'Error al eliminar producto']);
            }
        }
        exit;
    }
}
