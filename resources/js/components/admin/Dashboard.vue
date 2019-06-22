<template>
  <div>
    <v-layout mb-4>
      <v-flex>
        <v-card class="pa-3 pl-4" flat>
          <h1>{{ component_title_admin }}</h1>
        </v-card>
      </v-flex>
    </v-layout>

    <v-layout mb-4>
      <v-flex pl-4 pr-4>
        <v-layout row wrap>
          <v-flex xl4 lg12 md12 xs12 pa-3>
            <v-card color="white" class="pa-3">
              <h1>Pending Orders</h1>
              <div class="text-xs-center pa-3">
                <h1>{{ this.pending_orders.length }}</h1>
              </div>
            </v-card>
          </v-flex>
          <v-flex xl4 lg12 md12 xs12 pa-3>
            <v-card color="white" class="pa-3">
              <h1>No. of Sales of the Day</h1>
              <div class="text-xs-center pa-3">
                <h1>{{ this.approved_orders.length }}</h1>
              </div>
            </v-card>
          </v-flex>
          <v-flex xl4 lg12 md12 xs12 pa-3>
            <v-card color="white" class="pa-3">
              <h1>Critical Products</h1>
              <div class="text-xs-center pa-3">
                <h1>{{ this.critical_products.length }}</h1>
              </div>
            </v-card>
          </v-flex>
        </v-layout>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
export default {
  data() {
    return {
      pending_orders: [],
      approved_orders: [],
      critical_products: []
    };
  },
  created() {
    this.load_admin();
    this.fetchPendingOrders();
    this.fetchApprovedOrders();
    this.fetchCriticalProducts();
  },
  methods: {
    load_admin() {
      this.$store.dispatch("load_admin", "Dashboard");
    },
    fetchPendingOrders() {
      fetch("/api/pending_orders")
        .then(res => res.json())
        .then(res => {
          this.pending_orders = res;
        })
        .catch(err => console.log(err));
    },
    fetchApprovedOrders() {
      fetch("/api/approved_orders")
        .then(res => res.json())
        .then(res => {
          this.approved_orders = res;
        })
        .catch(err => console.log(err));
    },
    fetchCriticalProducts() {
      fetch("/api/critical_products")
        .then(res => res.json())
        .then(res => {
          this.critical_products = res;
        })
        .catch(err => console.log(err));
    }
  },
  computed: {
    component_title_admin() {
      return this.$store.state.component_title_admin;
    }
  }
};
</script>


