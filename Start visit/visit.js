var layer = new ol.layer.Tile({
    source: new ol.source.OSM(),
    noWrap: true,
    wrapX: false,
    preload: 10
});

var center = ol.proj.transform(
    [lng1,lat1],
    'EPSG:4326',
    'EPSG:3857'
);

var view = new ol.View({
    /* La mappa è centrata sulla posizione della prima opera */
    center: center,
    zoom: 16
});


var map = new ol.Map({
    renderer: 'canvas',
    target: 'map',
    layers: [layer],
    view: view
});


var Markers = [ {lng:lng1 , lat:lat1, name:art1, author: aut1}, 
                {lng:lng2 , lat:lat2, name:art2, author: aut2}, 
                {lng:lng3 , lat:lat3, name:art3, author: aut3}, 
                {lng:lng4 , lat:lat4, name:art4, author: aut4},
                {lng:lng5 , lat:lat5, name:art5, author: aut5},
                {lng:lng6 , lat:lat6, name:art6, author: aut6},
                {lng:lng7 , lat:lat7, name:art7, author: aut7}, 
              ]
var features = []
for (var i = 0 ; i < Markers.length; i++) {
    var item = Markers[i]
    var longitude = item.lng
    var latitude = item.lat
    var name = item.name
    var author = item.author

    var iconFeature = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.transform([longitude, latitude], 'EPSG:4326', 'EPSG:3857')),
        name: name,
        author: author
    })

    var iconStyle = new ol.style.Style({
        image: new ol.style.Icon(({
        anchor: [0.5, 1],
        src: "map-marker.png",
        scale: 0.09
    }))
});          

    iconFeature.setStyle(iconStyle);
    features.push(iconFeature);
}

var vectorSource = new ol.source.Vector({
features: features
});

var vectorLayer = new ol.layer.Vector({
    source: vectorSource
});
map.addLayer(vectorLayer);


var checkbox = document.querySelector('#checkbox');

checkbox.addEventListener('change', function() {
    var checked = this.checked;
    if (checked !== layer.getVisible()) {
        layer.setVisible(checked);
        // nascondo i markers
        if (!checked) {
            for (var i=0;i<features.length;++i) 
                features[i].setStyle(new ol.style.Style({}))
        }
        // mostro i markers
        else{
            var shown_markers = undefined
            var visit_length = document.getElementById("time").value
            if (visit_length === 'allday')
                shown_markers = features.length 
            else if (visit_length === 'halfday')
                shown_markers = features.length - 3
            else
                shown_markers = features.length - 5

            for (var i=0;i<shown_markers;++i) {
                features[i].setStyle(new ol.style.Style({
                    image: new ol.style.Icon(({
                    anchor: [0.5, 1],
                    src: "map-marker.png",
                    scale: 0.09
                    }))
                }))
            }
        }   
    }
})

function move(lng,lat) {
    var destination = ol.proj.transform([lng, lat],'EPSG:4326','EPSG:3857');
    view.animate({
        center: destination,
        duration: 4000
    })
}

function moveTo(location, done) {
    var duration = 3000;
    var zoom = view.getZoom();
    var parts = 2;
    var called = false;
    function callback(complete) {
        --parts;
        if (called) {
        return;
        }
        if (parts === 0 || !complete) {
        called = true;
        done(complete);
        }
    }
    view.animate({
        center: location,
        duration: duration
    }, callback);
    view.animate({
        zoom: zoom - 1,
        duration: duration / 2
    }, {
        zoom: zoom,
        duration: duration / 2
    }, callback);
}

function tour() {
    var location1 = ol.proj.transform([lng1, lat1],'EPSG:4326','EPSG:3857');
    var location2 = ol.proj.transform([lng2, lat2],'EPSG:4326','EPSG:3857');
    var location3 = ol.proj.transform([lng3, lat3],'EPSG:4326','EPSG:3857');
    var location4 = ol.proj.transform([lng4, lat4],'EPSG:4326','EPSG:3857');
    var location5 = ol.proj.transform([lng5, lat5],'EPSG:4326','EPSG:3857');
    var location6 = ol.proj.transform([lng6, lat6],'EPSG:4326','EPSG:3857');
    var location7 = ol.proj.transform([lng7, lat7],'EPSG:4326','EPSG:3857');

    // imposta la lunghezza dell'itinerario a seconda del tempo che l'utente ha a disposizione
    var visit_length = document.getElementById("time").value
    var locations = undefined
    if(visit_length === 'allday')
        var locations = [location1,location2,location3,location4,location5,location6,location7,location1]
    else if (visit_length == 'halfday')
        var locations = [location1,location2,location3,location4,location1]
    else
        var locations = [location1,location2,location1]

    var index = -1;
    function next(more) {
        if (more) {
        ++index;
        if (index < locations.length) {
            var delay = index === 0 ? 0 : 750;
            setTimeout(function() {
                moveTo(locations[index], next);
            }, delay);
        } else {
            alert('Tour complete');
        }
        } else {
        alert('Tour cancelled');
        }
    }
    next(true);
}        

const overlayContainerElement = document.querySelector('.overlay-container')
const overlayLayer = new ol.Overlay({
    element: overlayContainerElement
})
map.addOverlay(overlayLayer)
const overlayArtworkName = document.getElementById('artworkname')
const overlayAuthorName =  document.getElementById('authorname')

map.on('click', function(e) {
    overlayLayer.setPosition(undefined) 
    map.forEachFeatureAtPixel(e.pixel, function(feature, layer) {
        let clickedCoordinate = e.coordinate
        let clickedArtworkName = feature.get('name')  
        let clickedAuthorName  = feature.get('author')
        overlayLayer.setPosition(clickedCoordinate)
        overlayArtworkName.innerHTML = clickedArtworkName
        overlayAuthorName.innerHTML = clickedAuthorName
    })
})


function reduce_visit() {
    var visit_length = document.getElementById("time").value;

    var hidden_buttons = undefined
    var hidden_artworks = undefined
    var hidden_markers = undefined

    // mostro tutti gli elementi
    if (visit_length === 'allday') {
        hidden_artworks = 0
        hidden_buttons  = 0
        hidden_markers  = 0
        // nascondo alcune opere
        for (var i=hidden_artworks+1 ; i<8 ; i++)
            document.getElementById('link' + i).style.visibility = 'visible'
        // disattivo alcuni bottoni
        for (var i=hidden_buttons+1 ; i<8 ; i++)  
            document.getElementById('button' + i).disabled = false
        // nascondo i markers
        for (var i=0;i<features.length;++i) {
            features[i].setStyle(new ol.style.Style({
                image: new ol.style.Icon(({
                anchor: [0.5, 1],
                src: "map-marker.png",
                scale: 0.09
                }))
            }))
        }
    }

    else if (visit_length === 'halfday') {
        hidden_artworks = 4
        hidden_buttons  = 4
        hidden_markers  = 4
        // mostro artwork
        for (var i=1 ; i<=hidden_artworks ; i++)
            document.getElementById('link' + i).style.visibility = 'visible'
        // nascondo artwork
        for (var i=hidden_artworks+1 ; i<8 ; i++)
            document.getElementById('link' + i).style.visibility = 'hidden'

        // attivo bottoni
        for (var i=1 ; i<=hidden_artworks ; i++)  
            document.getElementById('button' + i).disabled = false
        // disattivo bottoni
        for (var i=hidden_buttons+1 ; i<8 ; i++)  
            document.getElementById('button' + i).disabled = true

        // mostra marker
        for (var i=0;i<hidden_markers;++i) {
            features[i].setStyle(new ol.style.Style({
                image: new ol.style.Icon(({
                anchor: [0.5, 1],
                src: "map-marker.png",
                scale: 0.09
                }))
            }))
        }
        // nascondi marker
        for (var i=hidden_markers;i<features.length;++i) 
            features[i].setStyle(new ol.style.Style({}))              
    }

    else if (visit_length === 'couplehours') {
        hidden_artworks = 2
        hidden_buttons  = 2
        hidden_markers  = 2
        // nascondo artwork
        for (var i=hidden_artworks+1 ; i<8 ; i++)
            document.getElementById('link' + i).style.visibility = 'hidden'
        // disabilito i bottoni
        for (var i=hidden_buttons+1 ; i<8 ; i++)  
            document.getElementById('button' + i).disabled = true
        // nascondo alcuni marker
        for (var i=hidden_markers;i<features.length;++i) 
            features[i].setStyle(new ol.style.Style({})) 
    }

    return true
}


function disable_buttons_for_non_loggedin_user() {
    if (!logged_user) {
        document.getElementById('divAccount').style.visibility = 'hidden'
        document.getElementById('menu').style.visibility = 'hidden'
        document.getElementById('fe2').style.visibility = 'hidden'
    } else {
        document.getElementById('divAccount').style.visibility = 'visible'
        document.getElementById('menu').style.visibility = 'visible'
    } 
    return true
}

function back_to_home() {
    console.log('click')
    if(logged_user)     window.location.replace('../WelcomeHomePage/WelcomeHomePage.html')
    else                window.location.replace('../Homepage/homePage.html') 
}