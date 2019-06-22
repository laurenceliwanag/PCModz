<template>
  <div>
    <v-app v-if="navbar_admin">
      <navbar_admin></navbar_admin>
      <v-content class="grey lighten-4">
        <router-view></router-view>
      </v-content>
      <v_footer_admin></v_footer_admin>
    </v-app>
    <v-app v-else>
      <navbar></navbar>
      <v-content class="grey lighten-4">
        <router-view></router-view>
      </v-content>
      <v_footer></v_footer>
      <cart></cart>
    </v-app>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: {
        email: "",
        password: ""
      }
    };
  },
  computed: {
    navbar_admin() {
      return this.$store.state.navbar_admin;
    }
  }
};
</script>

<style>
.application {
  font-family: "Montserrat";
}

.v-btn {
  font-weight: 600;
}
</style>


