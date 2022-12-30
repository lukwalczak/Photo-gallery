<?php
declare(strict_types=1);

namespace Models;

class Image
{
    private $name;
    private $author;
    private $privacy;
    private $filename;
    private $ext;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;
        return $this;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function getPrivacy(): bool
    {
        return $this->privacy;
    }

    public function setPrivacy(bool $privacy): self
    {
        $this->privacy = $privacy;
        return $this;
    }

    public function getExt()
    {
        return $this->ext;
    }

    public function setExt($ext): self
    {
        $this->ext = $ext;
        return $this;
    }


    public function toArray(): array
    {
        return ["name" => $this->name, "filename" => $this->filename, "author" => $this->author, "privacy" => $this->privacy, "ext" => $this->ext];
    }

}