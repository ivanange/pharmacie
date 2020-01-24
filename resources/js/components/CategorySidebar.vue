<template>
  <div class="d-flex flex-column">
    <form action="#searchList.php" method="post" class="filter-form bg-light py-4 px-3">
      <div class="d-flex justify-content-center align-concent-center px-2">
        <input
          v-model="filters.name"
          class="form-control rounded"
          type="search"
          placeholder="category name, articles"
          style="max-width: 600px;"
        />
      </div>
    </form>
    <div class="text-center my-2">
      <font-awesome-icon
        class="w-auto mx-auto h1"
        icon="plus-circle"
        style="color: var(--info);"
        @click.stop="$router.push('/categories/create')"
      />
    </div>
  </div>
</template>

<script>
import { debounce } from "lodash";
export default {
  name: "CategorySidebar",
  data: function() {
    return {
      filters: {
        name: ""
      },
      result: []
    };
  },
  watch: {
    filters: {
      handler: function() {
        this.update();
      },
      deep: true,
      immediate: true
    }
  },

  methods: {
    update: debounce(function() {
      let result = this.search();
      this.$store.commit("setList", result);
    }, 1500),

    search() {
      return this.categoryList.filter(
        category =>
          (category.name + category.desc)
            .toLowerCase()
            .indexOf(this.filters.name.toLowerCase()) !== -1
      );
    }
  }
};
</script>

<style lang="scss" scoped>
</style>
