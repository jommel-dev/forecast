import { createStore } from "vuex";
import forecast from "./modules/forecast";

export default createStore({
  state: {
    apiBaseUrl: "http://127.0.0.1:8001/api",
    mapComo: {
      apiMapBaseUrl:
        "https://maps.geoapify.com/v1/styles/klokantech-basic/style.json",
      apiMapKey: "66015edd6e0b42bda9036fcdb34bf8cb",
    },
  },
  getters: {
    getMapComponents: function (state) {
      return state.mapComo;
    },
  },
  mutations: {},
  actions: {},
  modules: {
    forecast,
  },
});
