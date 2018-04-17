<?php 

namespace App;

class Login{

    function __contruct(){

    }

    /* Retorna dados de usuário */
    function userLogin($data){

        $login_data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL); //aplicando filtro de string
        $login_data['pass'] = filter_var($data['password'], FILTER_SANITIZE_STRING); //aplicando filtro de string

        //Verifica se usuário existe
        if( ! $this->pdo->has('users', ['email' => $login_data['email']] )):
            return false;
        endif;

        //Retorna senha hasheada do banco
        $pass = $this->pdo->get('users', ['password'], ['email' => $login_data['email']]);
        
        //Verifica se usuário existe no banco, comparando senha
        if( password_verify($login_data['pass'], $pass['password']) ):

            //Dados para requisição
            $select = ['email' => $login_data['email']];
            //Prepara para executar a requisição
            $prepare = $this->pdo->pdo->prepare('users', $select);
            //Executa query e retorna resultado
            $result = $this->pdo->get('users', 
            ['[>]type_user' => ['type_user' => 'id'] ],
            ['users.id', 'users.email', 'users.username', 'users.area[Object]', 'users.project', 'type_user.type(type_user)'], $select); 

            return $result;

        else:
            //Retorna string erro
            return false;

        endif;
    }

}


    