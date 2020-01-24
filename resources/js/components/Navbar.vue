<template>
  <div>
    <b-navbar type="dark" variant="info">
      <b-navbar-brand :to="'/home'" class="mr-5 pr-5">Pharma</b-navbar-brand>
      <b-navbar-nav class="mx-5 pr-5"></b-navbar-nav>
      <b-navbar-nav class="ml-5 pl-5">
        <b-nav-item :to="'/home'">Home</b-nav-item>
        <b-nav-item :to="'/categories'">Categories</b-nav-item>
        <b-nav-item :to="'/commands'">Commands</b-nav-item>
        <b-nav-item :to="'/products'">Products</b-nav-item>
      </b-navbar-nav>
    </b-navbar>
  </div>
</template>

<script>
export default {
  name: "Navbar"
};
</script>

<style lang="scss" scoped>
</style>
