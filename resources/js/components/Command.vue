
<template>
  <div>
    <CommandList :proplist="searchResult" />
    <router-view></router-view>
  </div>
</template>

<script>
import CommandList from "./commands/CommandList";

export default {
  name: "Command",
  title: "Commands",
  components: {
    CommandList
  },
  data: function() {
    return {
    };
  },
  methods: {
    updateSearchList() {
      this.$store.commit("setList", this.commandList);
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
