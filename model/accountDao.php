<?php

require_once 'model/conection.php';
require_once 'model/personDao.php';

class AccountDao
{
    private  $table = "cuenta";
    private $conection;
    public $person;

    public function __construct()
    {
        $this->conection = Conection::conect();
        $this->person = new PersonDao();
    }

    private function validateData($data)
    {
        $numeroCuenta = $data['numeroCuenta'];
        $codigoSeguridad = $data['codigoSeguridad'];
        $saldoDisponible = $data['saldoDisponible'];

        $numeros = "0123456789";
        $saldo = "0123456789.,";

        if ($codigoSeguridad < 0) {
            return "El codigo de seguridad no puede ser negativo";
        }

        for ($i = 0; $i < strlen($numeroCuenta); $i++) {
            if (strpos($numeros, substr($numeroCuenta, $i, 1)) === false) {
                return "El campo numero de cuenta debe ser de tipo numérico y sin puntos ni comas";
            }
        }
        for ($i = 0; $i < strlen($codigoSeguridad); $i++) {
            if (strpos($numeros, substr($codigoSeguridad, $i, 1)) === false) {
                return "el campo codigo de seguridad debe ser de tipo numérico y sin puntos ni comas";
            }
        }
        for ($i = 0; $i < strlen($saldoDisponible); $i++) {
            if (strpos($saldo, substr($saldoDisponible, $i, 1)) === false) {
                return "el campo saldo disponible contiene caracteres invalidos";
            }
        }

        return "ok";
    }

    public function toJson($name, $data)
    {
        header('Content-type:application/json;charset=utf-8');
        return json_encode([
            $name => $data
        ]);
    }

    public function getAccount($id)
    {
        return $this->getBy("id", $id);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM cuenta";
        $statement = $this->conection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->conection = null;
        for ($i = 0; $i < count($result); $i++) {
            $idPersona = $result[$i]['idPersona'];
            $result[$i]['data_fk'] = $this->person->getBy("id", $idPersona);
        }

        return $this->toJson("Cuenta", $result);
    }


    public function getBy($colum, $value)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$colum} = {$value}";
        $statement = $this->conection->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $idPersona = $result[0]['idPersona'];
        $result[0]['Titular'] = $this->person->getBy("id", $idPersona);

        if ($result == false) {
            return null;
        }

        return $result;
    }


    public function store($data)
    {
        $validateMessage = $this->validateData($data);
        if (hash_equals($validateMessage, "ok")) {
            $persona = $this->person->getBy("id", $data['idPersona']);
            if ($persona != null) {
                $statement = $this->conection->prepare("INSERT INTO cuenta (idPersona, tipoCuenta, numeroCuenta, codigoSeguridad, saldoDisponible, email) VALUES (?,?,?,?,?,?)");

                $statement->bindParam(1, $data['idPersona']);
                $statement->bindParam(2, $data['tipoCuenta']);
                $statement->bindParam(3, $data['numeroCuenta']);
                $statement->bindParam(4, $data['codigoSeguridad']);
                $statement->bindParam(5, $data['saldoDisponible']);
                $statement->bindParam(6, $data['email']);
                $statement->execute();

                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                $data["Titular"] = $persona;
                return $this->toJson("Datos ingresados", $data);
            }
            return $this->toJson("Error", "No existe una persona registrada con el id indicado");
        }
        return $this->toJson("Error", $validateMessage);
    }

    public function update($id, $data)
    {
        $validateMessage = $this->validateData($data);
        if (hash_equals($validateMessage, "ok")) {
            $statement = $this->conection->prepare("UPDATE cuenta SET tipoCuenta = ?, numeroCuenta = ?, codigoSeguridad = ?, saldoDisponible = ?, email = ? WHERE id = ?");

            $statement->bindParam(1, $data['tipoCuenta']);
            $statement->bindParam(2, $data['numeroCuenta']);
            $statement->bindParam(3, $data['codigoSeguridad']);
            $statement->bindParam(4, $data['saldoDisponible']);
            $statement->bindParam(5, $data['email']);
            $statement->bindParam(6, $id);

            $statement->execute();

            $result = $this->getAccount($id);
            $persona = $this->person->getBy("id", $result[0]['idPersona']);
            $result[0]["Titular"] = $persona[0];
            return $this->toJson("Registro actualizado", $result);
        }
        return $this->toJson("Error", $validateMessage);
    }

    public function delete($id)
    {
        $result = $this->getBy("id", $id);
        $persona = $this->person->getBy("id", $result[0]['idPersona']);
        $result[0]["Titular"] = $persona[0];

        $statement = $this->conection->prepare("DELETE FROM cuenta WHERE id = ?");
        $statement->bindParam(1, $id);

        $statement->execute();
        return $this->toJson("Registro eliminado", $result);
    }
}
