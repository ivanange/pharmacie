
<template>
  <div>
    <ProductList :proplist="searchResult" />
    <router-view></router-view>
  </div>
</template>

<script>
import ProductList from "./products/ProductList";

export default {
  name: "Product",
  title: "Products",
  components: {
    ProductList
  },
  data: function() {
    return {
    };
  },
  beforeRouteUpdate(to, from, next) {
      if(this.$route.query.category) {
          this.$root.categoryid = this.$route.query.category;
      }
},
created() {
          if(this.$route.query.category) {
          this.$root.categoryid = this.$route.query.category;
      }
}
};
</script>

<style lang="scss" scoped>
</style>
