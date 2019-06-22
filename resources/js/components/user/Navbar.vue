<template>
  <div>
    <v-toolbar class="black" dark flat app>
      <v-toolbar-side-icon class="hidden-lg-and-up" @click.stop="drawer = !drawer"></v-toolbar-side-icon>
      <v-spacer class="hidden-lg-and-up"></v-spacer>

      <v-toolbar-title>
        <router-link to="/">
          <img src="/images/icons/pcmodz-logo.png" alt>
        </router-link>
      </v-toolbar-title>

      <v-toolbar-items class="hidden-md-and-down" id="nav-items">
        <router-link flat to="/">Home</router-link>
        <router-link flat to="/products">Products</router-link>
        <router-link flat to="/build">Build your own</router-link>
        <router-link flat to="/gallery">Gallery</router-link>
      </v-toolbar-items>

      <v-spacer></v-spacer>

      <v-toolbar-items class="hidden-md-and-down" id="nav-items">
        <router-link flat to="/signin" color="green" v-if="!signedIn">Sign In</router-link>
        <v-menu offset-y v-if="signedIn">
          <template v-slot:activator="{ on }">
            <v-btn flat v-on="on">
              {{ user.name }}
              <v-icon class="ml-2" small>fas fa-caret-down</v-icon>
            </v-btn>
          </template>
          <v-list class="black" dark>
            <v-list-tile to="/profile">
              <v-list-tile-title>Profile</v-list-tile-title>
            </v-list-tile>
            <v-list-tile to="/orders">
              <v-list-tile-title>My Orders</v-list-tile-title>
            </v-list-tile>

            <v-spacer></v-spacer>
            <v-list-tile to="/signout">
              <v-list-tile-title class="red--text">Sign Out</v-list-tile-title>
            </v-list-tile>
          </v-list>
        </v-menu>
        <v-btn flat @click="openCart()">
          <v-badge right>
            <template v-slot:badge>
              <span v-if="cart.length > 0">{{ cart.length }}</span>
            </template>
            <v-icon small class="mt-1 mr-1">fas fa-shopping-cart</v-icon>
          </v-badge>
        </v-btn>
      </v-toolbar-items>
    </v-toolbar>

    <v-navigation-drawer class="black" v-model="drawer" absolute temporary dark app>
      <v-toolbar flat class="transparent">
        <v-list class="pa-0">
          <v-list-tile>
            <v-list-tile-content>
              <router-link to="/">
                <img src="/images/icons/pcmodz-logo.png" alt>
              </router-link>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-toolbar>

      <v-list class="pt-0" dense two-line>
        <v-divider></v-divider>
        <v-list-group prepend-icon="account_circle" no-action v-if="signedIn">
          <template v-slot:activator>
            <v-list-tile>
              <v-list-tile-title>{{ user.name }}</v-list-tile-title>
            </v-list-tile>
          </template>

          <v-list-tile to="/profile">
            <v-list-tile-title>Profile</v-list-tile-title>
          </v-list-tile>
          <v-list-tile to="/orders">
            <v-list-tile-title>My Orders</v-list-tile-title>
          </v-list-tile>
        </v-list-group>

        <v-list-tile v-for="item in items" :key="item.title" @click="navigate(item.route)">
          <v-list-tile-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-tile-action>

          <v-list-tile-content>
            <v-list-tile-title>{{ item.title }}</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>

        <v-list-tile @click="openCart()">
          <v-list-tile-action>
            <v-icon small>fas fa-shopping-cart</v-icon>
          </v-list-tile-action>

          <v-list-tile-content>
            <v-list-tile-title>Open Cart</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>

        <v-list-tile to="/signin" v-if="!signedIn">
          <v-list-tile-action>
            <v-icon small color="green">fas fa-sign-in-alt</v-icon>
          </v-list-tile-action>

          <v-list-tile-content class="green--text">
            <v-list-tile-title>Sign In</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>

        <v-list-tile to="/signin" v-if="signedIn">
          <v-list-tile-action>
            <v-icon small color="red">fas fa-sign-out-alt</v-icon>
          </v-list-tile-action>

          <v-list-tile-content class="red--text">
            <v-list-tile-title>Sign Out</v-list-tile-title>
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
      drawer: null,
      items: [
        { title: "Home", icon: "fas fa-home", route: "/" },
        { title: "Products", icon: "fas fa-desktop", route: "/products" },
        {
          title: "Build Your Own",
          icon: "fas fa-magic",
          route: "/build"
        },
        { title: "Gallery", icon: "fas fa-images", route: "/gallery" }
      ]
    };
  },
  created() {
    this.$store.dispatch("fetchUser");
  },
  methods: {
    navigate(route) {
      this.$router.push(route);
    },
    openCart() {
      this.$store.dispatch("openCart");
    }
  },
  computed: {
    cart() {
      return this.$store.state.cart;
    },
    signedIn() {
      return this.$store.state.token;
    },
    user() {
      return this.$store.state.user;
    }
  }
};
</script>

<style scoped>
.v-toolbar img {
  width: 15rem;
  margin-top: 0.5rem;
}

.v-toolbar .v-toolbar__title a {
  text-decoration: none;
  font-weight: bold;
  color: white;
  margin-right: 1rem;
}

.v-toolbar #nav-items a {
  text-decoration: none;
  font-weight: bold;
  color: white;
  padding-left: 2.5rem;
  padding-right: 2.5rem;
  line-height: 4.1;
  font-size: 16px;
  text-transform: uppercase;
}

.v-toolbar #nav-items a:hover {
  color: #0066cc;
}
</style>


