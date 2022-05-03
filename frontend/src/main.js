import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import { dragscrollNext } from "vue-dragscroll";

const app = createApp(App);

app.directive("dragscroll", dragscrollNext);
app.use(store).use(router).mount("#app");
