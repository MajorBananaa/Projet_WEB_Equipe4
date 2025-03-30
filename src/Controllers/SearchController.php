<?php 
namespace App\Controllers;
use App\Models\Offer;


class SearchController{
    public function searchOffer() {
        $dbOffer = new Offer();
        return $dbOffer->getAll();
    }
}
