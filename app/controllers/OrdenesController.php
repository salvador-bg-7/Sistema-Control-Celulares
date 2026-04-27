<?php
class OrdenesController extends Controller
{

    private $model;
    private $clienteModel;

    public function __construct()
    {
        Auth::check();
        $this->model = $this->model('OrdenModel');
        $this->clienteModel = $this->model('ClienteModel');
    }

    public function index()
    {
        $ordenes = $this->model->getAll();
        $clientes = $this->clienteModel->getAll();
        $this->view('ordenes/index', ['ordenes' => $ordenes, 'clientes' => $clientes]);
    }

    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'folio'                 => $this->model->generarFolio(),
                'cliente_id'            => $_POST['cliente_id'],
                'marca'                 => trim($_POST['marca']),
                'modelo'                => trim($_POST['modelo']),
                'falla_reportada'       => trim($_POST['falla_reportada']),
                'detalles'              => trim($_POST['detalles']),
                'anticipo'              => $_POST['anticipo'] ?: 0,
                'costo_estimado'        => $_POST['costo_estimado'] ?: 0,
                'costo_final'           => $_POST['costo_final'] ?: 0,
                'estado'                => $_POST['estado'],
                'fecha_entrega_estimada' => $_POST['fecha_entrega_estimada'] ?: null
            ];
            if ($this->model->create($data)) {
                $ultimoId = $this->model->lastInsertId();

                // Registrar anticipo en caja si es mayor a 0
                if ($data['anticipo'] > 0) {
                    $cajaModel = $this->model('CajaModel');
                    $cajaModel->registrarAnticipo($ultimoId, $data['anticipo']);
                }

                echo json_encode(['success' => true, 'mensaje' => 'Orden registrada correctamente']);
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'Error al registrar orden']);
            }
        }
        exit;
    }

    public function editar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $data = [
                'cliente_id'            => $_POST['cliente_id'],
                'marca'                 => trim($_POST['marca']),
                'modelo'                => trim($_POST['modelo']),
                'falla_reportada'       => trim($_POST['falla_reportada']),
                'detalles'              => trim($_POST['detalles']),
                'anticipo'              => $_POST['anticipo'] ?: 0,
                'costo_estimado'        => $_POST['costo_estimado'] ?: 0,
                'costo_final'           => $_POST['costo_final'] ?: 0,
                'estado'                => $_POST['estado'],
                'fecha_entrega_estimada' => $_POST['fecha_entrega_estimada'] ?: null
            ];
            if ($this->model->update($id, $data)) {
                echo json_encode(['success' => true, 'mensaje' => 'Orden actualizada correctamente']);
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'Error al actualizar orden']);
            }
        }
        exit;
    }

    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            if ($this->model->delete($id)) {
                echo json_encode(['success' => true, 'mensaje' => 'Orden eliminada correctamente']);
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'Error al eliminar orden']);
            }
        }
        exit;
    }

    public function getOrden()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $orden = $this->model->getById($id);
            echo json_encode($orden);
        }
        exit;
    }
}
