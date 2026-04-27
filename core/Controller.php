<?php
class Controller
{
    public function model($model)
    {
        require_once APP_ROOT . '/app/models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = [])
    {
        extract($data);
        require_once APP_ROOT . '/app/views/' . $view . '.php';
    }
}
