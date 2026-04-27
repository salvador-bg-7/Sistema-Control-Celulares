<?php
class CajaController extends Controller
{

    private $model;

    public function __construct()
    {
        Auth::check();
        $this->model = $this->model('CajaModel');
    }

    public function index()
    {
        $cobros = $this->model->getAll();
        $totalDia = $this->model->getTotalDia();
        $totalMes = $this->model->getTotalMes();
        $ordenesListas = $this->model->getOrdenesListas();
        $this->view('caja/index', [
            'cobros'        => $cobros,
            'totalDia'      => $totalDia,
            'totalMes'      => $totalMes,
            'ordenesListas' => $ordenesListas
        ]);
    }

    public function cobrar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $orden_id = $_POST['orden_id'];

            if ($this->model->ordenYaCobrada($orden_id)) {
                echo json_encode(['success' => false, 'mensaje' => 'Esta orden ya fue cobrada']);
                exit;
            }

            $data = [
                'orden_id'    => $orden_id,
                'monto'       => $_POST['monto'],
                'metodo_pago' => $_POST['metodo_pago'],
                'notas'       => trim($_POST['notas'])
            ];

            if ($this->model->create($data)) {
                // Actualizar estado de la orden a Entregado
                $ordenModel = $this->model('OrdenModel');
                $orden = $ordenModel->getById($orden_id);
                $dataOrden = [
                    'cliente_id'             => $orden->cliente_id,
                    'marca'                  => $orden->marca,
                    'modelo'                 => $orden->modelo,
                    'falla_reportada'        => $orden->falla_reportada,
                    'detalles'               => $orden->detalles,
                    'costo_estimado'         => $orden->costo_estimado,
                    'costo_final'            => $orden->costo_final,
                    'estado'                 => 'Entregado',
                    'fecha_entrega_estimada' => $orden->fecha_entrega_estimada
                ];
                $ordenModel->update($orden_id, $dataOrden);
                echo json_encode(['success' => true, 'mensaje' => 'Cobro registrado correctamente']);
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'Error al registrar cobro']);
            }
        }
        exit;
    }
}
