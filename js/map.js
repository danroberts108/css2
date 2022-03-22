// generate 300 random points features
const getRandomNumber = function (min, ref) {
    return Math.random() * ref + min;
}
const features = [];
for (i = 0; i < 300; i++) {
    features.push(new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.fromLonLat([
            -getRandomNumber(50, 50), getRandomNumber(10, 50)
        ]))
    }));
}
// create the source and layer for random features
const vectorSource = new ol.source.Vector({
    features
});
const vectorLayer = new ol.layer.Vector({
    source: vectorSource,
    style: new ol.style.Style({
        image: new ol.style.Circle({
            radius: 2,
            fill: new ol.style.Fill({color: 'red'})
        })
    })
});

const map = new ol.Map({
    target: 'map',
    layers: [
        new ol.layer.Tile({
            source: new ol.source.OSM()
        }),
        vectorLayer
    ],
    view: new ol.View({
        center: ol.proj.fromLonLat([37.41, 8.82]),
        zoom: 0
    })
});