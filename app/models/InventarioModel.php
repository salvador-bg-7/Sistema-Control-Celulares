<?php
class InventarioModel extends Model
{

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario ORDER BY nombre ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO inventario (nombre, categoria, cantidad, precio_compra, precio_venta, stock_minimo, descripcion) VALUES (?,?,?,?,?,?,?)");
        return $stmt->execute([
            $data['nombre'],
            $data['categoria'],
            $data['cantidad'],
            $data['precio_compra'],
            $data['precio_venta'],
            $data['stock_minimo'],
            $data['descripcion']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE inventario SET nombre=?, categoria=?, cantidad=?, precio_compra=?, precio_venta=?, stock_minimo=?, descripcion=? WHERE id=?");
        return $stmt->execute([
            $data['nombre'],
            $data['categoria'],
            $data['cantidad'],
            $data['precio_compra'],
            $data['precio_venta'],
            $data['stock_minimo'],
            $data['descripcion'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM inventario WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getStockBajo()
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario WHERE cantidad <= stock_minimo ORDER BY cantidad ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
