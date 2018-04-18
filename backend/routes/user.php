<?php 

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\UploadedFile as UploadedFile;

/*########### USER ROUTES ######################### */

//Retorna usuário especifico
$app->get('/user/{id}', function (Request $request, Response $response) {
    $id  = $request->getAttribute('id'); //id do usuário
    return $response->withJson($this->user->getUser(['id' => $id]));
});

//Adiciona um usuário ao projeto
$app->put('/user/{id}', function (Request $request, Response $response) {
    $id  = $request->getAttribute('id');
    $data   = $request->getParsedBody();
    return $response->withJson($this->user->updateUser($this->connect, $id, $data));
});

//Retorna lista de usuários do projeto
$app->get('/users/business/{id}', function (Request $request, Response $response) {
    $id  = $request->getAttribute('id');
    return $response->withJson($this->user->getUsers(['project' => $id]));
});

//Retorna lista de usuários do projeto
$app->get('/users/', function (Request $request, Response $response) {
    $project  = $request->getAttribute('project');
    $id       = $request->getAttribute('id');
    return $response->withJson($this->project->getResponsibleProject($this->user, $project, $id));
});

//Retorna lista de usuários do projeto
$app->get('/projects/users/manager/{id}', function (Request $request, Response $response) {
    $id  = $request->getAttribute('id');
    return $response->withJson($this->user->getUsers(['project' => $id, 'type_user[~]' => 0]));
});

//Adiciona usuários ao projeto
$app->post('/projects/users/manager/{id}', function (Request $request, Response $response, $args) {
    $id     = $request->getAttribute('id');
    $data   = $request->getParsedBody();
    return $response->withJson($this->user->addUser($this->connect, $id, $data));
});