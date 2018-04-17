<?php
/*
*  Template: Human Resources
*  30/08/2017
*/

require_once('gafp/src/Connect.php');

/* Informações do usuário */
$type_user  = $_SESSION['user']['type_user'];
$username   = $_SESSION['user']['username'];
$email      = $_SESSION['user']['email'];

?>
<!DOCTYPE html>
<html ng-app="gafpApp">

<head>
<title><?php echo $email; ?> | GPTW - Painel de Acompanhamento</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

<link rel="stylesheet" href="assets/css/main.css" crossorigin="anonymous">
<link rel="stylesheet" href="node_modules/angular-ui-bootstrap/dist/ui-bootstrap-csp.css" crossorigin="anonymous">
<!-- Jquery -->
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<!-- Angular -->
<script src="node_modules/angular/angular.js"></script>
<script src="node_modules/angular-ui-bootstrap/dist/ui-bootstrap.js"></script>
<script src="node_modules/angular-ui-bootstrap/dist/ui-bootstrap-tpls.js"></script>
<script src="node_modules/angular-route/angular-route.min.js"></script>
<script src="node_modules/angular-file-upload/dist/angular-file-upload.min.js"></script>
<script src="node_modules/angular-filter/dist/angular-filter.min.js"></script>
<script>
    //Inicializa objeto Angular  
    $app = angular.module('gafpApp', 
    ['ngRoute', 'angularFileUpload', 'ui.bootstrap', 'angular.filter']);
</script>

<?php  if( $type_user == 'superuser' ): //Carrega script ?>
<script src="app/panel-app/superuser/superuser.component.js"></script>
<?php else: ?>
<script src="app/panel-app/human-resources/human-resources.component.js"></script>
<script src="app/panel-app/manager/manager.component.js"></script>
<script src="app/panel-app/charts.component.js"></script>
<?php endif; ?>
<script src="app/panel-app/custom-filters.js" /></script>
<script src="http://momentjs.com/downloads/moment.js" /></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js" ></script>
<script src="assets/js/main.js" type="text/javascript"></script>
<script>
    var user = <?php echo json_encode($_SESSION['user']); ?>;
</script>

</head>

<body class="panel"> 
    
    <header class="topo">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <img src="assets/images/gptw-logo-app.png" width="45px" alt="GPTW - Painel de Acompanhamento" /><strong class="panel-name">Painel de Acompanhamento</strong>
                </div>
                <div class="col-6">
                    <ul class="list-inline float-right">
                        <li class="list-inline-item btn btn-sm">Bem vindo, <b><?php echo $username; ?></b></li>
                        <li class="list-inline-item"><a class="btn btn-sm btn-outline-light" href="logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header><!-- Topo -->

    <main>

        <?php  if( $type_user == 'superuser' ): ?>
        <superuser-app></superuser-app>
        <?php else: ?>
        <manager-app></manager-app>
        <?php endif; ?>
        
    </main>

</body>

</html>