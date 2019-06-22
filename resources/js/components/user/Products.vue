<template>
  <div>
    <v-layout mb-4>
      <v-flex xs10 offset-xs1>
        <v-layout row wrap>
          <v-flex lg2 class="text-xs-center" pa-3>
            <v-text-field
              @change="search_product()"
              v-model="search_product_value"
              placeholder="Search..."
            ></v-text-field>

            <v-card flat color="black">
              <v-navigation-drawer floating permanent stateless width="1280" value="true">
                <v-list dense>
                  <v-list-tile @click="fetchProducts()">
                    <v-list-tile-action>
                      <img src="/images/icons/logo.png" height="20" width="20">
                    </v-list-tile-action>

                    <v-list-tile-content class="font-weight-bold">
                      <v-list-tile-title>ALL</v-list-tile-title>
                    </v-list-tile-content>
                  </v-list-tile>
                  <v-list-tile v-for="item in categories" :key="item.name" @click="filter(item)">
                    <v-list-tile-action>
                      <img
                        v-bind:src="'/storage/img/categories/' + item.image"
                        height="20"
                        width="20"
                      >
                    </v-list-tile-action>

                    <v-list-tile-content class="font-weight-bold">
                      <v-list-tile-title>{{ item.name }}</v-list-tile-title>
                    </v-list-tile-content>
                  </v-list-tile>
                </v-list>
              </v-navigation-drawer>
            </v-card>
          </v-flex>
          <v-flex lg10 class="text-xs-center">
            <v-layout pl-3 pt-4>
              <h1>{{ filter_name }}</h1>
            </v-layout>

            <v-layout pl-3 pr-3 pt-2 pb-1 v-if="filter_name != ''">
              <v-divider></v-divider>
            </v-layout>

            <v-layout row wrap v-if="this.products.length == 0">
              <v-flex pa-5>
                <v-card flat>
                  <v-card-text>
                    <h1 v-if="this.search_product_value != ''">No Products Found</h1>
                    <h1 v-else>No Available Products in this Category</h1>
                  </v-card-text>
                </v-card>
              </v-flex>
            </v-layout>
            <v-layout row wrap>
              <v-flex
                xs12
                sm12
                md6
                lg4
                xl3
                pa-3
                v-for="product in products"
                v-bind:key="product.id"
              >
                <v-card flat id="product_card">
                  <v-card-text class="pa-0 ma-0">
                    <figure>
                      <img v-bind:src="'/storage/img/products/' + product.image">

                      <figcaption>
                        <div class="additional">
                          <p>{{ product.desc.split(' ').slice(0, 10).join(" ") + '...' }}</p>

                          <v-btn color="white" @click="viewDetails(product)">View Details</v-btn>
                          <v-btn
                            outline
                            dark
                            @click="addToCart(product)"
                            v-if="product.stock != 0"
                          >Add to Cart</v-btn>
                          <v-btn outline dark disabled outlined v-else>Out of Stock</v-btn>
                        </div>
                      </figcaption>
                    </figure>
                    <div class="pa-2">
                      <h3>{{ product.name }}</h3>
                      <h4
                        class="text-xs-center"
                      >{{ "₱ " + product.srp.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</h4>
                    </div>
                  </v-card-text>
                </v-card>
              </v-flex>
            </v-layout>
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
      categories: [],
      search_product_value: ""
    };
  },
  created() {
    this.fetchProducts();
    this.fetchCategories();
    this.load_main();
  },
  methods: {
    load_main() {
      this.$store.dispatch("load_main");
    },
    fetchCategories() {
      fetch("/api/categories")
        .then(res => res.json())
        .then(res => {
          this.categories = res;
        })
        .catch(err => console.log(err));
    },
    fetchProducts() {
      this.$store.dispatch("fetchProducts");
    },
    viewDetails(item) {
      this.$router.push("/product/" + item.id);
    },
    addToCart(item) {
      item.quantity = 1;
      this.$store.dispatch("addToCart", item);
    },
    filter(category) {
      this.$store.dispatch("filter", category);
    },
    search_product() {
      if (this.search_product_value != "") {
        this.$store.dispatch("search_product", this.search_product_value);
      } else {
        this.fetchProducts();
      }
    }
  },
  computed: {
    products() {
      return this.$store.state.products;
    },
    filter_name() {
      return this.$store.state.filter_name;
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
  width: calc(100%);
  transform: translate3d(0, 0, 0) scale(1.3);
  transition: all 0.5s;
}

figure figcaption {
  position: absolute;
  color: white;
  text-align: center;
  padding-left: 1rem;
  padding-right: 1rem;
}

figure figcaption .additional p {
  text-align: justify;
}

figure figcaption .additional .v-btn {
  text-transform: uppercase;
}

figure .additional {
  opacity: 0;
  transition: all 1s;
}

figure:hover .additional {
  opacity: 1;
  transform: scale(1);
}

figure:first-child {
  margin-left: 0;
}

figure:hover img {
  transform: translate3d(0, 0, 0) scale(1);
  opacity: 0.4;
}

figure:hover {
  background: black;
}

#product_card:hover {
  box-shadow: 0 0 5px gray;
}
</style>

