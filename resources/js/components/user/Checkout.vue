<template>
  <div>
    <v-layout mb-4 mt-4>
      <v-flex xs10 offset-xs1>
        <v-stepper v-model="e1">
          <v-stepper-header>
            <v-stepper-step :complete="e1 > 1" step="1">Order Details</v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step :complete="e1 > 2" step="2">Order Summary</v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step step="3">Invoice</v-stepper-step>
          </v-stepper-header>

          <v-stepper-items>
            <v-stepper-content step="1">
              <form @submit.prevent="
                    submitDetails()">
                <v-layout mb-4>
                  <v-flex xs10 offset-xs1 class="text-xs-center">
                    <h1 class="text-xs-center">Order Details</h1>
                  </v-flex>
                </v-layout>

                <v-layout mb-4 v-if="cart.length > 0">
                  <v-flex xs10 offset-xs1>
                    <v-layout wrap>
                      <v-flex xs6 offset-xs3>
                        <h4>Payment Method*</h4>
                        <v-text-field placeholder="Enter payment method" type="text" required></v-text-field>
                      </v-flex>
                      <v-flex xs6 offset-xs3>
                        <h4>Delivery Address*</h4>
                        <v-text-field placeholder="Enter delivery address" type="text" required></v-text-field>
                      </v-flex>
                      <v-flex xs6 offset-xs3>
                        <h4>Delivery Address*</h4>
                        <v-text-field placeholder="Enter delivery address" type="text" required></v-text-field>
                      </v-flex>
                      <v-flex xs6 offset-xs3>
                        <h4>Delivery Address*</h4>
                        <v-text-field placeholder="Enter delivery address" type="text" required></v-text-field>
                      </v-flex>
                    </v-layout>
                  </v-flex>
                </v-layout>

                <v-layout mb-4 v-if="!cart.length > 0">
                  <v-flex xs10 offset-xs1 class="text-xs-center">
                    <v-btn flat class="black" dark to="/products">Go to Products</v-btn>
                  </v-flex>
                </v-layout>

                <v-layout mb-4 v-if="cart.length > 0">
                  <v-flex xs10 offset-xs1 class="text-xs-right">
                    <v-card-actions>
                      <v-btn flat to="/products">Continue Shopping</v-btn>
                      <v-spacer></v-spacer>
                      <v-btn flat dark class="black" type="submit">Continue</v-btn>
                    </v-card-actions>
                  </v-flex>
                </v-layout>
              </form>
            </v-stepper-content>

            <v-stepper-content step="2">
              <v-layout mb-4>
                <v-flex xs10 offset-xs1 class="text-xs-center">
                  <h1 class="text-xs-center">Order Summary</h1>
                </v-flex>
              </v-layout>

              <v-layout mb-4 mt-4 v-if="cart.length > 0">
                <v-flex xs10 offset-xs1 class="text-xs-center">
                  <v-card-text class="text-xs-right">
                    <h3 v-if="cart.length > 0">No. of Items: {{ cart.length }}</h3>
                  </v-card-text>
                </v-flex>
              </v-layout>

              <v-layout mb-4 v-if="cart.length > 0">
                <v-flex xs10 offset-xs1>
                  <v-card-text>
                    <v-list two-line>
                      <template v-for="item in cart">
                        <v-divider :key="item.title"></v-divider>
                        <v-list-tile :key="item.title" avatar>
                          <v-layout wrap>
                            <v-flex xl1>
                              <v-list-tile-content>
                                <v-list-tile-avatar>
                                  <v-icon
                                    small
                                    color="black"
                                    @click="remove(item)"
                                  >fas fa-window-close</v-icon>
                                </v-list-tile-avatar>
                              </v-list-tile-content>
                            </v-flex>

                            <v-flex xl1>
                              <v-list-tile-content>
                                <v-list-tile-avatar>
                                  <img v-bind:src="'/storage/img/products/' + item.image">
                                </v-list-tile-avatar>
                              </v-list-tile-content>
                            </v-flex>

                            <v-flex xl3>
                              <v-list-tile-content>
                                <v-list-tile-title>{{ item.name }}</v-list-tile-title>
                              </v-list-tile-content>
                            </v-flex>

                            <v-flex xl1>
                              <v-list-tile-content>
                                <v-text-field
                                  type="number"
                                  v-model="item.quantity"
                                  min="1"
                                  required
                                  @input="updateCart()"
                                ></v-text-field>
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
                                >{{ "₱ " + (item.srp * item.quantity).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</v-list-tile-title>
                              </v-list-tile-content>
                            </v-flex>
                          </v-layout>
                        </v-list-tile>
                        <v-divider :key="item.title"></v-divider>
                      </template>
                    </v-list>
                  </v-card-text>
                </v-flex>
              </v-layout>

              <v-layout mb-4 v-if="cart.length > 0">
                <v-flex xs10 offset-xs1>
                  <v-card-text class="text-xs-right">
                    <h3>Total Price: {{ "₱ " + totalprice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</h3>
                  </v-card-text>
                </v-flex>
              </v-layout>

              <v-layout mb-4 v-if="cart.length > 0">
                <v-flex xs10 offset-xs1 class="text-xs-right">
                  <v-card-actions>
                    <v-btn flat to="/products">Continue Shopping</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn flat @click="e1 = 1">Go Back</v-btn>
                    <v-btn
                      flat
                      class="black"
                      dark
                      @click="submitOrder()"
                      v-if="cart.length > 0"
                    >Checkout</v-btn>
                  </v-card-actions>
                </v-flex>
              </v-layout>
            </v-stepper-content>

            <v-stepper-content step="3">
              <v-layout mb-4>
                <v-flex xs10 offset-xs1 class="text-xs-center">
                  <h1 class="text-xs-center">Invoice</h1>
                </v-flex>
              </v-layout>

              <v-layout mb-4>
                <v-flex xs10 offset-xs1 class="text-xs-right">
                  <v-card-actions>
                    <v-btn flat to="/products">Shop more</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn flat class="black" dark @click="alert('Hello')">Print</v-btn>
                  </v-card-actions>
                </v-flex>
              </v-layout>
            </v-stepper-content>
          </v-stepper-items>
        </v-stepper>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
export default {
  data() {
    return {
      orders: [],
      last_invoice: "",
      product: [],
      e1: 0
    };
  },
  created() {
    this.load_main();
    this.$store.dispatch("fetchUser");
  },
  methods: {
    load_main() {
      this.$store.dispatch("load_main");
    },
    remove(item) {
      this.$store.dispatch("removeCart", item);
    },
    updateCart() {
      this.$store.dispatch("storeCart");
    },
    submitDetails() {
      this.e1 = 2;
    },
    submitOrder() {
      fetch("/api/last_invoice")
        .then(res => res.json())
        .then(res => {
          this.last_invoice = res.invoice;
          this.cart.forEach(item => {
            fetch(`api/product/${item.id}`)
              .then(res => res.json())
              .then(res => {
                this.product = res;
                this.product.forEach(product => {
                  if (product.id == item.id) {
                    this.orders.push({
                      invoice: this.last_invoice + 1,
                      user_id: this.user.id,
                      product_id: item.id,
                      stock: product.stock,
                      incharge_id: "1",
                      order_quantity: item.quantity,
                      total: item.srp * item.quantity,
                      status: "0"
                    });
                  }
                });
              })
              .catch(err => console.log(err));
          });

          this.orders.forEach(order => {
            axios
              .post("api/order", {
                invoice: order.invoice,
                user_id: order.user_id,
                product_id: order.product_id,
                incharge_id: order.incharge_id,
                order_quantity: order.order_quantity,
                total: order.total,
                status: order.status
              })
              .then(data => {
                fetch("api/remove", {
                  method: "put",
                  body: JSON.stringify(order),
                  headers: {
                    "content-type": "application/json"
                  }
                })
                  .then(res => res.json())
                  .then(data => {})
                  .catch(err => console.log(err));
                this.$store.dispatch("emptyCart");
                console.log("Success");
                this.e1 = 3;
              })
              .catch(err => {
                console.log(err);
              });
          });
        })
        .catch(err => console.log(err));
    }
  },
  computed: {
    user() {
      return this.$store.state.user;
    },
    cart() {
      return this.$store.state.cart;
    },
    totalprice() {
      return this.$store.state.totalprice;
    }
  }
};
</script>
