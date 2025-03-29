<?php 
namespace App\Controllers;
use App\Models\Permission;
use App\Models\Utilisateur;


class ControllerAuthentification {

    public function login() {
        session_start();
        $user = new Utilisateur();

        $mail = "'pauline.albert@viacesi.fr'";
        $password = "8C1ymmOS";

        $result = $user->get("SELECT id_utilisateur, mots_de_passe ", "WHERE email = " . $mail);

        if ($result->mots_de_passe == $password) {
            $_SESSION['user_id'] = $result->id_utilisateur;
            echo "Connecté";
        } else {
            echo "Pas Connecté";
        }
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
    }

    public function getRight($user_id) {}
}