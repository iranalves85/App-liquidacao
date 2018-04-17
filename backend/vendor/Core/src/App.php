<?php
/**
 * App Liquidação Core
 * Version: 0.1
 *
 * @link      https://github.com/iranalves85
 * @copyright Copyright (c) 2018-* Iran Alves
 * @license   https://github.com/slimphp/Slim/blob/3.x/LICENSE.md (MIT License)
 */

namespace Core;

use Badge;
use Business;
use Category;
use Comment;
use Connect;
use Map;
use Product;
use Profile\User;
use Profile\Config;
use Profile\Friends;
use Profile\Login;
use Interfaces\BadgeInterface;
use Interfaces\UserInterface as UserInterface;

class App{

    private $_host;
    private $_bd;
    private $_user;
    private $_pass;
    public $user;
    public $connect;
    
    
    function __construct(){
        $user = $this->user();
        $connect = $this->connect();
    }   

    function connect(){
        return new Connect($_host, $_bd, $_user, $_pass);
    }

    function user(){
        return new UserInterface($connect);
    }

    //Função que verifica var retorno de resultado de query no banco
    public function data_return($result){
        
        if(count($result) <= 0 || !is_array($result)):
            return false;
        else:
            //Retorna dados de usuário
            return $result;            
        endif;
    }

    //Função que verifica var retorno de resultado de query no banco
    //$result = recebe id de inserção
    public function data_return_insert($result){        
        //Retorna dados de usuário
        if(is_array($result)):
            $id = (int) $result['id'];
        else:
            $id = (int) $result;
        endif;

        //Retorna $id ou false
        return ($id <= 0)? false : $id;            
    }

    public function data_converter_to_insert($date){
        setlocale (LC_ALL, 'pt_BR');
        date_default_timezone_set('America/Sao_Paulo');
        return date('Y-m-d H:i:s', strtotime($date));
    }

}