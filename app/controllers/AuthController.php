<?php
class AuthController extends Controller
{

    private $model;

    public function __construct()
    {
        $this->model = $this->model('UsuarioModel');
    }

    public function login()
    {
        if (isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
        $this->view('auth/login');
    }

    public function autenticar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario  = trim($_POST['usuario']);
            $password = trim($_POST['password']);

            if (empty($usuario) || empty($password)) {
                $this->view('auth/login', ['error' => 'Todos los campos son obligatorios']);
                return;
            }

            // Protección contra fuerza bruta
            if (!isset($_SESSION['intentos'])) $_SESSION['intentos'] = 0;
            if (!isset($_SESSION['ultimo_intento'])) $_SESSION['ultimo_intento'] = time();

            if ($_SESSION['intentos'] >= 5) {
                $tiempoBloqueo = 300; // 5 minutos
                $tiempoRestante = $tiempoBloqueo - (time() - $_SESSION['ultimo_intento']);
                if ($tiempoRestante > 0) {
                    $this->view('auth/login', ['error' => 'Demasiados intentos fallidos. Espera ' . ceil($tiempoRestante / 60) . ' minuto(s)']);
                    return;
                } else {
                    $_SESSION['intentos'] = 0;
                }
            }

            $user = $this->model->getByUsuario($usuario);

            if ($user && $this->model->verificarPassword($password, $user->password)) {
                // Login exitoso
                $_SESSION['intentos']      = 0;
                $_SESSION['usuario_id']    = $user->id;
                $_SESSION['usuario_nombre'] = $user->nombre;
                $_SESSION['usuario_rol']   = $user->rol;
                $_SESSION['usuario_user']  = $user->usuario;
                $_SESSION['login_time']    = time();
                $_SESSION['recien_login'] = true;

                $this->model->actualizarUltimoAcceso($user->id);

                header('Location: ' . BASE_URL);
                exit;
            } else {
                $_SESSION['intentos']++;
                $_SESSION['ultimo_intento'] = time();
                $restantes = 5 - $_SESSION['intentos'];
                $this->view('auth/login', ['error' => 'Usuario o contraseña incorrectos. Intentos restantes: ' . $restantes]);
            }
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: ' . BASE_URL . 'auth/login');
        exit;
    }
}
