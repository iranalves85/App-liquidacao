<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Comment
 *
 * @author Iran
 */
class Comment {
        
    const COMENTARIO = "comentarios_p";
    
    public function getListComment($id){  
        
        $table = self::COMENTARIO; //Adicionando a constante a variavel
        $sql = new Conn(); // Intanciando a classe Conn que herda os métodos da classe Medoo
        
        $response = $sql->select($table,
            ["[>]perfil" => "ID" ],[
            "perfil.usuario",
            "perfil.ID",
            "$table.comentario", 
            "$table.cadastro"
        ],["$table.view_p" => $id]);
        
        return $response;//Retorna o resultado da query para a variavel
    }
}
