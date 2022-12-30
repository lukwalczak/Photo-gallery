<?php
declare(strict_types=1);

namespace Models;
class User
{
    private $username;
    private $email;
    private $passwordHash;

    public function __construct($username, $email, $passwordHash)
    {
        $this->username = $username;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }

    public function setUsername($username): void
    {
        $this->username = $username;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    public function setPasswordHash($passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setProperties($passwordHash, $username, $email): void
    {
        $this->username = $username;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }

    public function toArray()
    {
        return ["username" => $this->username, "email" => $this->email, "passwordHash" => $this->passwordHash];
    }
}