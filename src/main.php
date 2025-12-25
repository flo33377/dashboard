<?php

    // debogger

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

    // dependancies
include('envir/password.php');
$projects = include('envir/projects.php');
include('mainFunctions.php');

    // Session
session_set_cookie_params(86400); // durée du cookie de session = 24h
session_start();
/* unset($_SESSION['access_granted']); */


    // Constantes

// base_url = lien vers la HP basé sur le serveur utilisé 
define("BASE_URL", ($_SERVER["SERVER_PORT"] === "5000") ? "http://localhost:5000/" : "https://fneto-prod.fr/dashboard/");

// overview = HP quand connecté
define("OVERVIEW", __DIR__ . "/content/overview.php");

// focus_project = contenu se concentrant sur un projet
define("FOCUS_PROJECT", __DIR__ . "/content/focus-project.php");



    // Variables de pages
$method = $_SERVER['REQUEST_METHOD'];
    // setting des param par défaut
$page = "overview"; // chemin du routeur par défaut => cas HP
$content = OVERVIEW; // const du contenu de la page par défaut
$selectedProject = null; // par défaut, aucun project sélectionné 
$projectStats = null; // par défaut, aucune donnée pour le projet sélectionné


    // Routeur

// set par défaut qu'il n'est pas connecté
$access_granted = false;

// 1ere étape => si reconnu comme admin, set la variable admin côté serveur
if(isset($_SESSION['access_granted']) && ($_SESSION['access_granted'] == true)) {
    $access_granted = true;
}

// 2e étape, s'il est connecté, check s'il a fait une requête
if($access_granted) {
    switch ($method) {
        case "POST":
            if (!empty($_POST)) {
                //if(isset($_POST['post_authenticate'])) $page = "check_authenticate"; // input caché post_authenticate
            }
            break;

        case "GET":
            if(isset($_GET['project']) && ($_GET['project'] != null)) {
                $page = "focusProject" ;
                $selectedProject = $_GET['project'];
            }
            break;
    }
}


    // Roads
switch($page){
    case "overview" : // cas par défaut => HP du site
        $content = OVERVIEW;
        break;
    case "focusProject" : // affiche les données d'un projet en particulier
        if(isset($projects[$selectedProject])) {
            $content = FOCUS_PROJECT;
            $focusedProject = $projects[$selectedProject];
            $datas = getAllDatas($focusedProject['dbUrl'], $focusedProject['dbTableName']);
        } else {
            $content = OVERVIEW;
            $errorMessage = "unknown_project";
        }
        break;
}



?>