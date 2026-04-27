<?php
class ClientesController extends Controller
{

    private $model;

    public function __construct()
    {
        Auth::check();
        $this->model = $this->model('ClienteModel');
    }

    public function index()
    {
        $clientes = $this->model->getAll();
        $this->view('clientes/index', ['clientes' => $clientes]);
    }

    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'nombre'   => trim($_POST['nombre']),
                'telefono' => trim($_POST['telefono'])
            ];

            if ($this->model->telefonoExiste($data['telefono'])) {
                echo json_encode(['success' => false, 'mensaje' => 'El número ' . $data['telefono'] . ' ya está registrado']);
                exit;
            }

            if ($this->model->create($data)) {
                echo json_encode(['success' => true, 'mensaje' => 'Cliente registrado correctamente']);
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'Error al registrar cliente']);
            }
        }
        exit;
    }

    public function editar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $data = [
                'nombre'   => trim($_POST['nombre']),
                'telefono' => trim($_POST['telefono'])
            ];
            if ($this->model->telefonoExiste($data['telefono'], $id)) {
                echo json_encode(['success' => false, 'mensaje' => 'El número ' . $data['telefono'] . ' ya está registrado en otro cliente']);
                exit;
            }
            if ($this->model->update($id, $data)) {
                echo json_encode(['success' => true, 'mensaje' => 'Cliente actualizado correctamente']);
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'Error al actualizar cliente']);
            }
        }
        exit;
    }

    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            if ($this->model->delete($id)) {
                echo json_encode(['success' => true, 'mensaje' => 'Cliente eliminado correctamente']);
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'Error al eliminar cliente']);
            }
        }
        exit;
    }

    public function getCliente()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $cliente = $this->model->getById($id);
            echo json_encode($cliente);
        }
        exit;
    }
}
