<?php

namespace Repository;

use \MongoDB\Driver as Mongo;
use \Models as Models;

class UserRepository extends AbstractRepository
{
    public function getUserById($id)
    {
        $query = new Mongo\Query(["_id" => $id]);
        $dataObject = $this->mongoManager->executeQuery($this->userCollection, $query)->toArray()[0];
        $username = $dataObject->username;
        $passwordHash = $dataObject->passwordHash;
        $email = $dataObject->email;
        $user = new Models\User();
        return $user;
    }

    public function getUserByName($id)
    {
        $query = new Mongo\Query(["_id" => $id]);
        $dataObject = $this->mongoManager->executeQuery($this->userCollection, $query)->toArray()[0];
        return $dataObject;
    }

    public function addUser($id)
    {
        $query = new Mongo\Query(["id" => $id]);
        $dataObject = $this->mongoManager->executeQuery($this->userCollection, $query)->toArray()[0];
        return $dataObject;
    }
}