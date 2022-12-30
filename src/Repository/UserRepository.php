<?php

namespace Repository;

use \MongoDB\Driver as Mongo;
use \Models as Models;

class UserRepository extends AbstractRepository
{
    public function getUserById(string $id): \Models\User
    {
        $query = new Mongo\Query(["_id" => $id]);
        $dataObject = $this->mongoManager->executeQuery($this->userCollection, $query)->toArray()[0];
        $username = $dataObject->username;
        $passwordHash = $dataObject->passwordHash;
        $email = $dataObject->email;
        $user = new Models\User();
        $user->setUsername($username)
            ->setEmail($email)
            ->setPasswordHash($passwordHash);
        return $user;
    }

    public function getUserByName(string $username)
    {
        $query = new Mongo\Query(["username" => $username]);
        $dataObject = $this->mongoManager->executeQuery($this->userCollection, $query)->toArray();
        if (!boolval($dataObject)) {
            return false;
        }
        $username = $dataObject[0]->username;
        $passwordHash = $dataObject[0]->passwordHash;
        $email = $dataObject[0]->email;
        $user = new Models\User();
        $user->setUsername($username)
            ->setEmail($email)
            ->setPasswordHash($passwordHash);
        return $user;
    }

    public function addUser(Models\User $user): bool
    {
        $bulk = new Mongo\BulkWrite();
        $bulk->insert($user->toArray());
        $result = $this->mongoManager->executeBulkWrite($this->userCollection, $bulk);
        if ($result->getInsertedCount() == 0) {
            return false;
        }
        return true;
    }
}