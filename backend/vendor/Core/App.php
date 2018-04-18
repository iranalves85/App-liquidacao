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

use Core\Business as Business;
use Core\Category as Category;
use Core\Comment as Comment;
use Core\Connect as Connect;
use Core\Map as Map;
use Core\Product as Product;
use Core\Profile\Login as Login;
use Core\Profile\User as User;
use Core\Profile\Badge as Badge;
use Core\Profile\Config as Config;
use Core\Profile\Friends as Friends;
use Core\Interfaces\BadgeInterface as BadgeInterface;
use Core\Interfaces\UserInterface as UserInterface;

class App{

    public $user;
    public $connect;
    public $product;
    
    function __construct(){
        $this->connect = $this->connect(); 
        $this->user = $this->user();  
        $this->product = new Product();  
    }   

    function connect(){
        return new Connect();
    }

    function user(){
        return new User($this->connect);
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