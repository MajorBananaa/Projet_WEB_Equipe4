<?php 
namespace App\Controllers;
use App\Models\Permission;
use App\Models\Utilisateur;


class ControllerAuthentification {

    public function login() {
        $user = new Utilisateur();

        if (isset($_POST["mail"]) && isset($_POST["password"])) {
            $mail = "'" . $_POST["mail"] . "'";
            $password = $_POST["password"];
        } else {
            echo "<script>alert('Veuillez remplir tous les champs.');</script>";
        }

        $result = $user->get("SELECT id_utilisateur, mots_de_passe ", "WHERE email = " . $mail);
        echo "<script>alert('Request method: " . $result->mots_de_passe . "');</script>";
        if ($result->mots_de_passe == $password) {
            $_SESSION['user_id'] = $result->id_utilisateur;
            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
    }

    public function getRight($user_id) {}
}