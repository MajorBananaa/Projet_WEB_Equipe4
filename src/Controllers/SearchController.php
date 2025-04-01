<?php 
namespace App\Controllers;
use App\Models\Offer;


class SearchController{
    public function searchOffer() {
        $dbOffer = new Offer();
        $recherche = "";
        if (isset($_GET['search-bar'])) {
            $recherche = $_GET['search-bar'];
        }
        return $dbOffer->getAll($recherche);
    }
}
