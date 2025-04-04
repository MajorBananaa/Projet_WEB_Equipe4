<?php
namespace App\Controllers;
use App\Models\Candidature;
use App\Models\Evaluation;
use App\Models\Statistique;
use App\Models\Wishlist;

class DashboardController
{
    /**
     * Récupère les statistiques liées à l'utilisateur pour le tableau de bord.
     *
     * Cette méthode :
     * - Crée une instance de la classe `Statistique` pour accéder aux données statistiques.
     * - Utilise l'ID et le rôle de l'utilisateur dans la session pour récupérer les statistiques pertinentes.
     * - Retourne les données statistiques obtenues pour affichage dans le tableau de bord.
     *
     * @return array Les statistiques de l'utilisateur, fournies par la méthode `getAll` de la classe `Statistique`.
     */
    public function searchDashboard()
    {
        $dbstat = new Statistique();
        return $dbstat->getAll($_SESSION["user_id"], $_SESSION["user_role"]);
    }
    /**
     * Récupère les statistiques des candidats récents pour le tableau de bord.
     *
     * Cette méthode :
     * - Crée une instance de la classe `Statistique` pour accéder aux données statistiques.
     * - Utilise l'ID et le rôle de l'utilisateur dans la session pour récupérer les statistiques des candidats récents.
     * - Retourne un tableau contenant les statistiques des candidats récents, ou `false` si la récupération échoue.
     *
     * @return array|bool|object Un tableau contenant les statistiques des candidats récents, 
     *                            ou `false` en cas d'erreur, ou un objet si nécessaire selon la méthode `getAllRecentes` de la classe `Statistique`.
     */
    public function searchDashboardCandRecentes()
    {
        $dbstat = new Statistique();
        return $dbstat->getAllRecentes($_SESSION["user_id"], $_SESSION["user_role"]);
    }

    /**
     * Récupère les statistiques des évaluations des candidats pour le tableau de bord.
     *
     * Cette méthode :
     * - Crée une instance de la classe `Statistique` pour accéder aux données statistiques.
     * - Utilise l'ID et le rôle de l'utilisateur dans la session pour récupérer les statistiques des évaluations des candidats.
     * - Retourne un tableau contenant les statistiques des évaluations, ou `false` si la récupération échoue.
     *
     * @return array|bool|object Un tableau contenant les statistiques des évaluations des candidats, 
     *                            ou `false` en cas d'erreur, ou un objet si nécessaire selon la méthode `getAllEvals` de la classe `Statistique`.
     */
    public function searchDashboardEval()
    {
        $dbstat = new Statistique();
        return $dbstat->getAllEvals($_SESSION["user_id"], $_SESSION["user_role"]);
    }

    /**
     * Récupère les statistiques des candidatures envoyées pour le tableau de bord.
     *
     * Cette méthode :
     * - Crée une instance de la classe `Candidature` pour accéder aux données des candidatures envoyées.
     * - Utilise l'ID et le rôle de l'utilisateur dans la session pour récupérer les candidatures envoyées.
     * - Retourne un tableau contenant les candidatures envoyées, ou `false` si la récupération échoue.
     *
     * @return array|bool|object Un tableau contenant les candidatures envoyées, 
     *                            ou `false` en cas d'erreur, ou un objet si nécessaire selon la méthode `get` de la classe `Candidature`.
     */
    public function searchDashboardCandSend()
    {
        $dbstat = new Candidature();
        return $dbstat->get($_SESSION["user_id"], $_SESSION["user_role"]);
    }

    /**
     * Récupère les éléments de la wishlist de l'utilisateur pour le tableau de bord.
     *
     * Cette méthode :
     * - Crée une instance de la classe `Wishlist` pour accéder aux données de la wishlist.
     * - Utilise l'ID et le rôle de l'utilisateur dans la session pour récupérer les éléments de la wishlist.
     * - Retourne un tableau contenant les éléments de la wishlist, ou `false` si la récupération échoue.
     *
     * @return array|bool|object Un tableau contenant les éléments de la wishlist, 
     *                            ou `false` en cas d'erreur, ou un objet si nécessaire selon la méthode `get` de la classe `Wishlist`.
     */
    public function searchDashboardWishList()
    {
        $dbstat = new Wishlist();
        return $dbstat->get($_SESSION["user_id"], $_SESSION["user_role"]);
    }

}