<?php
/*
 *
 * TP : Routing
 *
 * Faire en sorte que toutes les requêtes HTTP pointent sur le fichier index.php se trouvant dans public
 * Se baser ensuite sur le fichier routes.yml pour appeler la bonne classe dans le dossier controller et
 * la bonne methode (ce que l'on appel une action dans un controller)
 *
 * Exemple :
 * http://localhost:8080/contact
 * Doit créer une instance de Base et appeler la méthode (action) : contact
 * $controller = new Base();
 * $controller->contact();
 *
 * Pensez à effectuer tous les nettoyages et toutes les vérifications pour
 * afficher des erreurs (des simples die suffiront dans un premier temps)
 *
 * Rendu : Mail y.skrzypczyk@gmail.com
 * Objet du mail : 3IW1 - TP routing - Nom Prénom
 * Contenu du mail : fichier index.php et les autres fichiers créés s'il y en a
 *
 * Bon courage
 */

// Récupère l'URL demandée

$path = trim($_SERVER['REQUEST_URI'], '/');

if ($path === "") {
    $controllerName = "Base";
    $method = "index";
} else {
    $parts = explode('/', $path);

    $controllerName = ucfirst($parts[0]); 
    $method = $parts[1] ?? "index";
}

$controllerFile = __DIR__ . "/Controller/" . $controllerName . ".php";

if (!file_exists($controllerFile)) {
    http_response_code(404);
    die("Controller not found : $controllerName <br>");
}

require_once $controllerFile;

if (!class_exists($controllerName)) {
    die("Controller class not found : $controllerName <br>");
}

$controller = new $controllerName();

if (!method_exists($controller, $method)) {
    http_response_code(404);
    die("Method not found : $method <br>");
}

$controller->$method();

