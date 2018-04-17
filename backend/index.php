<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\UploadedFile as UploadedFile;

require_once 'config.php'; //arquivo de configurações
require_once 'vendor/autoload.php'; //carregando classes
require_once 'vendor/Core/autoload.php'; //carregando classes App();

$app = new \Slim\App($config); //carrega classe com as configurações do ambiente

/* #CONTAINERS ----------------------------------------------*/

// Get container e dependências
$container = $app->getContainer();
$container['upload_directory'] = __DIR__ . '/uploads';

// Registrando um componente (dependencia) de renderização de templates php
$container['view'] = function ($container) {
    return new \Slim\Views\PhpRenderer('./gafp/src/templates/');
};

// PHP Excel
$container['phpexcel'] = function ($container) {
    return new \PHPExcel();
};

// PHP Mailer
$container['phpmailer'] = function ($container) {
    return new \PHPMailer\PHPMailer\PHPMailer();
};

// Registrando classe App() emcapsulado em container
$container['app'] = function ($container) {
    return new \Core\App(); //usuários
};

/* #MIDDLEWARES ----------------------------------------------*/

//Verifica se user esta logado, se não volta para a tela de login
$userLogged = function (Request $request, Response $response, $next){

    //Se usuário 'não' estiver logado
    if( ! $this->app->user->isLogged() ):
        //Destroi sessão e volta tela de login
        return $this->app->user->logout($response);
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

/* #ROUTES ----------------------------------------------*/

//Verifica se usuário esta autenticado e retorna página
$app->get('/', function (Request $request, Response $response ) {    
    return $this->view->render($response, 'login.php', []); //Carrega template
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
    return $this->user->logout($response); //Executa função deslogar
})->setName('logout');

//Página inicial do ambiente
$app->get('/painel', function (Request $request, Response $response, $args) {
    if($this->user->isLogged()) //usuário logado
        return $this->view->render($response, 'painel.php', []); //Carrega template "painel"
})->setName('painel')->add($userLogged);

/*-------------------------------------------------------------------------------------------*/

/*##### PROJECTS ############# */

//Retorna um projeto especifica
$app->get('/projects/{id}', function (Request $request, Response $response, $args){     
    //Variaveis
    $id = $request->getAttribute('id');
    return $response->withJson($this->project->getProject( $this->user, $id ));

})->setName('Project');

//Adiciona um projeto
$app->put('/projects/{id}', function (Request $request, Response $response, $args){     
    //Variaveis
    $id = $request->getAttribute('id');
    $data = $request->getParsedBody();
    return $response->withJson($this->project->updateProject( $this->user, $id, $data ));

})->setName('Update Project');

//Reordenando lista de projetos ordenados
$app->get('/projects/', function (Request $request, Response $response){    
    return $response->withJson($this->project->getListProjects( $this->user ));
})->setName('projects');

//Retorna campos especificos de projectos
$app->get('/projects/fields/{wichData}', function (Request $request, Response $response){    
    $wichData = $request->getAttribute('wichData');
    return $response->withJson($this->project->getProjectFields( $this->user, $wichData ));
})->setName('projects');

//Deleta projeto
$app->delete('/projects/delete/{id}', function (Request $request, Response $response, $args){    
    $id = $request->getAttribute('id');
    return $response->withJson($this->model->deleteProject( $this->user, $id ));

})->setName('Delete Project');

//Adicionar campos de novos projetos
$app->post('/projects/fields[/{wichData}]', function (Request $request, Response $response, $args) {

    $directory = $this->get('upload_directory'); //Definindo diretório para upload
    $upFiles = $request->getUploadedFiles(); //Pega arquivo submetido
    $data = $request->getParsedBody(); //Pega dados submetidos via POST

    //Se não tiver arquivo de upload, adiciona os dados padrão
    if(count($upFiles) > 0): 
        $data['uploadFile'] = $upFiles;
    endif;
    
    //Executa função determinada pela váriavel e retorna json de resultado
    return $response->withJson(
        $this->project->addProjectFields( 
            $this->user,
            $request->getAttribute('wichData'), 
            $data));
    
});

/*########### USUARIOS DO PROJETO  */

//Retorna usuário especifico
$app->get('/projects/user/{id}', function (Request $request, Response $response) {
    $id  = $request->getAttribute('id'); //id do usuário
    return $response->withJson($this->user->getUser(['id' => $id]));
});

//Adiciona um usuário ao projeto
$app->put('/projects/user/{id}', function (Request $request, Response $response) {
    $id  = $request->getAttribute('id');
    $data   = $request->getParsedBody();
    return $response->withJson($this->user->updateUser($this->connect, $id, $data));
});

//Retorna lista de usuários do projeto
$app->get('/projects/users/{id}', function (Request $request, Response $response) {
    $id  = $request->getAttribute('id');
    return $response->withJson($this->user->getUsers(['project' => $id]));
});

//Retorna lista de usuários do projeto
$app->get('/projects/users/responsible/{project}/{id}', function (Request $request, Response $response) {
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


/*########## EMAILS ###############*/
//Grava msg no bd e envia e-mails
$app->post('/projects/sendmail/', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    return $response->withJson( $this->project->sendMail( $this->user, $this->phpmailer, $data ) );
});

//Retorna msg do BD
$app->get('/projects/sendmail/{type}/{id}', function (Request $request, Response $response) {
    $id  = $request->getAttribute('id');
    $type  = $request->getAttribute('type');
    return $response->withJson( $this->project->getMail( $this->user, $id, $type ));
});


/*########## REGRAS ###############*/

//Inserir e atualizar as regras de datas
$app->get('/projects/rules/{id}', function (Request $request, Response $response) {
    $id  = $request->getAttribute('id');
    return $response->withJson($this->project->getRuleProject( $this->user, $id));
});

//Inserir e atualizar as regras de datas
$app->put('/projects/rules/{id}', function (Request $request, Response $response) {
    $id  = $request->getAttribute('id');
    $data = $request->getParsedBody();
    return $response->withJson($this->project->updateRuleProject( $this->user, $id, $data ));
});


/* ###### MODELS ###############*/

//Retorna um modelo baseado num id
$app->get('/model/{id}', function (Request $request, Response $response) {
    $id  = $request->getAttribute('id');
    return $response->withJson($this->model->getModel( $this->user, $id ));
});

//Retorna um modelo baseado num id
$app->put('/model/{id}', function (Request $request, Response $response) {
    $id  = $request->getAttribute('id');
    $data = $request->getParsedBody();
    return $response->withJson($this->model->updateModel( $this->user, $id, $data ));
});

//Retorna lista de modelos baseados em ordenação
$app->get('/model/[/{order}[/{by}]]', function (Request $request, Response $response, $args){
    $order = [
        'order' => ($request->getAttribute('order')) ? $request->getAttribute('order') : 'date_created',
        'by'    => ($request->getAttribute('by'))? $request->getAttribute('by') : 'DESC',
    ];
    return $response->withJson($this->model->getListModels( $this->user, $order ));

})->setName('models');

$app->get('/model/fields/{wichData}', function (Request $request, Response $response, $args){
    
    $wichData = $request->getAttribute('wichData');
    return $response->withJson($this->model->getProjectFields( $this->user, $wichData ));  

})->setName('models');

//Retorna lista de modelos para determinado plano
$app->get('/model/plan/{id}', function (Request $request, Response $response, $args){
    
    $id  = $request->getAttribute('id');
    $response = $response->withJson($this->model->getProjectDataExistActivity( $this->user, $id ));
    return $response;

})->setName('models');

//Adiciona um modelo
$app->post('/model', function (Request $request, Response $response) {
    
    $data = $request->getParsedBody(); //Retorna os dados serializado em array

    $result = $this->model->addModel( $this->user, $data ); //Executa query
    
    $response->getBody()->write($result); //Retorna os dados

    return $response;
});

//Deleta modelo
$app->delete('/model/delete/{id}', function (Request $request, Response $response, $args){    
    $id = $request->getAttribute('id');
    return $response->withJson($this->model->deleteModel( $this->user, $id ));

})->setName('Delete Model');


    

/*########## PLAN ###############*/

//Retorna uma plan especifica
$app->get('/plan/{id}', function (Request $request, Response $response, $args){     
    //Variaveis
    $id = $request->getAttribute('id');
    return $response->withJson($this->plan->getPlan( $this->user, $id ));

})->setName('Activity Plans');

//Adiciona um plano novo
$app->post('/plan', function (Request $request, Response $response, $args){     
    
    $data = $request->getParsedBody();
    return $response->withJson($this->plan->addPlan( $this->user, $data ));

})->setName('Update Add Plans');

//Atualiza ou adiciona um plano novo
$app->put('/plan/{id}', function (Request $request, Response $response, $args){     
    
    $id = $request->getAttribute('id');
    $data = $request->getParsedBody();
    return $response->withJson($this->plan->updatePlan( $this->user, $id, $data ));

})->setName('Update Plans');

//Deleta plano
$app->delete('/plan/delete/{id}', function (Request $request, Response $response, $args){    
    $id = $request->getAttribute('id');
    return $response->withJson($this->plan->deletePlan( $this->user, $id ));
})->setName('Delete Plans');

//Retorna lista de planos
$app->post('/plan/fields/{wichData}', function (Request $request, Response $response){    
    $data['field'] = $request->getAttribute('wichData'); //retorna field
    $data['where'] = $request->getParsedBody(); //Junta arrays
    return $response->withJson($this->plan->getPlanFields( $this->user, $data ));
})->setName('Plans Fields');

//Retorna lista de planos
$app->get('/plan/list/{id}', function (Request $request, Response $response, $args){    
    //Variaveis
    $id = $request->getAttribute('id');
    return  $response->withJson($this->plan->getListPlans( $this->user, $id ));
})->setName('Lista de Plans');

//Retorna lista de planos dos líderes
$app->get('/plan/leader/list/{id}', function (Request $request, Response $response, $args){    
    //Variaveis
    $leader = $request->getAttribute('id');
    return $response->withJson($this->plan->getListLeaderPlans( $this->user, $leader ));
})->setName('Leader Plans List');

//Retorna lista de planos
$app->get('/plan/approver/list/', function (Request $request, Response $response, $args){    
    return  $response->withJson($this->plan->getListApproverPlans( $this->user ));
})->setName('List Approver Plans');

//Atualização de Status
$app->put('/plan/status/{id}', function (Request $request, Response $response, $args){     
    //Variaveis
    $id = $request->getAttribute('id');
    $data = $request->getParsedBody();
    return $response->withJson($this->plan->updatePlanStatus( $this->user, $id, $data ));
})->setName('Update Plans Status');

//Retorna contagem de planos aprovados por status
$app->get('/plan/approved/count/{project}', function (Request $request, Response $response, $args){     //Variaveis
    $data['project'] = $request->getAttribute('project');
    return $response->withJson($this->plan->countApprovedPlansByStatus( $this->user, $data ));
})->setName('Count Approved Plans By Status');


/*########## ATIVIDADE ###############*/

//Retorna uma atividade especifica
$app->get('/plan/activity/{id}', function (Request $request, Response $response, $args){     
    //Variaveis
    $id = $request->getAttribute('id');
    return $response->withJson($this->plan->getActivityPlan( $this->user, $id ));

})->setName('Activity Plans');

//Retorna lista de atividades de um plano
$app->get('/plan/activity/list/{id}', function (Request $request, Response $response, $args){     
    //Variaveis
    $id = $request->getAttribute('id');
    return $response->withJson($this->plan->getListActivityPlan( $this->user, $id ));

})->setName('Activity Plans');

//Retorna contagem de planos por status
$app->get('/plan/activity/status/count/{project}[/{user}]', function (Request $request, Response $response, $args){     //Variaveis
    $data['project'] = $request->getAttribute('project');
    $data['user']   = $request->getAttribute('user');
    return $response->withJson($this->plan->countActivitysByStatus( $this->user, $data ));
})->setName('Count Activitys By Status');

//Adiciona uma atividade especifica
$app->post('/plan/activity/', function (Request $request, Response $response, $args){     
    //Variaveis
    $data = $request->getParsedBody();
    return $response->withJson($this->plan->addActivityPlan( $this->user, $data ));   
})->setName('Add Activity Plans');

//Atualiza atividade especifica
$app->put('/plan/activity/{id}', function (Request $request, Response $response, $args){     
    //Variaveis
    $id = $request->getAttribute('id');
    $data = $request->getParsedBody();
    return $response->withJson($this->plan->updateActivityPlan( $this->user, $id, $data ));
})->setName('Update Activity Plans');

//Atualiza atividade especifica
$app->put('/plan/activity/status/{id}', function (Request $request, Response $response, $args){     
    //Variaveis
    $id = $request->getAttribute('id');
    $data = $request->getParsedBody();
    return $response->withJson($this->plan->updateActivityPlanStatus( $this->user, $id, $data ));
})->setName('Update Activity Plans Status');

//Deleta plano
$app->delete('/plan/activity/delete/{id}', function (Request $request, Response $response, $args){    
    $id = $request->getAttribute('id');
    return $response->withJson($this->plan->deleteActivityPlan( $this->user, $id ));

})->setName('Delete Plans');

/// Evidence

//Retorna uma evidencias de atividade especifica
$app->get('/plan/activity/evidence/{id}', function (Request $request, Response $response, $args){     
    //Variaveis
    $id = $request->getAttribute('id');
    return $response->withJson($this->plan->getActivityEvidence( $this->user, $id ));

})->setName('Activity Plans');


/* #APP INIT ----------------------------------------------------*/

$app->run();

