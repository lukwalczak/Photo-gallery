<?php
declare(strict_types=1);

namespace Models;
class User
{
    private $username;
    private $email;
    private $passwordHash;

    public function setUsername($username): self
    {
        $this->username = $username;
        return $this;
    }

    public function setEmail($email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    public function setPasswordHash($passwordHash): self
    {
        $this->passwordHash = $passwordHash;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setProperties($username, $email, $passwordHash): void
    {
        $this->username = $username;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }

    public function toArray(): array
    {
        return ["username" => $this->username, "email" => $this->email, "passwordHash" => $this->passwordHash];
    }
}