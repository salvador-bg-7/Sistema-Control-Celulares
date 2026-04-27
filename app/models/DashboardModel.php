<?php
class DashboardModel extends Model
{

    public function getTotalClientes()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM clientes");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }

    public function getOrdenesActivas()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM ordenes WHERE estado NOT IN ('Entregado')");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }

    public function getIngresosMes()
    {
        $stmt = $this->db->prepare("SELECT COALESCE(SUM(monto), 0) as total FROM caja WHERE MONTH(fecha_cobro) = MONTH(CURDATE()) AND YEAR(fecha_cobro) = YEAR(CURDATE())");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }

    public function getGastosMes()
    {
        $stmt = $this->db->prepare("SELECT COALESCE(SUM(monto), 0) as total FROM gastos WHERE MONTH(fecha) = MONTH(CURDATE()) AND YEAR(fecha) = YEAR(CURDATE())");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }

    public function getOrdenesRecientes()
    {
        $stmt = $this->db->prepare("
            SELECT o.*, c.nombre as cliente_nombre 
            FROM ordenes o 
            INNER JOIN clientes c ON o.cliente_id = c.id 
            ORDER BY o.fecha_ingreso DESC 
            LIMIT 5
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getOrdenesAntiguas()
    {
        $stmt = $this->db->prepare("
            SELECT o.*, c.nombre as cliente_nombre 
            FROM ordenes o 
            INNER JOIN clientes c ON o.cliente_id = c.id 
            WHERE o.estado NOT IN ('Entregado')
            ORDER BY o.fecha_ingreso ASC 
            LIMIT 5
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getStockBajo()
    {
        $stmt = $this->db->prepare("SELECT * FROM inventario WHERE cantidad <= stock_minimo ORDER BY cantidad ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getIngresosMes6()
    {
        $stmt = $this->db->prepare("
            SELECT DATE_FORMAT(fecha_cobro, '%Y-%m') as mes, SUM(monto) as total
            FROM caja
            WHERE fecha_cobro >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(fecha_cobro, '%Y-%m')
            ORDER BY mes ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getGastosMes6()
    {
        $stmt = $this->db->prepare("
            SELECT DATE_FORMAT(fecha, '%Y-%m') as mes, SUM(monto) as total
            FROM gastos
            WHERE fecha >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(fecha, '%Y-%m')
            ORDER BY mes ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
