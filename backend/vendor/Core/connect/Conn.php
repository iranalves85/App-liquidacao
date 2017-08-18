<?php
/**
 * Setando a conexão ao banco de dados.
 *
 * @author Iran
 */

Class Conn extends medoo{

    public function __construct() {
        
        //Paramêtros em array das informações sobre o BDO
        $options = array(
            // required
            'database_type' => 'mysql',
            'database_name' => 'app',
            'server' => 'localhost',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8'                
        );
        
        //Passando os paramêtros para a classe pai desta
        parent::__construct($options);
    }
}






        
