/*
 * Script de carregamento dos maps gerados pelo Google Maps
 */

function showPosition(position) {                        
    lat = position.coords.latitude;
    lon = position.coords.longitude;
    latlon = new google.maps.LatLng(lat, lon);                    
    mapOptions = {
    center: latlon,
    zoom: 15
    };
}

function initialize() {                    
    var mapahome = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);                        
    var map = new google.maps.Map(document.getElementById('map-canvas-completo'), mapOptions);                        
    var marker = new google.maps.Marker({position:latlon,map:map,title:"You are here!"});                  
}

//navigator.geolocation.getCurrentPosition(showPosition);
//google.maps.event.addDomListener(window, 'load', initialize);





