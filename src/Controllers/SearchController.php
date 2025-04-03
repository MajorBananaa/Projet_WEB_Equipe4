<?php
namespace App\Controllers;
use App\Models\Candidature;
use App\Models\Contrat;
use App\Models\Localisation;
use App\Models\Offer;
use App\Models\Entreprise;
use App\Models\Secteur;
use App\Models\Etude;
use App\Models\Utilisateur;
use App\Models\Wishlist;

class SearchController
{
    public function paginate($data, $perPage = 10)
    {
        $totalItems = count($data);
        $totalPages = max(1, ceil($totalItems / $perPage));
        $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $currentPage = max(1, min($currentPage, $totalPages));
        $pagedData = array_slice($data, ($currentPage - 1) * $perPage, $perPage);

        return [
            'data' => $pagedData,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages
        ];
    }

    public function addModifFilter()
    {
        $filters = [];
        $entreprise = new Entreprise();
        $filters[] = $entreprise->getAllName();

        $secteur = new Secteur();
        $filters[] = $secteur->getAll();

        $contrat = new Contrat();
        $filters[] = $contrat->getAll();

        $contrat = new Etude();
        $filters[] = $contrat->getAll();

        return $filters;
    }

    public function searchOffer()
    {
        $dbOffer = new Offer();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST["motivation"]) && isset($_FILES["cv"]) && isset($_POST["offer_id"])) {

                $check_file = new UploadService($_FILES["cv"], 10485760, ['application/pdf'], 'fichier/cv/');
                $chemin_cv = $check_file->execute();

                $candidature = new Candidature();
                $candidature->add([$_POST["offer_id"], $_SESSION["user_id"], $chemin_cv, $_POST["motivation"]]);

            } elseif (isset($_POST["id-supr"]) && isset($_POST["remove"])) {
                $dbOffer->remove($_POST["id-supr"]);
            } elseif (isset($_POST["add"])) {
                $offre = [
                    'titre' => $_POST['titre'] ?? 'Titre par défaut',
                    'description' => $_POST['description'] ?? 'Description par défaut',
                    'salaire' => $_POST['salaire'] ?? 0,
                    'teletravail' => $_POST['teletravail'] ?? 0,
                    'duree' => $_POST['duree'] ?? 0,
                    'id_etude' => $_POST['id_etude'] ?? 0,
                    'id_contrat' => $_POST['id_contrat'] ?? 0,
                    'id_secteur' => $_POST['id_secteur'] ?? 0,
                    'id_entreprise' => $_POST['id_entreprise'] ?? 0
                ];

                $dbOffer->add($offre);
            } elseif (isset($_POST["update"])) {

                $offre = [
                    'id_offres' => $_POST['offer_id-upd'],
                    'titre' => $_POST['titre'] ?? 'Titre par défaut',
                    'description' => $_POST['description'] ?? 'Description par défaut',
                    'salaire' => $_POST['salaire'] ?? 0,
                    'teletravail' => $_POST['teletravail'] ?? 0,
                    'duree' => $_POST['duree'] ?? 0,
                    'id_etude' => $_POST['id_etude'] ?? 0,
                    'id_contrat' => $_POST['id_contrat'] ?? 0,
                    'id_secteur' => $_POST['id_secteur'] ?? 0,
                    'id_entreprise' => $_POST['id_entreprise'] ?? 0
                ];
                $dbOffer->update($offre);

            } elseif (isset($_POST['offer_id-suprWish'])) {
                $dbwish = new Wishlist();
                $dbwish->removeWish([$_SESSION["user_id"], $_POST['offer_id-suprWish']]);
            } elseif (isset($_POST['offer_id-addWish'])) {
                $dbwishs = new Wishlist();
                $dbwishs->addWish([$_SESSION["user_id"], $_POST['offer_id-addWish']]);
            }

            $_POST = [];
            $_FILES = [];
        }



        $filters = [
            'search' => $_GET['search-bar'] ?? '',
            'contrats' => $_GET['contrat'] ?? [],
            'salaire' => $_GET['salaire'] ?? null,
            'teletravail' => $_GET['teletravail'] ?? '',
            'duree' => $_GET['duree'] ?? '',
            'niveau_etude' => $_GET['niveau_etude'] ?? ''
        ];

        return $dbOffer->getAll($filters) ?: [];
    }

    public function searchCompany()
    {
        $company = new Entreprise();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST["id-supr"]) && isset($_POST["remove"])) {
                $company = new Entreprise();
                $company->remove($_POST["id-supr"]);
            } elseif (isset($_POST["add"]) || isset($_POST["update"])) {
                $filters_loc = [
                    isset($_POST["pays"]) ? htmlspecialchars($_POST["pays"]) : '',
                    isset($_POST["ville"]) ? htmlspecialchars($_POST["ville"]) : '',
                    isset($_POST["adresse"]) ? htmlspecialchars($_POST["adresse"]) : '',
                    isset($_POST["code_postal"]) ? htmlspecialchars($_POST["code_postal"]) : ''
                ];

                $loc = new Localisation();
                $loc->add($filters_loc);
                $id_localisation = $loc->getLastId();

                $check_file = new UploadService($_FILES["profil_entreprise"], 10485760, ['image/jpeg', 'image/png'], 'fichier/profil-entreprise');
                $chemin_photo_entreprise = $check_file->execute();

                $filters_company = [
                    isset($_POST["nom"]) ? htmlspecialchars($_POST["nom"]) : '',
                    isset($_POST["description"]) ? htmlspecialchars($_POST["description"]) : '',
                    isset($_POST["mail"]) ? htmlspecialchars($_POST["mail"]) : '',
                    $chemin_photo_entreprise,
                    $id_localisation->id_localisation,
                    isset($_POST["id_secteur"]) ? htmlspecialchars($_POST["id_secteur"]) : ''
                ];

                $company = new Entreprise();

                if (isset($_POST["add"])) {
                    $company->add($filters_company);
                } elseif (isset($_POST["update"])) {
                    $filters_company[] = isset($_POST["offer_id-upd"]) ? htmlspecialchars($_POST["offer_id-upd"]) : '';
                    $company->update($filters_company);
                }
            }

            $_POST = [];
            $_FILES = [];
        }


        $filters = [
            'search' => $_GET['search-bar'] ?? '',
            'secteur' => $_GET['secteur'] ?? "",
        ];

        return $company->getAll($filters) ?: [];
    }

    public function searchUser($id_role)
    {
        $user = new Utilisateur();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST["id-supr"]) && isset($_POST["remove"])) {
                $user->remove($_POST["id-supr"]);
            } elseif (isset($_POST["add"]) || isset($_POST["update"])) {
                $filters_loc = [
                    isset($_POST["pays"]) ? htmlspecialchars($_POST["pays"]) : '',
                    isset($_POST["ville"]) ? htmlspecialchars($_POST["ville"]) : '',
                    isset($_POST["adresse"]) ? htmlspecialchars($_POST["adresse"]) : '',
                    isset($_POST["code_postal"]) ? htmlspecialchars($_POST["code_postal"]) : ''
                ];

                $loc = new Localisation();
                $loc->add($filters_loc);
                $id_localisation = $loc->getLastId();

                $check_file = new UploadService($_FILES["chemin_profil_picture"], 10485760, ['image/jpeg', 'image/png'], 'fichier/profil-student');
                $chemin_photo = $check_file->execute();

                $filters_user = [
                    isset($_POST["nom"]) ? htmlspecialchars($_POST["nom"]) : '',
                    isset($_POST["prenom"]) ? htmlspecialchars($_POST["prenom"]) : '',
                    isset($_POST["description"]) ? htmlspecialchars($_POST["description"]) : '',
                    isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : '',
                    isset($_POST["telephone"]) ? htmlspecialchars($_POST["telephone"]) : '',
                    isset($_POST["mots_de_passe"]) ? htmlspecialchars($_POST["mots_de_passe"]) : '',
                    $chemin_photo,
                    $id_localisation->id_localisation,
                    $id_role
                ];

                $user = new Utilisateur();

                if (isset($_POST["add"])) {
                    $user->add($filters_user);
                } elseif (isset($_POST["update"])) {
                    $filters_user[] = isset($_POST["offer_id-upd"]) ? htmlspecialchars($_POST["offer_id-upd"]) : '';
                    $user->update($filters_user);
                }
            }

            $_POST = [];
            $_FILES = [];
        }

        $filters = [
            'id_role' => $id_role,
            'search' => $_GET['search-bar'] ?? '',
        ];

        return $user->getAll($filters) ?: [];
    }
}
