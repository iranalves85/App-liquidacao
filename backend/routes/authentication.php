<?php 

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\UploadedFile as UploadedFile;

/*##### AUTHENTICATION ROUTES ##########################*/

//Verifica se usuário esta autenticado e retorna página
$app->get('/', function (Request $request, Response $response ) {   

    //return $this->view->render($response, 'login.php', []); //Carrega template

})->setName('login')->add($userCookie);

//URL para envio de credenciais para login
$app->post('/login', function (Request $request, Response $response, $args) {
    
    $data = $request->getParsedBody(); //Retorna os dados serializado em array

    $result = $this->user->login($data); //Executa query

    //Se true, continua acesso
    if( is_bool($result) && $result == true ) 
        return $response->withJson($result); //Retorna dados
    
    //Retornar erro se existir
    if(is_array($result) && array_key_exists('error', $result))
        return $response->getBody()->write($result['error']); //Retorna dados

    //Retorna quando houver error anterior
    return array('error' => 'Houve um problema com a autenticação. Tente novamente.');

});

//Desloga e finaliza sessão
$app->get('/logout', function (Request $request, Response $response) { 

    //return $this->user->logout($response); //Executa função deslogar

})->setName('logout');


/*################### DASHBOARD #############################*/

//Página inicial do ambiente
$app->get('/painel', function (Request $request, Response $response, $args) {
    if($this->user->isLogged()) //usuário logado
        return $this->view->render($response, 'painel.php', []); //Carrega template "painel"
})->setName('painel')->add($userLogged);