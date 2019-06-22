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
        <v-card class="white">
          <v-card-text class="pt-5 pl-4">
            <h3 class="mb-2">Customer Name: {{ user.user_name }}</h3>
            <h3 class="mb-2">Delivery Address: {{ user.user_name }}</h3>
            <h3>Payment Method: {{ user.user_name }}</h3>
          </v-card-text>

          <v-card-text>
            <v-list two-line>
              <v-divider></v-divider>
              <template v-for="item in orders">
                <v-list-tile :key="item.product_id" avatar>
                  <v-layout wrap>
                    <v-flex xl5>
                      <v-list-tile-content>
                        <v-list-tile-title>{{ item.product.product_name }}</v-list-tile-title>
                      </v-list-tile-content>
                    </v-flex>

                    <v-flex xl1>
                      <v-list-tile-content>
                        <v-list-tile-title>{{ item.order_quantity }}</v-list-tile-title>
                      </v-list-tile-content>
                    </v-flex>

                    <v-flex xl3>
                      <v-list-tile-content>
                        <v-list-tile-title
                          class="text-xs-right"
                        >{{ "₱ " + item.srp.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</v-list-tile-title>
                      </v-list-tile-content>
                    </v-flex>

                    <v-flex xl3>
                      <v-list-tile-content>
                        <v-list-tile-title
                          class="text-xs-right"
                        >{{ "₱ " + item.total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</v-list-tile-title>
                      </v-list-tile-content>
                    </v-flex>
                  </v-layout>
                </v-list-tile>
                <v-divider :key="item.id"></v-divider>
              </template>
            </v-list>
          </v-card-text>

          <v-card-text class="text-xs-right">
            <h3>Total Price: {{ "₱ " + totalprice.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</h3>
          </v-card-text>

          <v-card-actions>
            <v-btn flat="flat" to="/admin/orders">Go Back</v-btn>
            <v-spacer></v-spacer>
            <v-btn flat="flat">Decline</v-btn>
            <v-btn flat="flat">Approved</v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </div>
</template>


<script>
export default {
  data() {
    return {
      orders: [],
      product: [],
      totalprice: 0,
      user: ""
    };
  },
  created() {
    this.load_admin();
    this.fetchInvoice();
  },
  methods: {
    load_admin() {
      this.$store.dispatch("load_admin", "Order");
    },
    fetchInvoice() {
      fetch(`api/order/${this.$route.params.invoice}`)
        .then(res => res.json())
        .then(res => {
          this.orders = res;
          this.orders.forEach(item => {
            this.totalprice += parseFloat(item.total);
            this.user = item.user;
          });
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

<style scoped>
.v-btn {
  border-radius: 0px;
  margin: 0px;
}

.v-chip {
  border-radius: 0;
  padding-left: 0.5rem;
  padding-right: 0.5rem;
}
</style>
