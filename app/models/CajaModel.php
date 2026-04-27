<?php
class CajaModel extends Model
{

    public function getAll()
    {
        $stmt = $this->db->prepare("
            SELECT c.*, o.folio, o.marca, o.modelo, cl.nombre as cliente_nombre
            FROM caja c
            INNER JOIN ordenes o ON c.orden_id = o.id
            INNER JOIN clientes cl ON o.cliente_id = cl.id
            ORDER BY c.fecha_cobro DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT c.*, o.folio, o.marca, o.modelo, cl.nombre as cliente_nombre
            FROM caja c
            INNER JOIN ordenes o ON c.orden_id = o.id
            INNER JOIN clientes cl ON o.cliente_id = cl.id
            WHERE c.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO caja (orden_id, monto, metodo_pago, notas) 
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['orden_id'],
            $data['monto'],
            $data['metodo_pago'],
            $data['notas']
        ]);
    }

    public function getTotalDia()
    {
        $stmt = $this->db->prepare("
            SELECT COALESCE(SUM(monto), 0) as total 
            FROM caja 
            WHERE DATE(fecha_cobro) = CURDATE()
        ");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }

    public function getTotalMes()
    {
        $stmt = $this->db->prepare("
            SELECT COALESCE(SUM(monto), 0) as total 
            FROM caja 
            WHERE MONTH(fecha_cobro) = MONTH(CURDATE()) 
            AND YEAR(fecha_cobro) = YEAR(CURDATE())
        ");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }

    public function ordenYaCobrada($orden_id)
    {
        $stmt = $this->db->prepare("
        SELECT COUNT(*) as total FROM caja 
        WHERE orden_id = ? 
        AND (notas NOT LIKE 'Anticipo:%' OR notas IS NULL OR notas = '')
    ");
        $stmt->execute([$orden_id]);
        return $stmt->fetch(PDO::FETCH_OBJ)->total > 0;
    }

    public function getOrdenesListas()
    {
        $stmt = $this->db->prepare("
        SELECT o.id, o.folio, o.costo_final, o.anticipo, o.marca, o.modelo, cl.nombre as cliente_nombre
        FROM ordenes o
        INNER JOIN clientes cl ON o.cliente_id = cl.id
        WHERE o.estado = 'Listo'
        AND o.id NOT IN (
            SELECT orden_id FROM caja 
            WHERE notas NOT LIKE 'Anticipo:%' 
            OR notas IS NULL 
            OR notas = ''
        )
        ORDER BY o.fecha_ingreso DESC
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function registrarAnticipo($orden_id, $monto, $notas = '')
    {
        $stmt = $this->db->prepare("
        INSERT INTO caja (orden_id, monto, metodo_pago, notas) 
        VALUES (?, ?, 'Efectivo', ?)
    ");
        return $stmt->execute([$orden_id, $monto, 'Anticipo: ' . $notas]);
    }

    public function getAnticipoPorOrden($orden_id)
    {
        $stmt = $this->db->prepare("
        SELECT COALESCE(SUM(monto), 0) as total 
        FROM caja 
        WHERE orden_id = ? AND notas LIKE 'Anticipo:%'
    ");
        $stmt->execute([$orden_id]);
        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }
}
