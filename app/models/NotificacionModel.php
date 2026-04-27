<?php
class NotificacionModel extends Model
{

    public function getNoLeidas()
    {
        $stmt = $this->db->prepare("SELECT * FROM notificaciones WHERE leida = 0 ORDER BY fecha DESC LIMIT 10");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTotalNoLeidas()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM notificaciones WHERE leida = 0");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }

    public function marcarLeida($id)
    {
        $stmt = $this->db->prepare("UPDATE notificaciones SET leida = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function marcarTodasLeidas()
    {
        $stmt = $this->db->prepare("UPDATE notificaciones SET leida = 1");
        return $stmt->execute();
    }

    public function generarNotificaciones()
    {
        // Limpiar notificaciones automáticas anteriores no leídas
        $this->db->prepare("DELETE FROM notificaciones WHERE leida = 0 AND tipo IN ('orden_lista','stock_bajo','orden_antigua')")->execute();

        // Órdenes listas sin cobrar
        $stmt = $this->db->prepare("
            SELECT o.id, o.folio, c.nombre as cliente
            FROM ordenes o
            INNER JOIN clientes c ON o.cliente_id = c.id
            WHERE o.estado = 'Listo'
            AND o.id NOT IN (SELECT orden_id FROM caja)
        ");
        $stmt->execute();
        foreach ($stmt->fetchAll(PDO::FETCH_OBJ) as $o) {
            $this->db->prepare("INSERT INTO notificaciones (tipo, mensaje, referencia_id) VALUES ('orden_lista', ?, ?)")
                ->execute(["Orden {$o->folio} de {$o->cliente} lista para cobrar", $o->id]);
        }

        // Stock bajo
        $stmt = $this->db->prepare("SELECT * FROM inventario WHERE cantidad <= stock_minimo");
        $stmt->execute();
        foreach ($stmt->fetchAll(PDO::FETCH_OBJ) as $p) {
            $this->db->prepare("INSERT INTO notificaciones (tipo, mensaje, referencia_id) VALUES ('stock_bajo', ?, ?)")
                ->execute(["{$p->nombre} tiene stock bajo ({$p->cantidad} unidades)", $p->id]);
        }

        // Órdenes antiguas activas más de 7 días
        $stmt = $this->db->prepare("
            SELECT o.id, o.folio, c.nombre as cliente, DATEDIFF(NOW(), o.fecha_ingreso) as dias
            FROM ordenes o
            INNER JOIN clientes c ON o.cliente_id = c.id
            WHERE o.estado NOT IN ('Entregado')
            AND DATEDIFF(NOW(), o.fecha_ingreso) > 7
        ");
        $stmt->execute();
        foreach ($stmt->fetchAll(PDO::FETCH_OBJ) as $o) {
            $this->db->prepare("INSERT INTO notificaciones (tipo, mensaje, referencia_id) VALUES ('orden_antigua', ?, ?)")
                ->execute(["Orden {$o->folio} de {$o->cliente} lleva {$o->dias} días activa", $o->id]);
        }
    }
}
