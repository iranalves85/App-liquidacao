<?php
// Auto-carrega os packages do Composer
require 'vendor/autoload.php';

// Tentar colocar esse require como autoload
require 'vendor/core/index.php';

// Inicializando a framework Slim, parametros definindo
// que se trata de versão de desenvolvimento
$app = new Slim(array(
    'mode' => 'development',
    'debug' => true
));

// Setando a resposta em formato JSON
$app->response()->header('Access-Control-Allow-Origin', '*');//'http://192.168.1.187:3000');
$app->response()->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
$app->response()->header('Content-Type', 'application/json;charset=utf-8');

// const PATH_SERV = URL.OU.IP.DO.SERVIDOR ;

// switch de chaveamento
// Uma função que vai receber parametros JSON do App para direcionar
// as requisições para as funções corretas e não expor a estrutura do sistema
/*switch ($app) {
    case $value:
        break;
    default:
        break;
}
*/

// Define um route para a home, ou seja, as requisições
// ao banco de dados são realizados através de http (urls)
// definidas via php com Slim
$app->get('/', function(){
    echo 'home';
});

// VIEW
// Routes: View
// route GET
$app->get('/view/:id', function($id){ 
    $view = new View(); //Instancia a classe View    
    $result = $view->getView($id); //Parametro via JSON(frontend) e Retorna o array gerado pela função     
    $comment = new Comment(); //Instanceia a classe Comment            
    //Converter os dados da tabela comentarios_p em um array de dados para submeter na query abaixo
    $result[0]['comentarios_p'] = $comment->getListComment($result[0]['comentarios_p']); //Adiciona o array de resultado na key especificada    
    echo(json_encode($result)); // Imprime o resultado encodando no formato json
});

// route GET (lista)
$app->get('/view/list/:lat&:lon', function($lat,$lon){ 
    $view = new View(); //Instancia a classe View
    $result = $view->getListView($lat,$lon); //O parametros da função navigator.geolocation.getCurrentPosition = JSON(frontend)             
    echo json_encode($result); 
});

// MÉTODO AINDA NÃO IMPLEMENTADO
// route UPDATE
$app->put('/view/:id', function($id){ 
    $view = new View(); //Instância a classe View
    $dados = array(0 => "teste de novo"); //Esses dados devem vir via JSON
    $result = $view->updateView($id,$dados); //Parametro via JSON(frontend) e Retorna o array gerado pela função 
    var_dump($result);    
    //echo(json_encode($result)); // Imprime o resultado encodando no formato json
});

// MÉTODO AINDA NÃO IMPLEMENTADO
// route ADD
$app->post('/view/', function(){ 
    $view = new View(); //Instância a classe View
    $dados = $_POST; // Recebendo dados de POST (json) e tratando 
    $result = $view->addView($dados); //Parametro via JSON(frontend) e Retorna o array gerado pela função 
    echo(Zend\Json\Json::encode($result)); // Imprime o resultado encodando no formato json 
    
});

// route DELETE
$app->delete('/view/:id', function($id){ 
    $view = new View(); //Instância a classe View
    $result = $view->deleteView($id); //Parametro via JSON(frontend) e Retorna o array gerado pela função 
    var_dump($result);    
    //echo(json_encode($result)); // Imprime o resultado encodando no formato json
});

// PERFIL
// Routes: perfil
// route GET
$app->get('/perfil/:id', function($id){ 
    $perfil = new Perfil(); //Intancia a classe View    
    $result = $perfil->getPerfil($id); //Parametro via JSON(frontend) e Retorna o array gerado pela função     
    var_dump(json_encode($result)); // Imprime o resultado encodando no formato json
});
// route INSERT (UPDATE)
$app->put('/perfil/:id', function($id){ 
 
});
// route ADD
$app->post('/perfil/', function(){ 
    
});
// route DELETE
$app->delete('/perfil/:id', function($id){ 
    $view = new Perfil(); //Instância a classe View
    $result = $view->deletePerfil($id); //Parametro via JSON(frontend) e Retorna o array gerado pela função 
    var_dump($result);    
    //echo(json_encode($result)); // Imprime o resultado encodando no formato json
});

// Inicializa o programa
$app->run();
