<?php
namespace App\Controllers;

use App\Models\Permission;
use App\Models\Utilisateur;

class ControllerAuthentification{
    /**
     * Vérifie les informations d'identification de l'utilisateur et crée une session.
     *
     * @return bool Retourne true si l'utilisateur est authentifié, sinon false.
     */
    public function login(){
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
            if ($password == $result->mots_de_passe) /*password_verify($password, $result->mots_de_passe)*/{
                $_SESSION['user_id'] = $result->id_utilisateur;
                $_SESSION['user_role'] = $result->id_role;
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Déconnecte l'utilisateur en détruisant la session.
     *
     * @return void
     */
    public function logout(){
        session_unset();
        session_destroy();
    }

    /**
     * Récupère les permissions de l'utilisateur connecté.
     *
     * @return array Retourne un tableau associatif des droits de l'utilisateur.
     */
    public function getRight(){
        $perm = new Permission();

        $userRights = $perm->getAll($_SESSION['user_role']);
        $allRights = $perm->getAllrole();

        $userPermissions = [];
        foreach ($userRights as $right) {
            $userPermissions[$right->id_permission] = true;
        }

        $rightsDictionary = [];
        foreach ($allRights as $right) {
            $rightsDictionary[$right->nom] = isset($userPermissions[$right->id_permission]);
        }

        return $rightsDictionary;
    }
}
