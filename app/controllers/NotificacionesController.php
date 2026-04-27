<?php
class NotificacionesController extends Controller
{

    private $model;

    public function __construct()
    {
        $this->model = $this->model('NotificacionModel');
    }

    public function getNotificaciones()
    {
        $this->model->generarNotificaciones();
        echo json_encode([
            'total'         => $this->model->getTotalNoLeidas(),
            'notificaciones' => $this->model->getNoLeidas()
        ]);
        exit;
    }

    public function marcarLeida()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $this->model->marcarLeida($id);
            echo json_encode(['success' => true]);
        }
        exit;
    }

    public function marcarTodas()
    {
        $this->model->marcarTodasLeidas();
        echo json_encode(['success' => true]);
        exit;
    }
}
