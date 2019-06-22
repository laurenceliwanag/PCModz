<template>
  <div>
    <v-layout row justify-center>
      <v-dialog v-model="dialog_carts" persistent width="80%">
        <v-card>
          <v-card-title>
            <span class="headline">Your Cart</span>
          </v-card-title>
          <v-card-text v-if="!cart.length > 0">
            <h3 class="text-xs-center">Your cart is empty</h3>
          </v-card-text>

          <v-card-text v-if="cart.length > 0">
            <v-layout>
              <v-flex>
                <v-card-text class="text-xs-right">
                  <h3>No. of Items: {{ cart.length }}</h3>
                </v-card-text>
              </v-flex>
            </v-layout>

            <v-list two-line>
              <v-divider></v-divider>
              <template v-for="item in cart">
                <v-list-tile :key="item.title" avatar>
                  <v-layout>
                    <v-flex xl1>
                      <v-list-tile-content>
                        <v-list-tile-avatar>
                          <v-icon small color="black" @click="remove(item)">fas fa-window-close</v-icon>
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

          <v-card-text class="text-xs-right" v-if="cart.length > 0">
            <h3>Total Price: {{ "₱ " + totalprice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</h3>
          </v-card-text>

          <v-card-actions>
            <v-btn flat="flat" @click="closeCart()" v-if="cart.length > 0">Continue Shopping</v-btn>
            <v-spacer></v-spacer>
            <v-btn flat="flat" @click="closeCart()" v-if="!cart.length > 0">Close</v-btn>
            <v-btn
              class="green--text"
              v-if="cart.length > 0"
              flat="flat"
              @click="closeCart()"
              to="/checkout"
            >Proceed to Checkout</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  created() {
    this.$store.dispatch("viewCart");
  },
  computed: {
    dialog_carts() {
      return this.$store.state.dialog_carts;
    },
    cart() {
      return this.$store.state.cart;
    },
    totalprice() {
      return this.$store.state.totalprice;
    }
  },
  methods: {
    closeCart() {
      this.$store.dispatch("closeCart");
    },
    remove(item) {
      this.$store.dispatch("removeCart", item);
    },
    updateCart() {
      this.$store.dispatch("storeCart");
    }
  }
};
</script>
