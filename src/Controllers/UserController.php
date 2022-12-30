<?php
declare(strict_types=1);

namespace Controllers;

class UserController extends AbstractController
{

    private $viewPath = "User/";

    public function register(): void
    {
        if (empty($this->data["username"]) || empty($this->data["email"]) || empty($this->data["password"])) {
            $this->view($this->viewPath . 'register');
            return;
        }
        if ($this->repository->getUserByName($this->data["username"])) {
            $this->view($this->viewPath . 'register', ["response" => "error"]);
            return;
        }
        $username = $this->data["username"];
        $email = $this->data["email"];
        $passwordHash = password_hash($this->data["password"], PASSWORD_DEFAULT);
        $_SESSION["registered"] = true;
        $user = parent::model("User");
        $user->setProperties($username, $email, $passwordHash);
        if (!$this->repository->addUser($user)) {
            $this->view($this->viewPath . 'register', ["response" => "error"]);
            return;
        }
        $this->view($this->viewPath . 'register', ["response" => "successful"]);
    }

    public function login(): void
    {
        if (empty($this->data["username"]) || empty($this->data["password"])) {
            $this->view($this->viewPath . 'login');
            return;
        }
        if (!$this->repository->getUserByName($this->data["username"])) {
            $this->view($this->viewPath . 'login', ["response" => "error"]);
            return;
        }

        $password = $this->data["password"];
        $user = $this->repository->getUserByName($this->data["username"]);
        $passwordHash = $user->getPasswordHash();

        if (!password_verify($password, $passwordHash)) {
            $this->view($this->viewPath . 'login', ["response" => "error"]);
            return;
        }
        $_SESSION["user"] = $user;
        $_SESSION["logged"] = true;
        $this->view($this->viewPath . 'login');
    }
}