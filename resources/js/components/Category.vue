
<template>
  <div>
    <CategoryList :proplist="searchResult" />
    <router-view></router-view>
  </div>
</template>

<script>
import CategoryList from "./categories/CategoryList";

export default {
  name: "Category",
  title: "Categories",
  components: {
    CategoryList
  },
  data: function() {
    return {
    };
  },
  methods: {
    updateSearchList() {
      this.$store.commit("setList", this.categoryList);
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
