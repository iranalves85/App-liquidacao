<?php 

namespace Core\Profile;

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

    function getSocialLogin(){
        
    }

    //Se usuario deslogado, direciona para tela de login
    function userLogout(\Psr\Http\Message\ResponseInterface $response){
        ob_end_clean();
        session_destroy();
        setcookie('gafp');
        setcookie('gafp-user');
        return $response->withStatus(200)->withHeader('Location', _PATH_); 
    }

    /*
        ##### Funções de verificação de login
        Retorna se usuarios esta logado, sim ou não
    */
    function isLogged(){        
        if( isset($_SESSION['user']) ):
            return true;
        else:
            return false;
        endif;
    }

    function isCookieValid(){ 
        if( isset($_COOKIE['gafp']) && password_verify( $this->user['email'], $_COOKIE['gafp']) ):
            return true;
        else:
            return false;
        endif;
    }

    function currentUser(){ 
        return $_SESSION['user'];
    }

}