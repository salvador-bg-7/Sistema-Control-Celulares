<?php
class ReportesController extends Controller
{

    private $model;

    public function __construct()
    {
        Auth::check();
        Auth::checkRol('admin');
        $this->model = $this->model('ReportesModel');
    }

    public function index()
    {
        $desde = $_GET['desde'] ?? date('Y-m-01');
        $hasta = $_GET['hasta'] ?? date('Y-m-d');
        $estado = $_GET['estado'] ?? '';

        $this->view('reportes/index', [
            'desde'          => $desde,
            'hasta'          => $hasta,
            'estado'         => $estado,
            'ordenes'        => $this->model->getOrdenes($desde, $hasta, $estado),
            'ingresos'       => $this->model->getIngresos($desde, $hasta),
            'gastos'         => $this->model->getGastos($desde, $hasta),
            'totalIngresos'  => $this->model->getTotalIngresos($desde, $hasta),
            'totalGastos'    => $this->model->getTotalGastos($desde, $hasta),
            'gastosPorCategoria' => $this->model->getGastosPorCategoria($desde, $hasta),
            'ordenesPorEstado'   => $this->model->getOrdenesPorEstado($desde, $hasta)
        ]);
    }
}
