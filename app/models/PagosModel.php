<?php
class PagosModel extends Model
{

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

    public function getIngresosPorDia($desde, $hasta)
    {
        $stmt = $this->db->prepare("
            SELECT DATE(fecha_cobro) as dia, SUM(monto) as total 
            FROM caja 
            WHERE DATE(fecha_cobro) BETWEEN ? AND ?
            GROUP BY DATE(fecha_cobro) 
            ORDER BY dia ASC
        ");
        $stmt->execute([$desde, $hasta]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getIngresosPorMes()
    {
        $stmt = $this->db->prepare("
            SELECT MONTH(fecha_cobro) as mes, SUM(monto) as total 
            FROM caja 
            WHERE YEAR(fecha_cobro) = YEAR(CURDATE())
            GROUP BY MONTH(fecha_cobro)
            ORDER BY mes ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getGastosPorMes()
    {
        $stmt = $this->db->prepare("
            SELECT MONTH(fecha) as mes, SUM(monto) as total 
            FROM gastos 
            WHERE YEAR(fecha) = YEAR(CURDATE())
            GROUP BY MONTH(fecha)
            ORDER BY mes ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTotalesPorMetodo($desde, $hasta)
    {
        $stmt = $this->db->prepare("
            SELECT metodo_pago, SUM(monto) as total 
            FROM caja 
            WHERE DATE(fecha_cobro) BETWEEN ? AND ?
            GROUP BY metodo_pago
        ");
        $stmt->execute([$desde, $hasta]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
