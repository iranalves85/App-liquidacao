<?php

namespace Core;

class Connect{

    protected   $server;
    protected   $bd;
    protected   $user;
    protected   $pass;
    public      $pdo;
    protected   $tb;

    function __construct($prefix = _PREFIX_){
        
        $server     = _HOST_;
        $bd         = _DATABASE_;
        $user       = _DB_USER_;
        $pass       = _DB_PASS_;

        //setlocale();
        date_default_timezone_set ( 'America/Sao_Paulo' );
        
        return $this->pdo = new \Medoo\Medoo([
            'database_type' => 'mysql',
            'database_name' => $bd,
            'server'        => $server,
            'username'      => $user,
            'password'      => $pass,
            'charset'       => 'utf8',
            'prefix'        => $prefix,
            'debug_mode'    => true
        ]);
    }

    public function isConnected(){
        
    }

}