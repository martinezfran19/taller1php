<?php

require_once 'model/accountDao.php';

class AccountController
{
    private $account;


    public function __construct()
    {
        $this->account = new AccountDao();
    }

    public function list()
    {
        return $this->account->getAll();
    }

    public function getAccount($id)
    {
        return $this->account->toJson("Cuenta", $this->account->getBy("id", $id));
    }

    public function store($data)
    {
        if (
            isset($data['tipoCuenta'])
            && isset($data['numeroCuenta'])
            && isset($data['codigoSeguridad'])
            && isset($data['saldoDisponible'])
            && isset($data['email'])
        ) {
            return $this->account->store($data);
        } else {
            return "No se recibieron los campos necesarios";
        }
    }

    public function update($data)
    {
        if (
            isset($data['tipoCuenta'])
            && isset($data['numeroCuenta'])
            && isset($data['codigoSeguridad'])
            && isset($data['saldoDisponible'])
            && isset($data['email'])
            && isset($data['id'])
        ) {
            return $this->account->update($data);
        } else {
            return "No se recibieron los campos necesarios";
        }
    }

    public function delete($data)
    {
        if (isset($data['id'])) {
            return $this->account->delete($data['id']);
        } else {
            return "No se recibió el id";
        }
    }
}
