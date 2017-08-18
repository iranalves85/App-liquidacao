/* 21.09.2015
 * Arquivo com as funções de acesso aos dados
 */

//Inicializando o módulo do Angular.js
var App = angular.module('App',[], function($httpProvider){
    // Use x-www-form-urlencoded Content-Type
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

    /**
     * The workhorse; converts an object to x-www-form-urlencoded serialization.
     * @param {Object} obj
     * @return {String}
     */
    var param = function(obj) {
      var query = '', name, value, fullSubName, subName, subValue, innerObj, i;

      for(name in obj) {
        value = obj[name];

        if(value instanceof Array) {
          for(i=0; i<value.length; ++i) {
            subValue = value[i];
            fullSubName = name + '[' + i + ']';
            innerObj = {};
            innerObj[fullSubName] = subValue;
            query += param(innerObj) + '&';
          }
        }
        else if(value instanceof Object) {
          for(subName in value) {
            subValue = value[subName];
            fullSubName = name + '[' + subName + ']';
            innerObj = {};
            innerObj[fullSubName] = subValue;
            query += param(innerObj) + '&';
          }
        }
        else if(value !== undefined && value !== null)
          query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
      }

      return query.length ? query.substr(0, query.length - 1) : query;
    };

    // Override $http service's default transformRequest
    $httpProvider.defaults.transformRequest = [function(data) {
      return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
    }];
});

/* Prepara uma função com Rotas
 * @param {type} param1
 * @param {type} param2
 */

// HOME
// Preparação de dados via Angular.js
// Tutorial: https://docs.angularjs.org/tutorial/step_02
App.controller('ViewDataList', function($scope, $http){

    onDeviceReady();

    $http.get('http://localhost/desenvolvimento/App-backend/view/list/-25.0000000&-25.0000000').
    success(function(request, status, headers, config) {
        $scope.listItem = request;
        //console.log($scope.listItem);
        console.log("Status de retorno do servidor : " + status);
        //console.log(headers);
        //console.log(config);
    });
});

// VIEW_P
// Preparação de dados via Angular.js
// Tutorial: https://docs.angularjs.org/tutorial/step_02
App.controller('ViewData', function($scope, $http){
    $http.get('http://localhost/desenvolvimento/App-backend/view/' + varGET('id')).
    success(function(request, status, headers, config) {
        data = request;
        console.log(data);
        $scope.itemData =
            {
                'id': data[0].ID,
                'cadastro': data[0].cadastro,
                'categoria': data[0].categoria,
                'descricao': data[0].descricao,
                'fotos': data[0].fotos,
                'latitude': data[0].latitude,
                'longitude': data[0].longitude,
                'periodo': data[0].periodo,
                'preco': data[0].preco,
                'produto': data[0].produto,
                'usuario': data[0].usuario,
                'visibilidade': data[0].visibilidade,
                'comentarios': data[0].comentarios_p
            };
    });
});

//Método para inserir uma nova view
//Futuramente colocar em um arquivo externo
App.controller('newView', function($scope,$http){
    $scope.getImage = function(){
        //Ao clicar no botão inicializa o app de captura de fotos
        navigator.device.capture.captureImage(captureSuccess, captureError, {limit:2});
    };
    $scope.addView = function(){

        var data = {
                    "perfil" : 1, // Deve ser uma variavel no ambiente do cliente capturado via função
                    "latitude" : -5.0000000, //Capturado via função
                    "longitude" : -5.0000000, //Capturado via função
                    "categoria" : $scope.add.categoria,
                    "descricao" : $scope.add.descricao,
                    "fotos" : "fotos.jpg",
                    "periodo" : $scope.add.periodo,
                    "preco" : $scope.add.preco,
                    "produto" : $scope.add.produto,
                    "visibilidade" : $scope.add.visibilidade
                };

        var config = {
            method: "POST",
            url: "http://localhost/desenvolvimento/App-backend/view/",
            data: data
        };

        console.log(data);

        $http(config).then(function(data){
            console.log(data);
            console.log("retorno OK");
        });
    };
});

//Método para adquirir o variavel da url (GET)
//Futuramente colocar em um arquivo externo
function varGET(nome){
    var $_GET = {};
    if(window.location.toString().indexOf('?') !== -1) {
        var query = window.location
                       .toString()
                       // get the query string
                       .replace(/^.*?\?/, '')
                       // and remove any existing hash string (thanks, @vrijdenker)
                       .replace(/#.*$/, '')
                       .split('&');

        for(var i=0, l=query.length; i<l; i++) {
           var aux = decodeURIComponent(query[i]).split('=');
           $_GET[aux[0]] = aux[1];
        }
    }
    return $_GET[nome];
}

// Captura de latitude X longitude
// IMPORTANTE: NÃO ESTA FUNCIONANDO CORRETAMENTE NO PHONEGAP
// VERIFICAR POSTERIORMENTE
document.addEventListener("deviceready", onDeviceReady, false);

// device APIs are available
function onDeviceReady() {
    // Geolocation capture
    navigator.geolocation.getCurrentPosition(onSuccess, onError);

    // start image capture
    //navigator.device.capture.captureImage(captureSuccess, captureError, {limit:2});
}

// onSuccess Geolocation
function onSuccess(position) {

    // Definindo os valores do objeto position em outro objeto location
    location = {
        latitude: position.coords.latitude,
        longitude:  position.coords.longitude
    };

    console.log(location);
}

// onError Callback receives a PositionError object
function onError(error) {
    console.log(error.code);
    console.log(error.message);
}

// Capture de imagem através do app nativo de camera
// capture callback
var captureSuccess = function(mediaFiles) {
    var i, path, len;
    for (i = 0, len = mediaFiles.length; i < len; i += 1) {
        path = mediaFiles[i].fullPath;
        // do something interesting with the file
    }
};

// capture error callback
var captureError = function(error) {
    navigator.notification.alert('Error code: ' + error.code, null, 'Capture Error');
};
