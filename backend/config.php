<?php

//Definindo domínio da aplicação
define('_PATH_', 'http://127.0.0.1/desenvolvimento/app-liquidacao/backend/'); 

/* DATABASE Connection */ 
define('_HOST_', 'localhost');
define('_DATABASE_', 'app');
define('_DB_USER_', 'root');
define('_DB_PASS_', '');
define('_PREFIX_', ''); //Definindo prefixo de tabelas

/* SMTP Send host */
define('_SMTP_HOST_', 'smtp1.example.com;smtp2.example.com'); // HOST de Envio
define('_USER_EMAIL_', 'user@example.com');   //Email de envio
define('_USER_PASS_', 'secret'); //Password de email
define('_SMTP_SECURE_', 'tls');  // Enable TLS encryption, `ssl` also accepted
define('_PORT_', 587);   //Porta

//define Name_Alerts
define('_PROGRESS_', 'Em Progresso'); //Password de email
define('_WARNING_', 'Atenção');  // Enable TLS encryption, `ssl` also accepted
define('_DANGER_', 'Em Atraso');   //Porta

$config = [
    'settings' => [
        'displayErrorDetails' => true
    ]
];

/* LOCALIZE APPLICATION */
setlocale (LC_ALL, 'pt_BR');
date_default_timezone_set('America/Sao_Paulo');