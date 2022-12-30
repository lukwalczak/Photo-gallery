<?php

namespace Repository;

use \MongoDB\Driver\Manager as Manager;

class AbstractRepository
{
    protected $mongoManager;
    protected $userCollection;

    public function __construct()
    {
        $this->mongoManager = new Manager("mongodb://waiweb:password@127.0.0.1:27017/?authSource=wai");
        $this->userCollection = "wai.users";
    }
}