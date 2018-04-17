<?php 

namespace Core;
use Core\Interfaces\UserInterface;
use Core\Connect as Connect;
use Core\User as User;


class User extends Login implements UserInterface{

    public $connect;
    public $user;
    
    //Contrução da classe
    public function __construct( \Core\Connect $connect ){
        $this->initSession();
        $this->connect = $connect;
    }

    /* 
    - Registrar sessão do usuário
    - Retornar dados importantes
    */
    function login($data){

        //Executa Query
        $result = $this->connect->userLogin($data);

        //Retorna resultado
        if(!$result):
            $msgError = ['error' => "Usuário ou senha incorretos."];
            return $msgError;            
        else:
            //Registra dados da sessão
            $session = $this->registerSession($result);            
            //Retorna dados
            return $session;
        endif;
    }

    /* Retorna um usuário especifico */
    function getUser( $filter = array() ){
        //Invoca função de retornar lista de usuários
        return $this->connect->getSingleUser($filter);      
    } 

    /* Retorna lista de usuários */
    function getUsers( $filter = array() ){
        //Invoca função de retornar lista de usuários
        return $this->connect->getListUsers($filter);      
    } 

    /* Insere um único usuário */
    function addUser( Connect $connect, $projectID, $data ){
        // Retorna id de empresa relacionado ao projeto
        $result = $connect->pdo->get('project',
            ['company'],
            ['id' => $projectID ]);

        //Se tipo de usuário não foi definido
        if( !isset($data['type_user']) ){
            $data['type_user'] = 0;
        }

        // Se retorno for verdadeiro
        if($result){
            return $this->insertMultipleUsers($data, $projectID, $result['company']);    
        }
        
    } 

    /* Insere um único usuário */
    function updateUser( Connect $connect, $userID, $data ){
        
        $user_data = [];
        $columnToSerialize = ['area', 'leader'];
        $result = '';

        //Prepara as informações para inserção no banco
        foreach ($data as $key => $value) {
            //aplicando filtro de string
            if( in_array($key, $columnToSerialize) ):            
                $explode = explode(',', filter_var($value, FILTER_SANITIZE_STRING));
                foreach ($explode as $k => $v) {
                    $explode[$k] = trim($v);
                } 
                $user_data[$key] = serialize($explode);  
            elseif( $key == 'type_user'):
                    $user_data[$key] = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
            else:
                $user_data[$key] = ($key == 'password')? password_hash(filter_var($value, FILTER_SANITIZE_STRING), PASSWORD_DEFAULT) : filter_var($value, FILTER_SANITIZE_STRING);
            endif;            
        }

        //Prevenir contra SQL injections
        $prepare = $connect->pdo->pdo->prepare('users', ['id' => $userID]);

        //Verifica se usuário existe no banco, baseado no email
        if( $connect->pdo->has( $prepare->queryString, ['id' => $userID] )):
            //Executa update e retorna resultado
            $update = $connect->pdo->update('users', $user_data, ['id' => $userID]); 
            $result = $update->rowCount();
        endif;

        return $result;
        
    } 

    /*
        ##### Sessões de usuário
        //Iniciando sessão
    */
    function initSession(){
        ob_start();
        session_start();
    }

    //Registrando sessão
    protected function registerSession($userData){
        
        //Gerando hash
        $cookieToken = password_hash( $userData['email'], CRYPT_BLOWFISH);
        $_SESSION['user'] = $userData; //adiciona dados do usuário na sessão
        $this->user = $_SESSION['user'];
        
        //Setando cookies
        $cookie = setcookie('gafp', $cookieToken, time()+172800, _PATH_ );

        //Se sessão inicializada e cookie setado
        if( isset( $_SESSION['user'] ) && $cookie ):
            return true;
        else:
            return false;
        endif;
    }

    /* Adicionar um novo usuário ou atualizar existente no sistema */
    function newUser($data){

        $user_data = [];
        $columnToSerialize = ['area', 'leader'];
        $result = '';

        //Prepara as informações para inserção no banco
        foreach ($data as $key => $value) {
            //aplicando filtro de string
            if( in_array($key, $columnToSerialize) ):                
                $explode = explode(',', filter_var($value, FILTER_SANITIZE_STRING));
                foreach ($explode as $k => $v) {
                    $explode[$k] = trim($v);
                } 
                $user_data[$key] = serialize($explode);
            elseif( $key == 'type_user'):
                $user_data[$key] = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
            else:
                $user_data[$key] = ($key == 'password')? password_hash(filter_var($value, FILTER_SANITIZE_STRING), PASSWORD_DEFAULT) : filter_var($value, FILTER_SANITIZE_STRING);
            endif;            
        }

        //Prevenir contra SQL injections
        $prepare = $this->pdo->pdo->prepare('users', ['email' => $user_data['email']]);

        //Verifica se usuário existe no banco, baseado no email
        if( $this->pdo->has( $prepare->queryString, ['email' => $user_data['email']] ) ):

            //Executa update e retorna resultado
            $update = $this->pdo->update('users', $user_data, [ 'email' => $user_data['email']] ); 
            $result = $update->rowCount();

        else:
            //Executa insert e retorna resultado
            $insert = $this->pdo->insert('users', $user_data); 
            $result = $this->pdo->id();

        endif;

        return $result;
    }

    /* Adicionar um novo usuário ou atualizar existente no sistema */
    function getSingleUser( $filter = array() ){        
        $result = $this->pdo->get('users', [
            'id', 'username', 'email', 'area[Object]'
        ], $filter);

        return $result;
    }

    /* Adicionar um novo usuário ou atualizar existente no sistema */
    function getListUsers( $filter = array() ){

        $result = $this->pdo->select('users', [
            'id', 'username', 'email', 'area[Object]'
        ], $filter);

        return $result;
    }

    /*Se usuário não tiver acesso finaliza função */
    function user_has_access(User $user){
        //Se usuário não estiver logado e permissão diferente de 'superuser'
        if( ! $user->isLogged() && $user->type_user != 'superuser' ):
            return "Access Not Authorized.";
            die();
        endif;
    }

}