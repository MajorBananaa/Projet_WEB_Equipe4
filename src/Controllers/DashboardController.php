<?php 
namespace App\Controllers;
use App\Models\Candidature;
use App\Models\Evaluation;
use App\Models\Statistique;
use App\Models\Wishlist;

class DashboardController{
    public function searchDashboard() {
        $dbstat = new Statistique();
        return $dbstat->getAll($_SESSION["user_id"]);
    }
    public function searchDashboardCandRecentes() {
        $dbstat = new Statistique();
        return $dbstat->getAllRecentes($_SESSION["user_id"]);
    }
    public function searchDashboardEval() {
        $dbstat = new Statistique();
        return $dbstat->getAllEvals($_SESSION["user_id"]);
    }
    public function searchDashboardCandSend() {
        $dbstat = new Candidature();
        return $dbstat->get($_SESSION["user_id"]);
    }
    public function searchDashboardWishList () {
        $dbstat = new Wishlist();
        return $dbstat->get($_SESSION["user_id"]);
    }
}