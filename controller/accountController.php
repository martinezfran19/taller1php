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
        return $this->account->store($data);
    }

    public function update($id, $data)
    {
        return $this->account->update($id, $data);
    }

    public function delete($id)
    {
        return $this->delete($id);
    }
}
