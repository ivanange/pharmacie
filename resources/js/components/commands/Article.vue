<template>
  <div class="d-flex">
    <span class="d-inline-block mx-2">{{article.product.name}}</span>
    <span class="d-inline-block mx-2">{{article.qte}}</span>
    <span class="d-inline-block mx-2">{{total}}</span>
    <span class="mr-3 ml-auto" @click="close" v-if="deleteButton">
      <font-awesome-icon icon="minus-circle" style="color: var(--red);" />
    </span>
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
    },
    deleteButton: {
        type: Boolean,
        default: true
    }
  },
  computed: {
    total: function() {
      return (this.article.product.price * this.article.qte).toFixed(2);
    }
  },
  methods: {
    close() {
      this.$emit("remove", this.article.product.id);
      this.$destroy();
    }
  }
};
</script>

<style lang="scss" scoped>
</style>
