<?php
class OrdenModel extends Model
{

    public function getAll()
    {
        $stmt = $this->db->prepare("
            SELECT o.*, c.nombre as cliente_nombre 
            FROM ordenes o 
            INNER JOIN clientes c ON o.cliente_id = c.id 
            ORDER BY o.fecha_ingreso DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT o.*, c.nombre as cliente_nombre, c.telefono as cliente_telefono
            FROM ordenes o
            INNER JOIN clientes c ON o.cliente_id = c.id
            WHERE o.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function generarFolio()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM ordenes");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        $numero = str_pad($row->total + 1, 4, '0', STR_PAD_LEFT);
        return 'DRD-' . $numero;
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
    INSERT INTO ordenes (folio, cliente_id, marca, modelo, falla_reportada, detalles, anticipo, costo_estimado, costo_final, estado, fecha_entrega_estimada) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
        return $stmt->execute([
            $data['folio'],
            $data['cliente_id'],
            $data['marca'],
            $data['modelo'],
            $data['falla_reportada'],
            $data['detalles'],
            $data['anticipo'],
            $data['costo_estimado'],
            $data['costo_final'],
            $data['estado'],
            $data['fecha_entrega_estimada']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
    UPDATE ordenes SET cliente_id=?, marca=?, modelo=?, falla_reportada=?, detalles=?, 
    anticipo=?, costo_estimado=?, costo_final=?, estado=?, fecha_entrega_estimada=? WHERE id=?
");
        return $stmt->execute([
            $data['cliente_id'],
            $data['marca'],
            $data['modelo'],
            $data['falla_reportada'],
            $data['detalles'],
            $data['anticipo'] ?? 0,
            $data['costo_estimado'],
            $data['costo_final'],
            $data['estado'],
            $data['fecha_entrega_estimada'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM ordenes WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
