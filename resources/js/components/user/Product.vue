<template>
  <div>
    <v-layout mb-4 mt-4>
      <v-flex xs10 offset-xs1>
        <v-layout wrap v-for="item in product" :key="item.id">
          <v-flex lg6 pa-5>
            <v-card flat>
              <v-card-text>
                <figure>
                  <img v-bind:src="'/storage/img/products/' + item.image">
                </figure>
              </v-card-text>
            </v-card>
          </v-flex>
          <v-flex lg6 pa-5 style="display: grid; align-items: center; ">
            <v-flex xs12 mb-1>
              <h1>{{ item.name }}</h1>
            </v-flex>
            <v-flex xs12 mb-1>
              <h3>Description</h3>
              <div>{{ item.desc }}</div>
            </v-flex>
            <v-flex xs12 mb-1>
              <h3>Category</h3>
              <div>{{ item.category.name }}</div>
            </v-flex>
            <v-flex xs12 mb-1>
              <h3>Suggested Retail Price</h3>
              <div>{{ "₱ " + item.srp.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</div>
            </v-flex>
            <v-flex xs12 mb-1 v-if="item.stock != 0">
              <h2 class="red--text">In-Stock</h2>
            </v-flex>
            <v-flex xs12 mb-1>
              <div class="text-xs-center">
                <v-btn color="white" @click="addToCart(product)" v-if="item.stock != 0">Add to Cart</v-btn>
                <v-btn color="white" disabled outlined v-else>Out of Stock</v-btn>
              </div>
            </v-flex>
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
      product: []
    };
  },
  created() {
    this.fetchProduct();
    this.load_main();
  },
  methods: {
    load_main() {
      this.$store.dispatch("load_main");
    },
    fetchProduct() {
      fetch(`api/product/${this.$route.params.id}`)
        .then(res => res.json())
        .then(res => {
          this.product = res;
        })
        .catch(err => console.log(err));
    },
    addToCart(item) {
      item.quantity = 1;
      this.$store.dispatch("addToCart", item);
    }
  }
};
</script>

<style scoped>
figure {
  display: grid;
  justify-items: center;
  align-items: center;
  overflow: hidden;
  position: relative;
  transition: background-color 0.5s;
}

figure img {
  width: calc(75%);
  transform: translate3d(0, 0, 0) scale(1.3);
}
</style>


