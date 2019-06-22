<template>
  <div>
    <v-toolbar class="grey lighten-4 pt-1 pb-1" v-if="signedIn" app flat dense>
      <v-list-tile-action class="hidden-md-and-down">
        <v-btn id="hamburgerMenu" flat class="black" @click.stop="mini = !mini">
          <v-icon small color="white">fas fa-bars</v-icon>
        </v-btn>
      </v-list-tile-action>

      <v-list-tile-action class="hidden-lg-and-up">
        <v-btn id="hamburgerMenu" flat class="black" @click.stop="drawer = !drawer">
          <v-icon small color="white">fas fa-bars</v-icon>
        </v-btn>
      </v-list-tile-action>

      <v-spacer></v-spacer>

      <v-toolbar-items class="hidden-md-and-down">
        <v-btn flat to="/admin/signout" color="red">Sign Out</v-btn>
      </v-toolbar-items>
    </v-toolbar>

    <v-navigation-drawer
      class="black"
      v-model="drawer"
      :mini-variant="mini"
      v-if="signedIn"
      dark
      app
    >
      <v-toolbar flat class="transparent pt-1 pb-1" dense>
        <v-list class="pa-0">
          <v-list-tile>
            <v-list-tile-avatar v-if="mini">
              <router-link to="/admin/">
                <img
                  src="/images/icons/wlogo.png"
                  alt
                  style="height: 3rem; width: 3rem; margin-top: 0.5rem;"
                >
              </router-link>
            </v-list-tile-avatar>

            <v-list-tile-content>
              <router-link to="/admin/">
                <img src="/images/icons/pcmodz-logo.png" alt>
              </router-link>
            </v-list-tile-content>

            <v-list-tile-action v-if="!mini" class="hidden-lg-and-up">
              <v-tooltip right>
                <template v-slot:activator="{ on }">
                  <v-btn id="hamburgerMenu" v-on="on" flat class="black" @click.stop="mini = !mini">
                    <v-icon small color="white">fas fa-compress</v-icon>
                  </v-btn>
                </template>
                <span>Minimize</span>
              </v-tooltip>
            </v-list-tile-action>
          </v-list-tile>
        </v-list>
      </v-toolbar>

      <v-list class="pa-0" dense two-line>
        <v-divider></v-divider>
        <v-card v-if="!mini" class="text-xs-center black pa-3" id="sidebar_profile">
          <v-list-tile-avatar class="mb-3" size="100">
            <img src="/images/icons/wlogo.png" alt>
          </v-list-tile-avatar>
          <h3>{{ admin.name }}</h3>
          <h5>Administrator</h5>
        </v-card>

        <v-card v-else class="text-xs-center black pa-3">
          <v-list-tile-avatar>
            <img src="/images/icons/wlogo.png" alt>
          </v-list-tile-avatar>
        </v-card>
        <v-divider></v-divider>

        <v-list-tile v-if="mini" class="hidden-lg-and-up">
          <v-list-tile-action>
            <v-tooltip right>
              <template v-slot:activator="{ on }">
                <v-btn id="hamburgerMenu" v-on="on" flat class="black" @click.stop="mini = !mini">
                  <v-icon small color="white">fas fa-expand</v-icon>
                </v-btn>
              </template>
              <span>Maximize</span>
            </v-tooltip>
          </v-list-tile-action>
        </v-list-tile>

        <v-list-tile v-for="item in items" :key="item.title" @click="navigate(item)">
          <v-tooltip right>
            <template v-slot:activator="{ on }">
              <v-list-tile-action v-on="on">
                <v-icon>{{ item.icon }}</v-icon>
              </v-list-tile-action>
            </template>
            <span>{{ item.title }}</span>
          </v-tooltip>

          <v-list-tile-content>
            <v-list-tile-title>{{ item.title }}</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>
  </div>
</template>

<script>
export default {
  data() {
    return {
      drawer: true,
      mini: false,
      items: [
        {
          title: "Dashboard",
          icon: "far fa-chart-bar",
          route: "/admin/"
        },
        { title: "Inventory", icon: "fas fa-boxes", route: "/admin/inventory" },
        {
          title: "Categories",
          icon: "fas fa-layer-group",
          route: "/admin/categories"
        },
        {
          title: "Orders",
          icon: "fas fa-cart-arrow-down",
          route: "/admin/orders"
        },
        { title: "Sales", icon: "fas fa-chart-line", route: "/admin/sales" },
        {
          title: "Reports",
          icon: "fas fa-file-invoice-dollar",
          route: "/admin/reports"
        }
      ]
    };
  },
  created() {
    this.$store.dispatch("fetchAdmin");
  },
  methods: {
    navigate(route) {
      this.$router.push(route.route);
    }
  },
  computed: {
    signedIn() {
      return this.$store.state.token_admin;
    },
    admin() {
      return this.$store.state.admin;
    }
  }
};
</script>

<style scoped>
#hamburgerMenu {
  min-width: 0;
  padding-left: 1rem;
  padding-right: 1rem;
}

#sidebar_profile {
  display: grid;
  justify-items: center;
}

#sidebar_profile img {
  border: 1px solid white;
}

.v-toolbar img {
  width: 15rem;
  margin-top: 0.5rem;
}

/* .v-toolbar img {
  height: 3rem;
  width: 3rem;
  margin-top: 0.5rem;
} */

.v-toolbar a {
  text-decoration: none;
  font-weight: bold;
  color: white;
}
</style>


