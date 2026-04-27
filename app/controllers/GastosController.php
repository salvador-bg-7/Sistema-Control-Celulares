<?php
class GastosController extends Controller
{

    private $model;

    public function __construct()
    {
        Auth::check();
        Auth::checkRol('admin');
        $this->model = $this->model('GastoModel');
    }

    public function index()
    {
        $gastos   = $this->model->getAll();
        $totalMes = $this->model->getTotalMes();
        $gastoMasAlto   = $this->model->getGastoMasAltoMes();
        $categoriaMas   = $this->model->getCategoriaMasGastoMes();
        $this->view('gastos/index', [
            'gastos'        => $gastos,
            'totalMes'      => $totalMes,
            'gastoMasAlto'  => $gastoMasAlto,
            'categoriaMas'  => $categoriaMas
        ]);
    }

    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'concepto'    => trim($_POST['concepto']),
                'categoria'   => $_POST['categoria'],
                'monto'       => $_POST['monto'],
                'metodo_pago' => $_POST['metodo_pago'],
                'fecha'       => $_POST['fecha'],
                'notas'       => trim($_POST['notas'])
            ];
            if ($this->model->create($data)) {
                echo json_encode(['success' => true, 'mensaje' => 'Gasto registrado correctamente']);
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'Error al registrar gasto']);
            }
        }
        exit;
    }

    public function editar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $data = [
                'concepto'    => trim($_POST['concepto']),
                'categoria'   => $_POST['categoria'],
                'monto'       => $_POST['monto'],
                'metodo_pago' => $_POST['metodo_pago'],
                'fecha'       => $_POST['fecha'],
                'notas'       => trim($_POST['notas'])
            ];
            if ($this->model->update($id, $data)) {
                echo json_encode(['success' => true, 'mensaje' => 'Gasto actualizado correctamente']);
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'Error al actualizar gasto']);
            }
        }
        exit;
    }

    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            if ($this->model->delete($id)) {
                echo json_encode(['success' => true, 'mensaje' => 'Gasto eliminado correctamente']);
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'Error al eliminar gasto']);
            }
        }
        exit;
    }
}
