<script setup>
import {computed, onMounted, ref} from "vue";
import {useStore} from "vuex";
import DateText from "../Components/DateText.vue";
import TimeText from "../Components/TimeText.vue";
import SvgCalendar from "../Components/SvgCalendar.vue";
import SvgTime from "../Components/SvgTime.vue";
import SvgPeople from "../Components/SvgPeople.vue";
import SvgRoad from "../Components/SvgRoad.vue";
import SvgDuration from "../Components/SvgDuration.vue";
import SidebarRow from "../Components/SidebarRow.vue";
import SquareFigure from "../Components/SquareFigure.vue";
import CarsDiv from "./Partials/Cars.vue";

import {useI18n} from "vue-i18n";
const { t } = useI18n();
import CustomContentLoader from "../Components/CustomContentLoader.vue";
import SidebarHeader from "../Components/SidebarHeader.vue";
import MainContainer from "../Layouts/MainContainer.vue";

const store = useStore();

const data = computed(() => {
  return store.getters['getFormData']
})

const distance = ref("");
const distance1 = ref("");
const distance3 = ref("");
const duration = ref("");
const total = ref(0);

const isLoading = ref(true);

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
    center: {lat: centerLat, lng: centerLng},
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

  const markers = [
    {position: {lat: coordinates[0]['lat'], lng: coordinates[0]['lng']}, label: data.value.city_from},
    {
      position: {lat: coordinates[coordinates.length - 1]['lat'], lng: coordinates[coordinates.length - 1]['lng']},
      label: data.value.city_to
    }
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


const passengersText = computed(()=>{
    return data.adults > 1 ? t('PASSENGER') : t('PASSENGER');
})

const cars = computed(() => {
    return store.getters['getCars'];
})


onMounted(async () => {

  if (Object.keys(data.value).length > 0) {
    const response = await axios.get('/api/distanceDuration', {params: data.value});

    await store.dispatch('getCars');

      if (response.data) {
      distance.value = response.data.distance;
      distance1.value = response.data.distance1;
      distance3.value = response.data.distance3;
      duration.value = response.data.duration;
      total.value = response.data.total;
    }

    const responseCoordinates = await axios.get('/api/coordinates', {params: data.value});
    if (responseCoordinates.data) {
      initMap(responseCoordinates.data.coordinates);
      isLoading.value = false;
    }

  }

})
</script>

<template>
    <MainContainer>
        <div class="col-md-5 col-lg-4 sidebar d-flex flex-column mb-4">

            <CustomContentLoader v-if="isLoading"/>

            <div v-if="!isLoading" class="sidebar-new sidebar-white">
                <SidebarHeader class="text-black">{{$t('Your transfer')}}</SidebarHeader>
                <hr>

                <SidebarRow>
                    <SquareFigure/>
                    <div class="route_line">-</div>
                    <div class="route_line_fix">-</div>
                    <template #second>
                        <strong>{{data.address_from}}</strong>
                    </template>
                </SidebarRow>

                <SidebarRow>
                    <SquareFigure/>
                    <template #second>
                        <strong>{{data.address_to}}</strong>
                    </template>
                </SidebarRow>

                <SidebarRow>
                    <SvgCalendar/>
                    <template #second>
                        <DateText :date="data.meeting_date"/>
                    </template>
                </SidebarRow>

                <SidebarRow>
                    <SvgTime/>
                    <template #second>
                        <TimeText :time="data.meeting_time"/>
                    </template>
                </SidebarRow>

                <hr>

                <SidebarRow>
                    <SvgPeople/>
                    <template #second>
                        {{data.adults}} {{passengersText}}
                    </template>
                </SidebarRow>

                <SidebarRow>
                    <SvgRoad/>
                    <template #second>
                        {{distance}}
                    </template>
                </SidebarRow>

                <SidebarRow>
                    <SvgDuration/>
                    <template #second>
                        {{duration}}
                    </template>
                </SidebarRow>

            </div>

        </div>
        <div class="col-md-7 col-lg-8">
            <div id="map"></div>

            <div class="row">
                <div class="col">
                    <CarsDiv v-if="!isLoading"
                             :km_to_location_1="distance1" :km_to_location_2="distance" :km_to_location_3="distance3"
                             :total="total" :data="data"  :cars="cars" :distance="distance" :duration="duration"></CarsDiv>
                </div>
            </div>

        </div>
    </MainContainer>
</template>

<style scoped>
#map {
  height: 600px;
  width: 100%;
}

.route_line{
    border-left: 2px solid #212121;
    margin-top: 1px;
    color: #fff;
    margin-left: 4.5px;
    height: 0%; /* Start at 0% height */
    -webkit-animation: increase 4s infinite forwards; /* Repeat the animation infinitely */
    -moz-animation: increase 4s infinite forwards;
    -o-animation: increase 4s infinite forwards;
    animation: increase 4s infinite forwards; /* Repeat the animation infinitely */
    z-index: 9;
}

.route_line_fix {
    margin-top: 1px;
    color: #fff;
    margin-left: 14px;
    position: absolute;
    z-index: 1;
    height: 80px; /* Full height */
    opacity: 0; /* Start as hidden */
    transition: opacity 1s ease; /* Transition to fade in after animation */
}

@keyframes increase {
    0% {
        height: 0%;
    }
    100% {
        height: 50px;
    }
}

.col-1:hover .route_line_fix {
    opacity: 1; /* Make it visible when hover or after animation */
}

</style>
