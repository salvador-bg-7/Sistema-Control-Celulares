<?php
class UsuarioModel extends Model
{

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT id, nombre, usuario, rol, activo, fecha_registro, ultimo_acceso FROM usuarios ORDER BY fecha_registro DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getByUsuario($usuario)
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE usuario = ? AND activo = 1");
        $stmt->execute([$usuario]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function verificarPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public function usuarioExiste($usuario, $excludeId = null)
    {
        if ($excludeId) {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM usuarios WHERE usuario = ? AND id != ?");
            $stmt->execute([$usuario, $excludeId]);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM usuarios WHERE usuario = ?");
            $stmt->execute([$usuario]);
        }
        return $stmt->fetch(PDO::FETCH_OBJ)->total > 0;
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, usuario, password, rol) VALUES (?,?,?,?)");
        return $stmt->execute([
            $data['nombre'],
            $data['usuario'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['rol']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE usuarios SET nombre=?, usuario=?, rol=? WHERE id=?");
        return $stmt->execute([$data['nombre'], $data['usuario'], $data['rol'], $id]);
    }

    public function cambiarPassword($id, $password)
    {
        $stmt = $this->db->prepare("UPDATE usuarios SET password=? WHERE id=?");
        return $stmt->execute([password_hash($password, PASSWORD_BCRYPT), $id]);
    }

    public function toggleActivo($id)
    {
        $stmt = $this->db->prepare("UPDATE usuarios SET activo = NOT activo WHERE id=?");
        return $stmt->execute([$id]);
    }

    public function actualizarUltimoAcceso($id)
    {
        $stmt = $this->db->prepare("UPDATE usuarios SET ultimo_acceso = NOW() WHERE id=?");
        return $stmt->execute([$id]);
    }
}
