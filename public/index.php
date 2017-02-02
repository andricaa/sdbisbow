<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App(['settings' => ['displayErrorDetails' => true]]);

require_once ('../app/api/database.php');
require_once ('../app/api/default-view.php');
require_once ('../app/api/detail-view.php');
require_once ('../app/api/count-species.php');
require_once ('../app/api/quick-search.php');
require_once ('../app/api/attributes.php');


$app->run();

?>