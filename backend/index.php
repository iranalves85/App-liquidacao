<?php

require 'config.php'; //arquivo de configurações
require 'vendor/autoload.php'; //carregando classes
require 'vendor/Core/autoload.php'; //carregando classes App();

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\UploadedFile as UploadedFile;

$app = new \Slim\App($config); //carrega classe com as configurações do ambiente

/* ###### CONTAINERS ######################################## */

// Get container e dependências
$container = $app->getContainer();

/*
$container['upload_directory'] = __DIR__ . '/uploads';

// Registrando um componente (dependencia) de renderização de templates php
$container['view'] = function ($container) {
    return new \Slim\Views\PhpRenderer('./gafp/src/templates/');
};

// PHP Excel
$container['phpexcel'] = function ($container) {
    return new \PHPExcel();
};
*/

// PHP Mailer
$container['phpmailer'] = function ($container) {
    return new \PHPMailer\PHPMailer\PHPMailer();
};

// Registrando classe App() emcapsulado em container
$container['app'] = function ($container) {
    return new \Core\App(); //usuários
};

/* ################# MIDDLEWARES ####################################### */

//Verifica se user esta logado, se não volta para a tela de login
$userLogged = function (Request $request, Response $response, $next){

    //Se usuário 'não' estiver logado
    if( ! $this->app->user->isLogged() ):
        //Destroi sessão e volta tela de login
        return $this->app->user->userLogout($response);
    endif;

    $next($request, $response);

    return $response;
};

//Verifica se user esta logado, se não volta para a tela de login
$userCookie = function (Request $request, Response $response, $next){
    
    //Se cookie estiver válido
    if( $this->app->user->isCookieValid() ):
        //Redireciona para painel
        return $response->withStatus(200)->withHeader('Location', 'painel'); 
    endif;

    $next($request, $response);

    return $response;
};

/* ########## LOAD ROUTES ########################### */

require 'routes/authentication.php'; 
require 'routes/business.php'; 
require 'routes/category.php'; 
require 'routes/comment.php'; 
require 'routes/mail.php'; 
require 'routes/product.php'; 
require 'routes/rules.php'; 
require 'routes/user.php'; 

/* ########### APP INIT #############################*/

$app->run();

