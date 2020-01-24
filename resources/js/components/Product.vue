
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
          title: "Products"
      };
  },
  methods: {
    updateSearchList() {
      this.$store.commit("setList", this.productList);
    }
  },
  created: function() {
    this.updateSearchList();
  },
  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.updateSearchList();
    });
  }
};
</script>

<style lang="scss" scoped>
</style>
