<?php
namespace App\Controllers;
use App\Models\Permission;
use App\Models\Utilisateur;


class ControllerAuthentification
{

    public function login()
    {
        $user = new Utilisateur();

        if (isset($_POST["mail"]) && isset($_POST["password"])) {
            $mail = $_POST["mail"];
            $password = $_POST["password"];
        } else {
            return false;
        }

        $result = $user->get(["id_utilisateur", "mots_de_passe, id_role"], "email", $mail);

        if ($result == false) {
            return false;
        } else {
            if ($result->mots_de_passe == $password) {
                $_SESSION['user_id'] = $result->id_utilisateur;
                $_SESSION['user_role'] = $result->id_role;
                return true;
            } else {
                return false;
            }
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
    }

    public function isLog()
    {
        if (!isset($_SESSION['user_id']) && $_SERVER['REQUEST_URI'] !== '/login') {
            header("Location: /login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                if ($this->login()) {
                    header("Location: /");
                    exit();
                } else {
                    header("Location: /login");
                    exit();
                }
            } elseif (isset($_POST['action']) && $_POST['action'] === "logout") {
                $this->logout();
                header("Location: /login");
                exit();
            }
        }
    }

    public function getRight()
    {
        $perm = new Permission();

        $userRights = $perm->getAll($_SESSION['user_role']);
        $allRights = $perm->getAllrole();

        $rightsDictionary = [];

        foreach ($allRights as $right) {
            $rightsDictionary[$right->id_permission] = false;
            foreach ($userRights as $userRight) {
                if ($userRight->id_permission == $right->id_permission) {
                    $rightsDictionary[$right->id_permission] = true;
                }
            }
        }    
        print_r($rightsDictionary);
    }
}