<template></template>

<script>
export default {
  created() {
    this.$store.dispatch("destroyToken_admin").then(response => {
      this.$router.push("/admin/signin");
    });
  }
};
</script>
