const map = L.map('map').setView([40.705315, -73.928369], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
	attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
	maxZoom: 19
}).addTo(map);

L.geoJSON(ownersGeoJSON).addTo(map);

// TODO - can use the code below for more refined styling...

// // Adapted from https://gist.github.com/geog4046instructor/80ee78db60862ede74eacba220809b64
// function createCustomIcon (feature, latlng) {
//   let myIcon = L.icon({
//     iconUrl: 'blue-dot.png',
//     iconSize:     [10, 10], // width and height of the image in pixels
//     iconAnchor:   [0, 0], // point of the icon which will correspond to marker's location
//   })
//   return L.marker(latlng, { icon: myIcon })
// }

// // create an options object that specifies which function will called on each feature
// const options = {
//   pointToLayer: createCustomIcon
// }

// L.geoJSON(ownersGeoJSON, options).addTo(map);
