<?php
class AjustesController extends Controller
{

    private $model;

    public function __construct()
    {
        Auth::check();
        Auth::checkRol('admin');
        $this->model = $this->model('UsuarioModel');
    }

    public function index()
    {
        $usuarios = $this->model->getAll();
        $this->view('ajustes/index', ['usuarios' => $usuarios]);
    }

    public function crearUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'nombre'   => trim($_POST['nombre']),
                'usuario'  => trim($_POST['usuario']),
                'password' => $_POST['password'],
                'rol'      => $_POST['rol']
            ];

            if (empty($data['nombre']) || empty($data['usuario']) || empty($data['password'])) {
                echo json_encode(['success' => false, 'mensaje' => 'Todos los campos son obligatorios']);
                exit;
            }

            if (strlen($data['password']) < 8) {
                echo json_encode(['success' => false, 'mensaje' => 'La contraseña debe tener al menos 8 caracteres']);
                exit;
            }

            if ($this->model->usuarioExiste($data['usuario'])) {
                echo json_encode(['success' => false, 'mensaje' => 'El nombre de usuario ya existe']);
                exit;
            }

            if ($this->model->create($data)) {
                echo json_encode(['success' => true, 'mensaje' => 'Usuario creado correctamente']);
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'Error al crear usuario']);
            }
        }
        exit;
    }

    public function editarUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id   = $_POST['id'];
            $data = [
                'nombre'  => trim($_POST['nombre']),
                'usuario' => trim($_POST['usuario']),
                'rol'     => $_POST['rol']
            ];

            if ($this->model->usuarioExiste($data['usuario'], $id)) {
                echo json_encode(['success' => false, 'mensaje' => 'El nombre de usuario ya existe']);
                exit;
            }

            if ($this->model->update($id, $data)) {
                echo json_encode(['success' => true, 'mensaje' => 'Usuario actualizado correctamente']);
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'Error al actualizar usuario']);
            }
        }
        exit;
    }

    public function cambiarPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id       = $_POST['id'];
            $password = $_POST['password'];
            $confirm  = $_POST['confirm'];

            if (strlen($password) < 8) {
                echo json_encode(['success' => false, 'mensaje' => 'La contraseña debe tener al menos 8 caracteres']);
                exit;
            }

            if ($password !== $confirm) {
                echo json_encode(['success' => false, 'mensaje' => 'Las contraseñas no coinciden']);
                exit;
            }

            if ($this->model->cambiarPassword($id, $password)) {
                echo json_encode(['success' => true, 'mensaje' => 'Contraseña actualizada correctamente']);
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'Error al actualizar contraseña']);
            }
        }
        exit;
    }

    public function toggleUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            if ($id == $_SESSION['usuario_id']) {
                echo json_encode(['success' => false, 'mensaje' => 'No puedes desactivar tu propio usuario']);
                exit;
            }
            if ($this->model->toggleActivo($id)) {
                echo json_encode(['success' => true, 'mensaje' => 'Estado actualizado correctamente']);
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'Error al actualizar estado']);
            }
        }
        exit;
    }

    public function miPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id          = $_SESSION['usuario_id'];
            $actual      = $_POST['password_actual'];
            $nueva       = $_POST['password_nueva'];
            $confirmar   = $_POST['password_confirmar'];

            $user = $this->model->getById($id);

            if (!$this->model->verificarPassword($actual, $user->password)) {
                echo json_encode(['success' => false, 'mensaje' => 'La contraseña actual es incorrecta']);
                exit;
            }

            if (strlen($nueva) < 8) {
                echo json_encode(['success' => false, 'mensaje' => 'La nueva contraseña debe tener al menos 8 caracteres']);
                exit;
            }

            if ($nueva !== $confirmar) {
                echo json_encode(['success' => false, 'mensaje' => 'Las contraseñas no coinciden']);
                exit;
            }

            if ($this->model->cambiarPassword($id, $nueva)) {
                echo json_encode(['success' => true, 'mensaje' => 'Contraseña actualizada correctamente']);
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'Error al actualizar contraseña']);
            }
        }
        exit;
    }

    public function guardarConfig()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $expiracion = intval($_POST['expiracion']);
            if ($expiracion < 1 || $expiracion > 24) {
                echo json_encode(['success' => false, 'mensaje' => 'El tiempo debe ser entre 1 y 24 horas']);
                exit;
            }
            $_SESSION['config_expiracion'] = $expiracion * 3600;
            echo json_encode(['success' => true, 'mensaje' => 'Configuración guardada correctamente']);
        }
        exit;
    }
}
