<?php
class GastoModel extends Model
{

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM gastos ORDER BY fecha DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM gastos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO gastos (concepto, categoria, monto, metodo_pago, fecha, notas) VALUES (?,?,?,?,?,?)");
        return $stmt->execute([
            $data['concepto'],
            $data['categoria'],
            $data['monto'],
            $data['metodo_pago'],
            $data['fecha'],
            $data['notas']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE gastos SET concepto=?, categoria=?, monto=?, metodo_pago=?, fecha=?, notas=? WHERE id=?");
        return $stmt->execute([
            $data['concepto'],
            $data['categoria'],
            $data['monto'],
            $data['metodo_pago'],
            $data['fecha'],
            $data['notas'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM gastos WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getTotalMes()
    {
        $stmt = $this->db->prepare("SELECT COALESCE(SUM(monto), 0) as total FROM gastos WHERE MONTH(fecha) = MONTH(CURDATE()) AND YEAR(fecha) = YEAR(CURDATE())");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ)->total;
    }

    public function getGastoMasAltoMes()
    {
        $stmt = $this->db->prepare("
        SELECT concepto, monto FROM gastos 
        WHERE MONTH(fecha) = MONTH(CURDATE()) 
        AND YEAR(fecha) = YEAR(CURDATE())
        ORDER BY monto DESC LIMIT 1
    ");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getCategoriaMasGastoMes()
    {
        $stmt = $this->db->prepare("
        SELECT categoria, SUM(monto) as total FROM gastos 
        WHERE MONTH(fecha) = MONTH(CURDATE()) 
        AND YEAR(fecha) = YEAR(CURDATE())
        GROUP BY categoria
        ORDER BY total DESC LIMIT 1
    ");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
