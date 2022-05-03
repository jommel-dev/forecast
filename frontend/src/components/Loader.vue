<template>
  <div class="loader text-center">
    <i class="fa fa-snowflake fa-spin"></i>
  </div>
</template>

<script>
export default {
  name: "AppLoader",
  setup() {},
};
</script>

<style scoped>
.loader {
  position: relative;
  margin-top: 50px;
}

.loader i {
  font-size: 4em;
  color: #339bf6;
}
</style>
