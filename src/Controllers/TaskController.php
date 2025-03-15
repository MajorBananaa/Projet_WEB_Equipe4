<?php 
namespace App\Controllers;

use App\Models\TaskModel;

class TaskController extends Controller {

    public function __construct($templateEngine) {
        $this->model = new TaskModel();
        $this->templateEngine = $templateEngine;
    }

    public function welcomePage() {
        echo $this->templateEngine->render('index.html.twig');
    }

    public function offerPage() {
        echo $this->templateEngine->render('offer.html.twig');
    }

    public function entreprisePage() {
        echo $this->templateEngine->render('entreprise.html.twig');
    }

    public function studentPage() {
        echo $this->templateEngine->render('student.html.twig');
    }

    public function tuteurPage() {
        echo $this->templateEngine->render('tuteur.html.twig');
    }
}
