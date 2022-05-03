<template>
  <div>
    <!--Navbar-->
    <nav class="navbar navbar-dark bg-primary">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">JPN Simple Weather Forecast</a>
      </div>
    </nav>

    <ForecastHome />
  </div>
</template>

<script>
// @ is an alias to /src
import ForecastHome from "@/components/ForecastHome.vue";

export default {
  name: "HomeView",
  components: {
    ForecastHome,
  },
};
</script>
