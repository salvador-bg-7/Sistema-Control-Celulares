<?php
class PagosController extends Controller
{

    private $model;

    public function __construct()
    {
        Auth::check();
        Auth::checkRol('admin');
        $this->model = $this->model('PagosModel');
    }

    public function index()
    {
        $desde = $_GET['desde'] ?? date('Y-m-01');
        $hasta = $_GET['hasta'] ?? date('Y-m-d');

        $ingresos       = $this->model->getIngresos($desde, $hasta);
        $gastos         = $this->model->getGastos($desde, $hasta);
        $totalIngresos  = $this->model->getTotalIngresos($desde, $hasta);
        $totalGastos    = $this->model->getTotalGastos($desde, $hasta);
        $ingresosDia    = $this->model->getIngresosPorDia($desde, $hasta);
        $ingresosMes    = $this->model->getIngresosPorMes();
        $gastosMes      = $this->model->getGastosPorMes();
        $totalesMetodo  = $this->model->getTotalesPorMetodo($desde, $hasta);

        $this->view('pagos/index', [
            'ingresos'      => $ingresos,
            'gastos'        => $gastos,
            'totalIngresos' => $totalIngresos,
            'totalGastos'   => $totalGastos,
            'balance'       => $totalIngresos - $totalGastos,
            'ingresosDia'   => $ingresosDia,
            'ingresosMes'   => $ingresosMes,
            'gastosMes'     => $gastosMes,
            'totalesMetodo' => $totalesMetodo,
            'desde'         => $desde,
            'hasta'         => $hasta
        ]);
    }
}
