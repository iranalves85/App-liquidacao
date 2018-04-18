<?php 

namespace Core\Profile;

use Core\Connect as Connect;
use Core\Profile\Login as Login;
use Core\Interfaces\UserInterface;


class User extends Login implements UserInterface{

    public $connect;
    public $user;
    
    //Contrução da classe
    public function __construct( Connect $connect ){
        $this->initSession();
        $this->connect = $connect;
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

    /* Adicionar um novo usuário ou atualizar existente no sistema */
    function updateUser(Connect $connect, $id, $data){

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

    /* Insere um único usuário */
    function deleteUser( $userID ){ 
        
    } 
    

    /* Retorna usuário baseado em outros parametros */
    function getSingleUser( $filter = array() ){        
        $result = $this->pdo->get('users', [
            'id', 'username', 'email', 'area[Object]'
        ], $filter);

        return $result;
    }

    /* Retorna lista de usuários baseado em outros parametros */
    function getListUsers( $filter = array() ){

        $result = $this->pdo->select('users', [
            'id', 'username', 'email', 'area[Object]'
        ], $filter);

        return $result;
    }

    /*Se usuário não tiver acesso finaliza função */
    function user_has_access(){
        //Se usuário não estiver logado e permissão diferente de 'superuser'
        if( ! $this->isLogged() && $this->user['type_user'] != 'superuser' ):
            return "Access Not Authorized.";
            die();
        endif;
    }

}