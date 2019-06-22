<template>
  <div>
    <h1 class="text-xs-center">Build Your Own!</h1>
  </div>
</template>

<script>
export default {
  created() {
    this.load_main();
  },
  methods: {
    load_main() {
      this.$store.dispatch("load_main");
    }
  }
};
</script>
