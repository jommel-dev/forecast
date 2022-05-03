<template>
  <div>
    <div class="container-fluid">
      <div class="row">
        <!-- Search Venue -->
        <div class="col-md-12">
          <div class="accordion" id="accordionExample">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
                <button
                  class="accordion-button"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#collapseOne"
                  aria-expanded="true"
                  aria-controls="collapseOne"
                >
                  Search For Venue (Japan Range Only)
                </button>
              </h2>
              <div
                id="collapseOne"
                class="accordion-collapse collapse"
                aria-labelledby="headingOne"
                data-bs-parent="#accordionExample"
              >
                <div class="accordion-body">
                  <div class="row">
                    <div class="col col-xs-12 col-md-12">
                      <div class="input-group">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="ex: Tokyo"
                          aria-label="Recipient's username"
                          aria-describedby="button-addon2"
                          v-model="searchQuery"
                        />
                        <button
                          class="btn btn-outline-secondary"
                          type="button"
                          @click="searchVenue"
                          id="button-addon2"
                        >
                          <span
                            v-if="btnSearchLoad"
                            class="spinner-grow spinner-grow-sm"
                            role="status"
                            aria-hidden="true"
                          ></span>
                          Search
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Map Display -->
        <div class="col-md-12">
          <div class="map-container" ref="myMap"></div>
        </div>
        <!-- Cities Navigation -->
        <div class="col-md-12">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li
              v-for="(citi, key) in cities"
              :key="key"
              class="nav-item"
              role="presentation"
            >
              <button
                class="nav-link"
                :class="citi == cityName ? `active` : ``"
                :id="`${citi.toLowerCase()}-tab`"
                data-bs-toggle="tab"
                type="button"
                role="tab"
                @click="getWeather(citi)"
                aria-selected="true"
              >
                {{ citi }}
              </button>
            </li>
          </ul>
        </div>
        <!-- Legend -->
        <div class="col col-xs-2 col-md-1">
          <table class="table legend">
            <tbody>
              <tr>
                <td>Date</td>
              </tr>
              <tr>
                <td class="minFont text-end">
                  Hours <i class="bi bi-watch"></i>
                </td>
              </tr>
              <tr>
                <td></td>
              </tr>
              <tr>
                <td class="minFont marginTop-1 text-end">
                  Temperature <i class="bi bi-thermometer-sun"></i>
                </td>
              </tr>
              <tr>
                <td class="minFont marginTop-1 text-end">
                  Wind Speed <i class="bi bi-wind"></i>
                </td>
              </tr>
              <tr>
                <td class="minFont marginTop-1 text-end">
                  Wind Dir. <i class="bi bi-compass-fill"></i>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- Forecast -->
        <div
          class="col col-xs-10 col-md-9 grab-bing"
          style="overflow: auto"
          v-dragscroll
        >
          <Loader v-if="showLoading" />

          <table v-show="!showLoading" class="table fctable">
            <thead>
              <tr>
                <td
                  v-for="(dl, key) in dateList"
                  :key="key"
                  :colspan="colSpans(dl)"
                >
                  {{ dl }}
                </td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td
                  v-for="(ts, key) in weatherList"
                  :key="key"
                  :data-ts="ts.dt"
                  class="minFont"
                >
                  {{ moment(ts.dt_txt).format("hA") }}
                </td>
              </tr>
              <tr>
                <td v-for="(iconWeather, key) in weatherList" :key="key">
                  <!-- {{ iconWeather.weather[0].main }} -->
                  <img
                    class="weatherIcon"
                    :alt="iconWeather.weather[0].description"
                    :src="getIcon(iconWeather.weather[0].icon)"
                  />
                </td>
              </tr>
              <tr>
                <td
                  class="minFont"
                  v-for="(temp, key) in weatherList"
                  :key="key"
                >
                  {{ kelvinToCelcus(temp.main.temp) }}
                </td>
              </tr>
              <tr>
                <td class="minFont" v-for="(w, key) in weatherList" :key="key">
                  {{ `${w.wind.speed}` }}
                </td>
              </tr>
              <tr>
                <td
                  class="text-center"
                  v-for="(deg, key) in weatherList"
                  :key="key"
                >
                  <div
                    :style="[
                      { transform: `rotate(${deg.wind.deg}deg)` },
                      { '-webkit-transform': `rotate(${deg.wind.deg}deg)` },
                    ]"
                  >
                    <i class="bi bi-caret-up-fill"></i>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- About Location -->
        <div class="col-md-2">
          <div class="alert alert-info marginTop-1" role="alert">
            <h6 class="alert-heading">About Location</h6>
            <span>{{ `City: ${cityName}` }}</span>
            <hr />
            <span>{{
              `Sunset: ${moment(cityData.sunset).format("hh:mm A")}`
            }}</span>
            <br />
            <span>{{
              `Sunrise: ${moment(cityData.sunrise).format("hh:mm A")}`
            }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import Loader from "./Loader.vue";
import maplibre from "maplibre-gl";

export default {
  name: "HomePage",
  components: {
    Loader,
  },
  data() {
    return {
      cities: ["Tokyo", "Yokohama", "Kyoto", "Osaka", "Sapporo", "Nagoya"],
      cityName: "Tokyo",
      countyCode: "JP",
      weatherList: [],
      cityData: {},
      dateList: [],
      collected: [],
      showLoading: false,
      iconLink: "http://openweathermap.org/img/wn/<icon>@2x.png",
      mapKey: "",
      btnSearchLoad: false,
      searchQuery: "",
      initMapState: {
        lng: 139.6917,
        lat: 35.6895,
        zoom: 4,
      },
    };
  },
  watch: {
    cityName: function (val) {
      if (val) {
        this.getForecast();
      }
    },
  },
  created() {
    this.getForecast();
  },
  mounted() {
    this.initMap();
  },
  methods: {
    moment,
    initMap() {
      const map = new maplibre.Map({
        container: this.$refs.myMap,
        style: `${this.mapComponent.apiMapBaseUrl}?apiKey=${this.mapComponent.apiMapKey}`,
        center: [this.initMapState.lng, this.initMapState.lat],
        zoom: this.initMapState.zoom,
      });

      const markerPopup = new maplibre.Popup().setText(this.searchQuery);
      new maplibre.Marker()
        .setLngLat([this.initMapState.lng, this.initMapState.lat])
        .setPopup(markerPopup)
        .addTo(map);
    },
    colSpans(tdDate) {
      let count = this.collected.filter((el) => {
        return el == tdDate;
      });
      return count.length;
    },
    getIcon(iconName) {
      let url = this.iconLink.replace("<icon>", iconName);
      // console.log(url);
      return url;
    },
    kelvinToCelcus(temperature) {
      var fTemp = temperature;
      var kToCel = Number(fTemp) - 273.15;
      var final = kToCel.toFixed(2) + "\xB0C";

      return final;
    },
    getWeather(val) {
      this.cityName = val;
    },
    async searchVenue() {
      let vm = this;
      vm.btnSearchLoad = true;
      let payload = {
        query: this.searchQuery,
      };

      vm.$store.dispatch("getSearchQuery", payload).then((res) => {
        let data = res.data.results;
        if (data.length > 0) {
          this.initMapState.lat = data[0].lat;
          this.initMapState.lng = data[0].lon;
          this.initMapState.zoom = 6;
          this.cityName = data[0].city;
          this.$nextTick(() => {
            this.initMap();
          });
        }
        vm.btnSearchLoad = false;
      });
    },
    async getForecast() {
      let vm = this;
      vm.showLoading = true;
      // This is the request payload that can be pass to the Backend
      let payload = {
        city_name: vm.cityName,
        country_code: vm.countyCode,
      };

      vm.$store.dispatch("getForecastByCityName", payload).then((res) => {
        let data = res.data;
        if (res.code == 0) {
          this.cityData = data.city;
          this.weatherList = data.list;
          let fcdates = [];
          let colledtedDates = [];
          data.list.forEach((el) => {
            let d = moment(el.dt_txt);
            let dkey = d.format("MM-DD-YYYY");
            if (!fcdates.includes(dkey)) {
              fcdates.push(dkey);
            }
            colledtedDates.push(dkey);
          });
          this.collected = colledtedDates;
          this.dateList = fcdates;
          vm.showLoading = false;
        }
      });
    },
  },
  computed: {
    mapComponent() {
      return this.$store.getters.getMapComponents;
    },
  },
};
</script>

<style scoped>
@import "~maplibre-gl/dist/maplibre-gl.css";

.map-container {
  width: 100%;
  height: 500px;
}

.fctable {
  margin-bottom: 4px !important;
}
.fctable > tbody > tr > td {
  border-bottom: 0px !important;
}
.legend > tbody > tr > td {
  border-bottom: 0px !important;
}
.fctable > tbody {
  background: linear-gradient(90deg, #10b3e4 0%, #318ef3 100%);
}

.minFont {
  font-size: 8pt;
}

.marginTop-1 {
  position: relative;
  top: 40px;
}
.marginTop-2 {
  position: relative;
  top: 45px;
}

.grab-bing {
  cursor: -webkit-grab;
  cursor: -moz-grab;
  cursor: -o-grab;
  cursor: grab;
}

.grab-bing:active {
  cursor: -webkit-grabbing;
  cursor: -moz-grabbing;
  cursor: -o-grabbing;
  cursor: grabbing;
}

.rain-icon {
  color: #54616c;
}
.clouds-icon {
  color: #bddbf4;
}
.clear-icon {
  color: #ecef4d;
}

.col-sm-hidden {
  display: none;
}

.weatherIcon {
  width: 40px;
}

::-webkit-scrollbar {
  width: 0px;
  height: 0px;
}
::-webkit-scrollbar-button {
  width: 0px;
  height: 0px;
}
::-webkit-scrollbar-corner {
  background: transparent;
}
</style>
