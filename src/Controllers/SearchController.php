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
use App\Models\Evaluation;


class SearchController
{
    /**
     * Effectue la pagination d'un jeu de données.
     *
     * Cette méthode :
     * - Calcule le nombre total d'éléments dans le tableau `$data`.
     * - Calcule le nombre total de pages en fonction du nombre d'éléments et du nombre d'éléments par page (`$perPage`).
     * - Détermine la page courante en fonction du paramètre `page` dans l'URL (par défaut, page 1).
     * - Limite la page courante au nombre de pages disponibles.
     * - Sélectionne les données correspondant à la page courante.
     * - Retourne un tableau associatif contenant les données paginées, la page courante et le nombre total de pages.
     *
     * @param array $data Les données à paginer.
     * @param int $perPage Le nombre d'éléments par page (par défaut 10).
     * 
     * @return array Un tableau associatif contenant :
     *               - 'data' : les données paginées pour la page courante,
     *               - 'currentPage' : la page courante,
     *               - 'totalPages' : le nombre total de pages.
     */
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


    /**
     * Ajoute les filtres de recherche pour les entreprises, secteurs, contrats et études.
     *
     * Cette méthode :
     * - Crée une instance de la classe `Entreprise` et récupère tous les noms d'entreprises pour filtrer les recherches.
     * - Crée une instance de la classe `Secteur` et récupère tous les secteurs pour filtrer les recherches.
     * - Crée une instance de la classe `Contrat` et récupère tous les types de contrats pour filtrer les recherches.
     * - Crée une instance de la classe `Etude` et récupère tous les niveaux d'étude pour filtrer les recherches.
     * - Retourne un tableau contenant les résultats de chaque filtre.
     *
     * @return array Un tableau contenant les résultats des filtres :
     *               - [0] : la liste des entreprises,
     *               - [1] : la liste des secteurs,
     *               - [2] : la liste des types de contrats,
     *               - [3] : la liste des niveaux d'étude.
     */
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


    /**
     * Effectue la recherche d'offres en fonction des filtres définis et gère les actions liées aux candidatures, suppression et ajout d'offres.
     *
     * Cette méthode :
     * - Gère la soumission des candidatures avec un fichier CV et une lettre de motivation (avec vérification du fichier).
     * - Permet de supprimer une offre existante.
     * - Permet l'ajout d'une nouvelle offre.
     * - Permet de mettre à jour une offre existante.
     * - Permet d'ajouter ou de supprimer une offre de la liste de souhaits de l'utilisateur.
     * 
     * Les données sont envoyées via une requête POST, et la méthode gère les actions en fonction des paramètres reçus.
     *
     * Elle applique également des filtres (recherche par mots-clés, type de contrat, salaire, télétravail, durée, niveau d'étude) 
     * lors de la récupération des offres via la méthode `getAll`.
     *
     * @return array|bool|object Retourne soit un tableau d'offres correspondant aux critères de recherche, 
     *                            soit un booléen `false` si aucune offre n'est trouvée, 
     *                            soit un objet en cas d'erreur ou de résultats spéciaux.
     */
    public function searchOffer()
    {
        $dbOffer = new Offer();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST["motivation"]) && isset($_FILES["cv"]) && isset($_POST["offer_id"])) {
        
                $check_file = new UploadService($_FILES["cv"], 10485760, ['application/pdf'], 'fichier/cv/');
                $chemin_cv = $check_file->execute();
        
                $candidature = new Candidature();
                $candidature->add([
                    htmlspecialchars($_POST["offer_id"]), 
                    $_SESSION["user_id"], 
                    $chemin_cv, 
                    htmlspecialchars($_POST["motivation"])
                ]);
            
            } elseif (isset($_POST["id-supr"]) && isset($_POST["remove"])) {
                $dbOffer->remove(htmlspecialchars($_POST["id-supr"]));
            
            } elseif (isset($_POST["add"])) {
                $offre = [
                    'titre' => htmlspecialchars($_POST['titre'] ?? 'Titre par défaut'),
                    'description' => htmlspecialchars($_POST['description'] ?? 'Description par défaut'),
                    'salaire' => htmlspecialchars($_POST['salaire'] ?? 0),
                    'teletravail' => htmlspecialchars($_POST['teletravail'] ?? 0),
                    'duree' => htmlspecialchars($_POST['duree'] ?? 0),
                    'id_etude' => htmlspecialchars($_POST['id_etude'] ?? 0),
                    'id_contrat' => htmlspecialchars($_POST['id_contrat'] ?? 0),
                    'id_secteur' => htmlspecialchars($_POST['id_secteur'] ?? 0),
                    'id_entreprise' => htmlspecialchars($_POST['id_entreprise'] ?? 0)
                ];
                $dbOffer->add($offre);
            
            } elseif (isset($_POST["update"])) {
                $offre = [
                    'id_offres' => htmlspecialchars($_POST['offer_id-upd']),
                    'titre' => htmlspecialchars($_POST['titre'] ?? 'Titre par défaut'),
                    'description' => htmlspecialchars($_POST['description'] ?? 'Description par défaut'),
                    'salaire' => htmlspecialchars($_POST['salaire'] ?? 0),
                    'teletravail' => htmlspecialchars($_POST['teletravail'] ?? 0),
                    'duree' => htmlspecialchars($_POST['duree'] ?? 0),
                    'id_etude' => htmlspecialchars($_POST['id_etude'] ?? 0),
                    'id_contrat' => htmlspecialchars($_POST['id_contrat'] ?? 0),
                    'id_secteur' => htmlspecialchars($_POST['id_secteur'] ?? 0),
                    'id_entreprise' => htmlspecialchars($_POST['id_entreprise'] ?? 0)
                ];
                $dbOffer->update($offre);
            
            } elseif (isset($_POST['offer_id-suprWish'])) {
                $dbwish = new Wishlist();
                $dbwish->removeWish([$_SESSION["user_id"], htmlspecialchars($_POST['offer_id-suprWish'])]);
            
            } elseif (isset($_POST['offer_id-addWish'])) {
                $dbwishs = new Wishlist();
                $dbwishs->addWish([$_SESSION["user_id"], htmlspecialchars($_POST['offer_id-addWish'])]);
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


    /**
     * Gère les actions liées aux entreprises : ajout, modification, suppression d'entreprise, évaluation d'offres, etc.
     *
     * Cette méthode :
     * - Permet de supprimer une entreprise si une requête POST contient les données nécessaires.
     * - Permet de supprimer une évaluation d'offre si l'utilisateur en fait la demande.
     * - Permet d'ajouter ou de mettre à jour des évaluations d'offres.
     * - Permet l'ajout ou la mise à jour d'une entreprise (avec ajout de localisation et photo de profil).
     *
     * Elle traite les données envoyées via POST, notamment :
     * - Les informations sur l'entreprise (nom, description, secteur, etc.).
     * - La gestion des fichiers (photo de profil de l'entreprise).
     * - La gestion des évaluations d'offres liées à l'entreprise.
     *
     * Après traitement des données, la méthode applique des filtres de recherche (par secteur et mot-clé) et retourne les entreprises correspondantes.
     *
     * @return array|bool|object Retourne un tableau d'entreprises correspondant aux critères de recherche, 
     *                            un booléen `false` si aucune entreprise n'est trouvée, 
     *                            ou un objet si une erreur se produit ou dans un cas spécifique.
     */
    public function searchCompany()
    {
        $company = new Entreprise();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST["id-supr"]) && isset($_POST["remove"])) {
                $company = new Entreprise();
                $company->remove($_POST["id-supr"]);
            } elseif (isset($_POST['offer_id-suprEval'])) {
                $dbeval = new Evaluation();
                $dbeval->removeEval([$_SESSION["user_id"], $_POST['offer_id-suprEval']]);
            } elseif (isset($_POST['offer_id-addEval'])) {
                $dbevals = new Evaluation();
                $dbevals->add([$_POST['offer_note-addEval'], $_SESSION["user_id"], $_POST['offer_id-addEval']]);
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


    /**
     * Gère les actions liées aux utilisateurs en fonction de leur rôle : ajout, modification, suppression, etc.
     *
     * Cette méthode :
     * - Permet de supprimer un utilisateur si une requête POST contient les données nécessaires.
     * - Permet d'ajouter ou de mettre à jour un utilisateur (avec ajout de localisation et photo de profil).
     * - Prend en compte le rôle de l'utilisateur (par exemple, étudiant, entreprise).
     *
     * Elle traite les données envoyées via POST, notamment :
     * - Les informations sur l'utilisateur (nom, prénom, email, téléphone, mot de passe, etc.).
     * - La gestion des fichiers (photo de profil).
     * - La gestion de la localisation de l'utilisateur (pays, ville, adresse, code postal).
     *
     * Après traitement des données, la méthode applique un filtre de recherche basé sur l'ID de rôle et un mot-clé de recherche (s'il existe), puis retourne les utilisateurs correspondants.
     *
     * @param string $id_role Le rôle de l'utilisateur pour filtrer les résultats (par exemple, 'student', 'company').
     * 
     * @return array|bool|object Retourne un tableau d'utilisateurs correspondant aux critères de recherche,
     *                            un booléen `false` si aucun utilisateur n'est trouvé,
     *                            ou un objet si une erreur se produit ou dans un cas spécifique.
     */
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
                    isset($_POST["mots_de_passe"]) ? password_hash(htmlspecialchars($_POST["mots_de_passe"]), PASSWORD_DEFAULT) : '',
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
