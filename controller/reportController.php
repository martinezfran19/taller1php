<?php

require_once 'model/accountDao.php';
require_once 'model/personDao.php';
require_once 'model/conection.php';

class ReportController
{
    private $conection;

    public function __construct()
    {
        $this->conection = Conection::conect();
    }

    public function toJson($name, $data)
    {
        header('Content-type:application/json;charset=utf-8');
        return json_encode([
            $name => $data
        ]);
    }

    function getDate($date)
    {
        try {
            $values = explode('/', $date);
            if (count($values) == 3 && checkdate($values[1], $values[0], $values[2])) {
                return "{$values[2]}-{$values[1]}-{$values[0]}";
            }
            return false;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function report($data)
    {
        $sql = "SELECT * FROM cuenta INNER JOIN persona ON cuenta.idPersona = persona.id WHERE cuenta.fechaRegistro BETWEEN ? AND ?";
        $statement = $this->conection->prepare($sql);

        $initDate = $this->getDate($data['fecha_ini']);
        $endDate = $this->getDate($data['fecha_fin']);
        if ($initDate != false && $endDate != false) {
            $statement->bindParam(1, $initDate);
            $statement->bindParam(2, $endDate);

            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            for ($i = 0; $i < count($result); $i++) {
                $report = array(
                    'identificacion' => $result[$i]['identificacion'],
                    'nombres' => $result[$i]['nombres'],
                    'apellidos' => $result[$i]['apellidos'],
                    'numeroCuenta' => $result[$i]['numeroCuenta'],
                    'tipoCuenta' => $result[$i]['tipoCuenta'],
                    'saldoDisponible' => $result[$i]['saldoDisponible']
                );
                $result[$i] = $report;
            }
            return $this->toJson("Reportes", $result);
        } else {
            return "Las fechas no tienen el formato dd/mm/yyyy";
        }
    }
}
