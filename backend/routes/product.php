<?php 

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\UploadedFile as UploadedFile;

/*########## PRODUCT ROUTES ###############*/

//Retorna uma plan especifica
$app->get('/product/{id}', function (Request $request, Response $response, $args){     
    //Variaveis
    $id = $request->getAttribute('id');
    return $response->withJson($this->app->product->getProduct( $this->app->user, $id ));

})->setName('Get Product');

//Adiciona um plano novo
$app->post('/product', function (Request $request, Response $response, $args){     
    
    $data = $request->getParsedBody();
    return $response->withJson($this->plan->addPlan( $this->user, $data ));

})->setName('Update Add Plans');

//Atualiza ou adiciona um plano novo
$app->put('/product/{id}', function (Request $request, Response $response, $args){     
    
    $id = $request->getAttribute('id');
    $data = $request->getParsedBody();
    return $response->withJson($this->plan->updatePlan( $this->user, $id, $data ));

})->setName('Update Plans');

//Deleta plano
$app->delete('/product/{id}', function (Request $request, Response $response, $args){    
    $id = $request->getAttribute('id');
    return $response->withJson($this->plan->deletePlan( $this->user, $id ));
})->setName('Delete Plans');

//Retorna lista de planos
$app->post('/product/list/{wichData}', function (Request $request, Response $response){    
    $data['field'] = $request->getAttribute('wichData'); //retorna field
    $data['where'] = $request->getParsedBody(); //Junta arrays
    return $response->withJson($this->plan->getPlanFields( $this->user, $data ));
})->setName('Plans Fields');

//Retorna lista de planos
$app->get('/product/list/{id}', function (Request $request, Response $response, $args){    
    //Variaveis
    $id = $request->getAttribute('id');
    return  $response->withJson($this->plan->getListPlans( $this->user, $id ));
})->setName('Lista de Plans');

//Atualização de Status
$app->put('/product/status/{id}', function (Request $request, Response $response, $args){     
    //Variaveis
    $id = $request->getAttribute('id');
    $data = $request->getParsedBody();
    return $response->withJson($this->plan->updatePlanStatus( $this->user, $id, $data ));
})->setName('Update Plans Status');

//Retorna contagem de planos aprovados por status
$app->get('/product/count/{id}', function (Request $request, Response $response, $args){     //Variaveis
    $data['project'] = $request->getAttribute('project');
    return $response->withJson($this->plan->countApprovedPlansByStatus( $this->user, $data ));
})->setName('Count Approved Plans By Status');