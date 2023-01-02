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

    public function downloadAllImages()
    {
        $query = new Mongo\Query([]);
        $dataObject = $this->mongoManager->executeQuery($this->imagesCollection, $query)->toArray();
        if (!boolval($dataObject)) {
            return false;
        }
        $imagesArray = [];
        foreach ($dataObject as $image) {
            array_push($imagesArray, ["title" => $image->title, "filename" => $image->filename, "privacy" => $image->privacy, "author" => $image->author]);
        }
        return $imagesArray;
    }

    public function getImageByFilename(string $filename)
    {
        $query = new Mongo\Query(["filename" => $filename]);
        return $this->queryImage($query);
    }

    private function queryImage($query)
    {
        $dataObject = $this->mongoManager->executeQuery($this->imagesCollection, $query)->toArray();
        if (!boolval($dataObject)) {
            return false;
        }
        $image = new Models\Image();
        $image->setAuthor($dataObject[0]->author)
            ->setExt($dataObject[0]->ext)
            ->setFilename($dataObject[0]->filename)
            ->setTitle($dataObject[0]->title)
            ->setPrivacy($dataObject[0]->privacy);
        return $image->toArray();
    }

}