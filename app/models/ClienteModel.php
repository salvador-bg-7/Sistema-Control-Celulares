<?php
class ClienteModel extends Model
{

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM clientes ORDER BY fecha_registro DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO clientes (nombre, telefono) VALUES (?, ?)");
        return $stmt->execute([$data['nombre'], $data['telefono']]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE clientes SET nombre=?, telefono=? WHERE id=?");
        return $stmt->execute([$data['nombre'], $data['telefono'], $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM clientes WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function telefonoExiste($telefono, $excludeId = null)
    {
        if ($excludeId) {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM clientes WHERE telefono = ? AND id != ?");
            $stmt->execute([$telefono, $excludeId]);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM clientes WHERE telefono = ?");
            $stmt->execute([$telefono]);
        }
        return $stmt->fetch(PDO::FETCH_OBJ)->total > 0;
    }
}
