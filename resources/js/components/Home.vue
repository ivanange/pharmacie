<template>
  <div class="d-flex justify-content-center align-content-center h-100">
    <router-link
      :to="'/categories'"
      class="d-block bg-light text-center m-3 font-weight-light"
      style="width: 300px; height: 300px;"
    >Categories</router-link>
    <router-link
      :to="'/commands'"
      class="d-block bg-light text-center m-3 font-weight-light"
      style="width: 300px; height: 300px;"
    >Commands</router-link>
    <router-link
      :to="'/products'"
      class="d-block bg-light text-center m-3 font-weight-light"
      style="width: 300px; height: 300px;"
    >Products</router-link>
  </div>
</template>

<script>
export default {
  name: "Home"
};
</script>

<style lang="scss" scoped>
</style>
