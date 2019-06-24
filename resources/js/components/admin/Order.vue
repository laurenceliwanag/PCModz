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
            <v-layout>
              <v-flex>
                <h3 class="mb-2 font-weight-regular">
                  <strong class="mr-1">Customer Name:</strong>
                  {{ user.user_name }}
                </h3>
                <h3 class="mb-2 font-weight-regular">
                  <strong class="mr-1">Delivery Address:</strong>
                  {{ user.user_name }}
                </h3>
                <h3 class="font-weight-regular">
                  <strong class="mr-1">Payment Method:</strong>
                  {{ user.user_name }}
                </h3>
              </v-flex>
              <v-flex class="text-xs-right">
                <h3 class="mb-2">
                  Invoice Number:
                  <strong class="ml-1 red--text title">{{ invoice }}</strong>
                </h3>
              </v-flex>
            </v-layout>
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

          <v-card-text class="text-xs-right mb-3 mt-2">
            <v-layout class="mb-2" wrap>
              <v-flex md10>
                <h3>Sub Total:</h3>
              </v-flex>
              <v-flex>
                <h3>{{ "₱ " + subtotal.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</h3>
              </v-flex>
            </v-layout>

            <v-layout class="mb-2" wrap>
              <v-flex md10>
                <h3>VAT:</h3>
              </v-flex>
              <v-flex>
                <h3>{{ "₱ " + vat.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</h3>
              </v-flex>
            </v-layout>

            <v-layout wrap>
              <v-flex md10>
                <h3>Total:</h3>
              </v-flex>
              <v-flex>
                <h3>{{ "₱ " + totalprice.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</h3>
              </v-flex>
            </v-layout>
          </v-card-text>

          <v-card-actions>
            <v-btn flat="flat" to="/admin/orders">Go Back</v-btn>
            <v-spacer></v-spacer>
            <v-btn flat="flat">Decline</v-btn>
            <v-btn flat="flat" class="black" dark>Approved</v-btn>
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
      invoice: 0,
      subtotal: 0,
      vat: 0,
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
          console.log(this.orders);
          this.orders.forEach(item => {
            this.totalprice += parseFloat(item.total);
            this.invoice = item.invoice;
            this.user = item.user;
          });
          this.vat += parseFloat(this.totalprice * 0.12);
          this.subtotal += parseFloat(this.totalprice - this.vat);
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
