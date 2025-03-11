<script setup>
import {computed, onMounted, ref} from "vue";
import {useStore} from "vuex";
import DateText from "../Components/DateText.vue";
import TimeText from "../Components/Destination/TimeText.vue";
import SvgCalendar from "../Components/Svg/SvgCalendar.vue";
import SvgTime from "../Components/Svg/SvgTime.vue";
import SvgPeople from "../Components/Svg/SvgPeople.vue";
import SvgRoad from "../Components/Svg/SvgRoad.vue";
import SvgSuitcase from "../Components/Svg/SvgSuitcase.vue";
import SvgDuration from "../Components/Svg/SvgDuration.vue";
import SidebarRow from "../Components/SidebarRow.vue";
import SquareFigure from "../Components/SquareFigure.vue";
import CarsDiv from "./Partials/Cars.vue";

import {useI18n} from "vue-i18n";
const { t } = useI18n();
import CustomContentLoader from "../Components/CustomContentLoader.vue";
import SidebarHeader from "../Components/SidebarHeader.vue";
import MainContainer from "../Layouts/MainContainer.vue";
import AboutUs from "./Partials/AboutUs.vue";

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
            "color": "#eeeeee"  // Gray color for geometry (land, water)
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
    {
        position: {lat: coordinates[0]['lat'], lng: coordinates[0]['lng']},
        label: {
            text: data.value.city_from,
            color: "black", // Text color
            fontSize: "22px", // Increase font size
            fontWeight: "bold", // Make text bold
        },
        title: data.value.city_from
    },
    {
      position: {lat: coordinates[coordinates.length - 1]['lat'], lng: coordinates[coordinates.length - 1]['lng']},
        label: {
            text: data.value.city_to,
            color: "black", // Text color
            fontSize: "22px", // Increase font size
            fontWeight: "bold", // Make text bold
        },
        title: data.value.city_to
    }
  ];

  markers.forEach(markerData => {
    new google.maps.Marker({
      position: markerData.position,
      map: map,
      title: markerData.title,
      label: markerData.label,
    });
  });
}


const passengersText = computed(()=>{
    return parseInt(data.value.adults) > 1 ? t('PASSENGERS') : t('PASSENGER');
})

const suitcasesText = computed(()=>{
    return parseInt(data.value.suitcases) > 1 ? t('SUITCASES') : t('SUITCASE');
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
    <div class="cs-white cs-white-d">
        <div class="cs-mid-white">
            <MainContainer>
                <div class="col-md-12 cm-spacer"></div>
                <div class="col-md-5 col-lg-4 sidebar d-flex flex-column border-radius-16">

                    <CustomContentLoader class="bg-white border-radius-16" v-if="isLoading"/>

                    <div v-if="!isLoading" class="sidebar-new sidebar-white">
                        <SidebarHeader class="text-black d-sidebar-header">{{$t('Your transfer')}}</SidebarHeader>
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

                        <div class="row mb-4">
                            <div class="col-12">
                               <span class="fw-bold">{{$t('Date and time')}}:</span>
                            </div>
                        </div>

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
                            <SvgSuitcase/>
                            <template #second>
                                {{data.suitcases}} {{suitcasesText}}
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
                    <div id="map" class="border-radius-16"></div>

                    <div class="row">
                        <div class="col pd-0-25">
                            <CarsDiv v-if="!isLoading"
                                     :km_to_location_1="distance1" :km_to_location_2="distance" :km_to_location_3="distance3"
                                     :total="total" :data="data"  :cars="cars" :distance="distance" :duration="duration"></CarsDiv>
                        </div>
                    </div>

                </div>
            </MainContainer>

            <AboutUs/>

        </div>
    </div>

</template>
