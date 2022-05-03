import axios from "axios";
import CallBacks from "../../helper/ModuleHelper";

const base = "forecast";

export default {
  namespace: true,
  actions: {
    async getForecastByCityName({ rootState }, payload) {
      let response = {};
      let url = `${rootState.apiBaseUrl}/${base}/getByCityName`;
      await axios
        .post(url, payload)
        .then((res) => {
          response = CallBacks.thenCallBack(res);
        })
        .catch((error) => {
          response = CallBacks.catchCallBack(error);
        });

      return response;
    },
    async getSearchQuery({ rootState }, payload) {
      let response = {};
      let url = `${rootState.apiBaseUrl}/${base}/getMapsLocation`;
      await axios
        .post(url, payload)
        .then((res) => {
          response = CallBacks.thenCallBack(res);
        })
        .catch((error) => {
          response = CallBacks.catchCallBack(error);
        });

      return response;
    },
  },
};
