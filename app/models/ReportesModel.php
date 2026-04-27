<?php
class ReportesModel extends Model
{

    public function getOrdenes($desde, $hasta, $estado = '')
    {
        $sql = "
            SELECT o.*, c.nombre as cliente_nombre
            FROM ordenes o
            INNER JOIN clientes c ON o.cliente_id = c.id
            WHERE DATE(o.fecha_ingreso) BETWEEN ? AND ?
        ";
        $params = [$desde, $hasta];
        if ($estado !== '') {
            $sql .= " AND o.estado = ?";
            $params[] = $estado;
        }
        $sql .= " ORDER BY o.fecha_ingreso DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getIngresos($desde, $hasta)
    {
        $stmt = $this->db->prepare("
            SELECT c.*, o.folio, o.marca, o.modelo, cl.nombre as cliente_nombre
            FROM caja c
            INNER JOIN ordenes o ON c.orden_id = o.id
            INNER JOIN clientes cl ON o.cliente_id = cl.id
            WHERE DATE(c.fecha_cobro) BETWEEN ? AND ?
            ORDER BY c.fecha_cobro DESC
        ");
        $stmt->execute([$desde, $hasta]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getGastos($desde, $hasta)
    {
        $stmt = $this->db->prepare("SELECT * FROM gastos WHERE fecha BETWEEN ? AND ? ORDER BY fecha DESC");
        $stmt->execute([$desde, $hasta]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTotalIngresos($desde, $hasta)
    {
        $stmt = $this->db->prepare("SELECT COALESCE(SUM(monto), 0) as total FROM caja WHERE DATE(fecha_cobro) BETWEEN ? AND ?");
        $stmt->execute([$desde, $hasta]);
        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }

    public function getTotalGastos($desde, $hasta)
    {
        $stmt = $this->db->prepare("SELECT COALESCE(SUM(monto), 0) as total FROM gastos WHERE fecha BETWEEN ? AND ?");
        $stmt->execute([$desde, $hasta]);
        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }

    public function getGastosPorCategoria($desde, $hasta)
    {
        $stmt = $this->db->prepare("
            SELECT categoria, SUM(monto) as total
            FROM gastos
            WHERE fecha BETWEEN ? AND ?
            GROUP BY categoria
            ORDER BY total DESC
        ");
        $stmt->execute([$desde, $hasta]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getOrdenesPorEstado($desde, $hasta)
    {
        $stmt = $this->db->prepare("
            SELECT estado, COUNT(*) as total
            FROM ordenes
            WHERE DATE(fecha_ingreso) BETWEEN ? AND ?
            GROUP BY estado
        ");
        $stmt->execute([$desde, $hasta]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
