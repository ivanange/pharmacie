<template>
  <div class="d-flex">
    <span>{{article.product.name}}</span>
    <span>{{article.qte}}</span>
    <!-- <span>{{article.total}}</span> -->
    <span v-on:click="$emit('remove', article.product.id)" class="ml-auto">X</span>
  </div>
</template>

<script>
export default {
  name: "Article",
  props: {
    article: {
      type: Object,
      required: true,
      default: function() {
        return {};
      }
    }
  }
};
</script>

<style lang="scss" scoped>
</style>
