<?php
class Auth
{
    public static function check()
    {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }
        $expiracion = $_SESSION['config_expiracion'] ?? 28800;
        if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > $expiracion) {
            session_destroy();
            header('Location: ' . BASE_URL . 'auth/login?expired=1');
            exit;
        }
    }

    public static function usuario()
    {
        return $_SESSION['usuario_nombre'] ?? 'Admin';
    }

    public static function rol()
    {
        return $_SESSION['usuario_rol'] ?? null;
    }

    public static function esAdmin()
    {
        return isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin';
    }

    public static function checkRol($rol)
    {
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== $rol) {
            header('Location: ' . BASE_URL . '?acceso=denegado');
            exit;
        }
    }
}
