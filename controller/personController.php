<?php

require_once 'model/personDao.php';
require_once 'model/AccountDao.php';

class PersonController
{
    public $person;


    public function __construct()
    {
        $this->person = new PersonDao();
    }

    public function list()
    {
        return $this->person->getAll();
    }

    public function getPerson($id)
    {

        return $this->person->toJson("Persona", $this->person->getBy("id", $id));
    }

    public function store($data)
    {
        if (
            isset($data['identificacion'])
            && isset($data['nombres'])
            && isset($data["apellidos"])
        ) {
            return $this->person->store($data);
        } else {
            return "No se recibieron los campos necesarios";
        }
    }

    public function update($data)
    {
        if (
            isset($data['identificacion'])
            && isset($data['nombres'])
            && isset($data["apellidos"])
            && isset($data["id"])
        ) {
            return $this->person->update($data);
        } else {
            return "No se recibieron los campos necesarios";
        }
    }

    public function delete($data)
    {
        if (isset($data['id'])) {
            $account = new AccountDao();
            $existentAccount = $account->getBy('idPersona', $data['id']);
            if($existentAccount!=null){
                $account->deleteByPerson($data['id']);
            }
            return $this->person->delete($data['id']);
        } else {
            echo "No se recibió el id";
        }
    }
}
