<?php
declare(strict_types=1);

namespace Controllers;

use Core\Response;

class UserController extends AbstractController
{

    private $viewPath = "User/";

    public function register(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->view($this->viewPath . 'register', new Response(200, []));
            return;
        }
        if (empty($this->data["username"]) || empty($this->data["email"]) || empty($this->data["password"])) {
            $this->view($this->viewPath . 'register', new Response(400, []));
            return;
        }
        if ($this->repository->getUserByName($this->data["username"])) {
            $this->view($this->viewPath . 'register', new Response(400, []));
            return;
        }
        $username = $this->data["username"];
        $email = $this->data["email"];
        $passwordHash = password_hash($this->data["password"], PASSWORD_DEFAULT);
        $_SESSION["registered"] = true;
        $user = parent::model("User");
        $user->setProperties($username, $email, $passwordHash);
        if (!$this->repository->addUser($user)) {
            $this->view($this->viewPath . 'register', new Response(400, []));
            return;
        }
        $this->view($this->viewPath . 'register', new Response(201, []));
    }

    public function login(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->view($this->viewPath . 'login', new Response(200, []));
            return;
        }
        if (empty($this->data["username"]) || empty($this->data["password"])) {
            $this->view($this->viewPath . 'login', new Response(400, []));
            return;
        }
        if (!$this->repository->getUserByName($this->data["username"])) {
            $this->view($this->viewPath . 'login', new Response(400, []));
            return;
        }

        $password = $this->data["password"];
        $user = $this->repository->getUserByName($this->data["username"]);
        $passwordHash = $user->getPasswordHash();

        if (!password_verify($password, $passwordHash)) {
            $this->view($this->viewPath . 'login', new Response(503, []));
            return;
        }
        $_SESSION["user"] = $user;
        $_SESSION["logged"] = true;
        header('Location: ' . '/');
    }

    public function logout(): void
    {
        if (empty($_SESSION["logged"]) || $_SESSION["logged"] == false) {
            header('Location: ' . '/');
            return;
        }
        $_SESSION["logged"] = false;
        $_SESSION["user"] = "";
        header('Location: ' . '/');
        session_destroy();
    }
}