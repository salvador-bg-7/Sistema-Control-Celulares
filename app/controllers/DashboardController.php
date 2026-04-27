<?php
class DashboardController extends Controller
{

    private $model;

    public function __construct()
    {
        Auth::check();
        $this->model = $this->model('DashboardModel');
    }

    public function index()
    {
        $this->view('dashboard/index', [
            'totalClientes'   => $this->model->getTotalClientes(),
            'ordenesActivas'  => $this->model->getOrdenesActivas(),
            'ingresosMes'     => $this->model->getIngresosMes(),
            'gastosMes'       => $this->model->getGastosMes(),
            'ordenesRecientes' => $this->model->getOrdenesRecientes(),
            'ordenesAntiguas' => $this->model->getOrdenesAntiguas(),
            'stockBajo'       => $this->model->getStockBajo(),
            'ingresosMes6'    => $this->model->getIngresosMes6(),
            'gastosMes6'      => $this->model->getGastosMes6()
        ]);
    }
}
