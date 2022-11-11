<?php

require_once 'model/personDao.php';

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

    public function getPerson($id){
        
        return $this->person->toJson("Persona", $this->person->getBy("id", $id));
    }

    public function store($data)
    {
        return $this->person->store($data);
    }

    public function update($id, $data)
    {
        return $this->person->update($id, $data);
    }

    public function delete($id){
        return $this->person->delete($id);
    }
}



