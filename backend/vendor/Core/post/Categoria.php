<?php

/**
 * Description of Categoria
 *
 * @author Iran
 */

class Categoria {
    
    const CATEGORIA = "categorias"; // Constante com o nome da tabela usada na classe
    
    public function __construct() {
       
    }
    
    //Select
    public function getCategory($id=null){
        $table = self::CATEGORIA; //Adiciona a constante a variavel
        
        $stmt = getConn()->query("SELECT nome FROM $table WHERE ID LIKE $id"); //Inicializa conexão com banco e definindo a query
        
        return $stmt->fetch(PDO::FETCH_ASSOC);//Retorna o resultado da query para a variavel
    }
    
    // Parametros de query GET no banco de dados
    // para a tabela categorias
    function getListCategory()
    {
        $stmt = getConn()->query("SELECT * FROM categorias");
        $categorias = $stmt->fetchAll(PDO::FETCH_OBJ);
        echo "{categorias:".json_encode($categorias)."}";
    }
    
    //Update
    public function updateCategory(){
        
    }
    
    //Put
    public function addCategory(){
        
    }
    
    //Delete
    public function deleteCategory(){
        
    }
    
}
