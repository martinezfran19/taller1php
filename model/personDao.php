<?php

require_once 'model/conection.php';

class PersonDao
{
    private $table = "persona";
    private $conection;

    public function __construct()
    {
        $this->conection = Conection::conect();
    }

    private function validateData($data)
    {
        $identificacion = $data['identificacion'];
        $nombres = $data['nombres'];
        $apellidos = $data['apellidos'];

        $numeros = "0123456789";
        $letras = "abcdefghijklmnopqrstuvwxyzñABCDEFGHIJKLMNOPQRSTUVWXYZÑ ";

        if ($identificacion < 0) {
            return "El numero de indentificacion no puede ser negativo";
        }

        for ($i = 0; $i < strlen($identificacion); $i++) {
            if (strpos($numeros, substr($identificacion, $i, 1)) === false) {
                return "El campo identificacion debe ser de tipo numérico y sin puntos ni comas";
            }
        }
        for ($i = 0; $i < strlen($nombres); $i++) {
            if (strpos($letras, substr($nombres, $i, 1)) === false) {
                return "el campo nombres contiene caracteres invalidos";
            }
        }
        for ($i = 0; $i < strlen($apellidos); $i++) {
            if (strpos($letras, substr($apellidos, $i, 1)) === false) {
                return "el campo apellidos contiene caracteres invalidos";
            }
        }
        if ($this->getBy("identificacion", $identificacion) != null) {
            return "Ya existe una persona registrada con el número de identificación ingresado";
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

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        $statement = $this->conection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->conection = null;
        return $this->toJson("Personas", $result);
    }

    public function getBy($colum, $value)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$colum} = {$value}";
        $statement = $this->conection->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ($result == false) {
            return null;
        }

        return $result;
    }

    public function store($data)
    {
        $validateMessage = $this->validateData($data);
        if (hash_equals($validateMessage, "ok")) {

            $sql = "INSERT INTO {$this->table} (identificacion, nombres, apellidos) VALUES (?,?,?)";
            $statement = $this->conection->prepare($sql);

            $statement->bindParam(1, $data['identificacion']);
            $statement->bindParam(2, $data['nombres']);
            $statement->bindParam(3, $data['apellidos']);
            $statement->execute();
            return $this->toJson("Datos ingresados", $this->toJson("Persona", $data));
        }
        return $this->toJson("Error", $validateMessage);
    }

    public function update($id, $data)
    {
        $validateMessage = $this->validateData($data);
        if (hash_equals($validateMessage, "ok")) {
            $sql = "UPDATE {$this->table} SET identificacion = ?, nombres = ?, apellidos = ? WHERE id = ?";
            $statement = $this->conection->prepare($sql);

            $statement->bindParam(1, $data['identificacion']);
            $statement->bindParam(2, $data['nombres']);
            $statement->bindParam(3, $data['apellidos']);
            $statement->bindParam(4, $id);

            $statement->execute();

            return $this->toJson("Registro actualizado", $this->toJson("Persona", $data));
        }
        return $this->toJson("Error", $validateMessage);
    }

    public function delete($id)
    {
        $result = $this->getBy("id", $id);
        if ($result != null) {
            $sql = "DELETE FROM {$this->table} WHERE id = ?";

            $statement = $this->conection->prepare($sql);
            $statement->bindParam(1, $id);

            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $this->toJson("Registro eliminado", $result);
        }
        return $this->toJson("Error", "El ID de persona ingresado no existe en la base de datos");
    }
}
