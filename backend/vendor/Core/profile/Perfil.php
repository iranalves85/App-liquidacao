<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Perfil *
 * @author Iran
 */
class Perfil {
    
    public function __construct() {
        
    }
    
    const PERFIL = "perfil"; // Constante com o nome da tabela usada na classe
    
    // Retorna as informações sobre um perfil de usuário
    function getPerfil($id=null)
    {
        $table = self::PERFIL; //Adicionando a constante a variavel
        $sql = new Conn(); // Intanciando a classe Conn que herda os métodos da classe Medoo
        
        $response = $sql->select($table,
        ["[>]trofeus" => ["trofeus" => "ID"]],
        [
            "$table.ID",
            "$table.nickname",
            "$table.senha", 
            "$table.idade",
            "$table.endereco", 
            "$table.foto", 
            "$table.cadastro",
            "$table.alcance",
            "$table.notificacao", 
            "$table.som",
            "trofeus.nome"
        ],["$table.ID" => $id]);
        
        return $response;//Retorna o resultado da query para a variavel
        
    }
    
    // Atualiza as informações sobre um perfil de usuário
    function updatePerfil($dados)
    {
        $table = self::PERFIL; //Adicionando a constante a variavel
        $sql = new Conn(); // Intanciando a classe Conn que herda os métodos da classe Medoo
        
        $response = $sql->update($table,[
            "nickname" => "",
            "senha" => "", 
            "idade" => "",
            "endereco" => "", 
            "foto" => "", 
            "cadastro" => "", 
            "alcance" => "", 
            "notificacao" => "",
            "som" => ""
        ],["ID" => $id]);
        
        return $response;//Retorna o resultado da query para a variavel
        
    }
    
    // Atualiza as informações sobre um perfil de usuário
    function addPerfil($dados)
    {
        $table = self::PERFIL; //Adicionando a constante a variavel
        $sql = new Conn(); // Intanciando a classe Conn que herda os métodos da classe Medoo
        
        $response = $sql->insert($table,[
            "nickname" => $dados,
            "senha" => $dados, 
            "idade" => "",
            "endereco" => "", 
            "foto" => "", 
            "cadastro" => "", 
            "alcance" => "", 
            "notificacao" => "",
            "som" => ""
        ]);
        
        return $response;//Retorna o resultado da query para a variavel
        
    }
    
    //Deleta o perfil do usuário
    public function deletePerfil($id){        
        $table = self::PERFIL; //Adicionando a constante a variavel
        $sql = new Conn(); // Intanciando a classe Conn que herda os métodos da classe Medoo      
        $response = $sql->delete($table,["ID" => $id]);        
        return $response; //Retorna o resultado da query para a variavel
    }

    
}
