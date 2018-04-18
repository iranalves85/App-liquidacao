<?php 

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\UploadedFile as UploadedFile;

/*########## COMMENT ROUTES  ###############*/

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