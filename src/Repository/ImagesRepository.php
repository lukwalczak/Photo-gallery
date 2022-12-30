<?php

namespace Repository;

use \MongoDB\Driver as Mongo;
use \Models as Models;

class ImagesRepository extends AbstractRepository
{
    public function uploadImage(Models\Image $image): bool
    {
        $bulk = new Mongo\BulkWrite();
        $bulk->insert($image->toArray());
        $result = $this->mongoManager->executeBulkWrite($this->imagesCollection, $bulk);
        if ($result->getInsertedCount() == 0) {
            return false;
        }
        return true;
    }
}