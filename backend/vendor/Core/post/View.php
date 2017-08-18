<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * A Classe View é responsavel pelos dados sobre os produtos
 *
 * @author Iran
 */

class View {
    
    public function __contruct() {
        
    }
    
    const VIEW_P = "view_p"; // Constante com o nome da tabela usada na classe
    const TOLERANCIA = 5.0000000; // O valor de tolerância deve ser baseado em 5km a partir da latitude atual
    
    // Retorna um único view baseado em id passo em paramêtro
    public function getView($id=null){
        
        $table = self::VIEW_P; //Adicionando a constante a variavel
        $sql = new Conn(); // Intanciando a classe Conn que herda os métodos da classe Medoo
        
        $response = $sql->select($table,
            ["[>]categoria" => ["categoria" => "ID"],"[>]perfil" => ["perfil" => "ID"]],[
            "$table.ID",
            "$table.latxlong",
            "$table.produto", 
            "$table.descricao",
            "$table.preco", 
            "categoria.categoria", 
            "perfil.usuario", 
            "$table.periodo", 
            "$table.cadastro",
            "$table.fotos",  
            "$table.visibilidade",
            "$table.comentarios_p"
        ],["$table.ID" => $id]);
        
        return $response;//Retorna o resultado da query para a variavel
    }
    
    // Função para retorno de lista de views para listagem inicial
    // e mostrar no mapa Google Maps baseado em parâmetro Latitude x Longitude
    public function getListView($latitude=null,$longitude=null){
        
        $table = self::VIEW_P; //Adicionando a constante a variavel
        $sql = new Conn(); // Instanciando a classe Conn que herda os métodos da classe Medoo
        
        $response = $sql->select($table,
        ["[>]categoria" => ["categoria" => "ID"],
         "[>]perfil" => ["perfil" => "ID"]
        ],[
            "$table.ID",
            "$table.latitude",
            "$table.longitude",
            "$table.produto", 
            "$table.descricao",
            "$table.preco", 
            "categoria.categoria", 
            "perfil.usuario", 
            "$table.periodo", 
            "$table.cadastro",
            "$table.fotos",  
            "$table.visibilidade",
            "$table.comentarios_p"
        ],[
           "OR" => ["$table.longitude[<>]" => [$longitude - self::TOLERANCIA, $longitude + self::TOLERANCIA],
                    "$table.latitude[<>]" => [$latitude - self::TOLERANCIA, $latitude + self::TOLERANCIA]]
        ],[
            "LIMIT" => 10
        ]);
        
        return $response;//Retorna o resultado da query para a variavel
        
    }
    
    //Update
    public function updateView($id,$dados){
        
        $table = self::VIEW_P; //Adicionando a constante a variavel
        $sql = new Conn(); // Intanciando a classe Conn que herda os métodos da classe Medoo
        
        $response = $sql->update($table,[
            "latitude" => $dados['latitude'],
            "longitude" => $dados['longitude'],
            "produto" => $dados['produto'], 
            "descricao" => $dados['descricao'],
            "visibilidade" => $dados['visibilidade'],
            "categoria" => $dados['categoria'], 
            "preco" => $dados['preco'],            
            "perfil" => $dados['user'], 
            "periodo" => $dados['periodo'], 
            "cadastro" => $dados['periodo'],
            "fotos" => $dados['fotos']
        ],["ID" => $id]);
        
        return $response; //Retorna o resultado da query para a variavel
    }
    
    //Put
    public function addView($dados){
        
        $table = self::VIEW_P; //Adicionando a constante a variavel
        $sql = new Conn(); //Intanciando a classe Conn que herda os métodos da classe Medoo
        
        $response = $sql->insert($table,[
            "latitude" => $dados['latitude'],
            "longitude" => $dados['longitude'],
            "produto" => $dados['produto'], 
            "descricao" => $dados['descricao'],
            "visibilidade" => $dados['visibilidade'],
            "categoria" => $dados['categoria'], 
            "preco" => $dados['preco'],            
            "perfil" => $dados['perfil'], 
            "periodo" => $dados['periodo'], 
            "cadastro" => "2015-09-13", //getdate(),
            "fotos" => $dados['fotos']         
        ]);
        
        return $response; //Retorna o resultado da query para a variavel
    }
    
    //Delete
    public function deleteView($id){
        
        $table = self::VIEW_P; //Adicionando a constante a variavel
        $sql = new Conn(); // Intanciando a classe Conn que herda os métodos da classe Medoo        
        $response = $sql->delete($table,["ID" => $id]);        
        return $response; //Retorna o resultado da query para a variavel
    }
}
