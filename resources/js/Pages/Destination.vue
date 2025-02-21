<script setup>

import {computed, onMounted, ref} from "vue";
import {useStore} from "vuex";

const store = useStore();

const data = computed(() => {
  return store.getters['getFormData']
})

const distance = ref("");
const distance1 = ref("");
const distance3 = ref("");
const duration = ref("");
const total = ref(0);

function initMap(coordinates) {
  let sumLat = 0;
  let sumLng = 0;

  coordinates.forEach(coord => {
    sumLat += coord.lat;
    sumLng += coord.lng;
  });

  const centerLat = sumLat / coordinates.length;
  const centerLng = sumLng / coordinates.length;

  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 5,
    center: { lat: centerLat, lng: centerLng},
    mapTypeId: "terrain",
    styles: [
      {
        "elementType": "geometry",
        "stylers": [
          {
            "color": "#56AE45"  // Gray color for geometry (land, water)
          }
        ]
      },
      {
        "elementType": "labels.icon",
        "stylers": [
          {
            "visibility": "off"  // Hide map icons
          }
        ]
      },
      {
        "elementType": "labels.text.fill",
        "stylers": [
          {
            "color": "#000"  // Dark gray for text
          }
        ]
      },
      {
        "featureType": "administrative.land_parcel",
        "elementType": "labels.text.fill",
        "stylers": [
          {
            "color": "#bdbdbd"  // Light gray text for land parcel labels
          }
        ]
      },
      {
        "featureType": "poi",
        "elementType": "labels.text.fill",
        "stylers": [
          {
            "color": "#9e9e9e"  // Light gray for points of interest labels
          }
        ]
      },
      {
        "featureType": "road",
        "elementType": "geometry",
        "stylers": [
          {
            "color": "#424242"  // Dark gray roads
          }
        ]
      },
      {
        "featureType": "road",
        "elementType": "labels.text.fill",
        "stylers": [
          {
            "color": "#9e9e9e"  // Light gray text for road labels
          }
        ]
      },
      {
        "featureType": "transit",
        "elementType": "geometry",
        "stylers": [
          {
            "color": "#757575"  // Dark gray for transit lines
          }
        ]
      },
      {
        "featureType": "water",
        "elementType": "geometry",
        "stylers": [
          {
            "color": "#89CFF0"  // Blue for water bodies
          }
        ]
      }
    ]
  });

  const path = new google.maps.Polyline({
    path: coordinates,
    geodesic: true,
    strokeColor: "#000",
    strokeOpacity: 1.0,
    strokeWeight: 2,
  });

  path.setMap(map);

  console.log(data.value);


  const markers = [
    { position: { lat: coordinates[0]['lat'], lng: coordinates[0]['lng'] }, label: data.value.city_from },
    { position: { lat: coordinates[coordinates.length-1]['lat'], lng: coordinates[coordinates.length-1]['lng']}, label: data.value.city_to }
  ];

  markers.forEach(markerData => {
    new google.maps.Marker({
      position: markerData.position,
      map: map,
      title: markerData.label,
      label: markerData.label,
    });
  });
}

onMounted(async () => {

  if (Object.keys(data.value).length > 0) {
    const response =  await axios.get('/api/distanceDuration', {params:data.value});
    if (response.data) {
      distance.value = response.data.distance;
      distance1.value = response.data.distance1;
      distance3.value = response.data.distance3;
      duration.value = response.data.duration;
      total.value = response.data.total;
    }

    const responseCoordinates =  await axios.get('/api/coordinates', {params:data.value});
    if (responseCoordinates.data) {
      initMap(responseCoordinates.data.coordinates);
    }
  }

})

</script>

<template>
  <div class="row text-white">

    <div class="col-md-12 col-lg-12 d-flex justify-content-center">
      <div id="map"></div>
    </div>

    <div v-if="distance" class="col-md-12 col-lg-12">
      <div>Distance = {{distance}}</div>
    </div>


    <div v-if="distance1" class="col-md-12 col-lg-12">
      <div>From HA to A = {{distance1}}</div>
    </div>


    <div v-if="distance3" class="col-md-12 col-lg-12">
      <div>From B to HA = {{distance3}}</div>
    </div>

    <div v-if="duration" class="col-md-12 col-lg-12">
      <div>Duration = {{duration}}</div>
    </div>


    <div v-if="total" class="col-md-12 col-lg-12">
      <div>Total = {{total}}</div>
    </div>

  </div>
</template>

<style scoped>
#map{
  height: 600px;
  width: 600px;
}
</style>
