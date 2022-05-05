<?php
// chargement de Composer
require dirname(__DIR__).'/vendor/autoload.php';
use App\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// spécifier le mode de travail: en production et sans debug
$environment = 'prod';
$debugEnabled = true;
$kernel = new Kernel($environment, $debugEnabled);

// récupérer les données GET, POST, SESSION, COOKIE
$request = Request::createFromGlobals();

// traiter la requète
$response = $kernel->handle($request);

// envoyer la réponse vers le navigateur
$response->send();
$kernel->terminate($request, $response);

?>