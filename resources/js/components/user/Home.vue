<template>
  <div>
    <v-layout>
      <v-flex xs12>
        <v-parallax dark src="/images/icons/banner.jpeg" height="800">
          <v-layout align-center column justify-center>
            <h1 class="display-3 font-weight-black text-xs-center mb-3 banner-title">
              Built for
              <br>Professionals
              <br>X
              <br>Gamers
            </h1>
          </v-layout>
        </v-parallax>
      </v-flex>
    </v-layout>

    <v-layout pa-4>
      <v-flex xs10 offset-xs1>
        <v-layout mb-4>
          <v-flex class="text-xs-center">
            <h1>FEATURED PRODUCTS</h1>
          </v-flex>
        </v-layout>

        <v-layout mb-4>
          <v-flex class="text-xs-center">
            <v-divider></v-divider>
          </v-flex>
        </v-layout>

        <v-layout mb-4>
          <v-flex class="text-xs-center">
            <v-layout row wrap v-if="this.products.length == 0">
              <v-flex pa-3>
                <v-card flat>
                  <v-card-text>
                    <h1>No Products Found</h1>
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
                      <h2>{{ product.name }}</h2>
                      <h3
                        class="text-xs-center"
                      >{{ "₱ " + product.srp.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</h3>
                    </div>
                  </v-card-text>
                </v-card>
              </v-flex>
            </v-layout>
          </v-flex>
        </v-layout>
      </v-flex>
    </v-layout>

    <v-layout pa-4 class="white">
      <v-flex xs10 offset-xs1>
        <v-layout mb-4>
          <v-flex class="text-xs-center">
            <h1>OUR SERVICES</h1>
          </v-flex>
        </v-layout>

        <v-layout mb-4>
          <v-flex class="text-xs-center">
            <v-divider></v-divider>
          </v-flex>
        </v-layout>

        <v-layout mb-4>
          <v-flex class="text-xs-center">
            <v-layout wrap>
              <v-flex xs12 lg4 pt-3 pb-3>
                <v-avatar color="grey lighten-4" class="mb-3" size="200">
                  <img src="/images/icons/banner.jpeg" alt="avatar">
                </v-avatar>
                <h2 class="mb-3">Ready Built PC</h2>
                <v-btn class="primary">Buy Now</v-btn>
              </v-flex>
              <v-flex xs12 lg4 pt-3 pb-3>
                <v-avatar color="grey lighten-4" class="mb-3" size="200">
                  <img src="/images/icons/banner.jpeg" alt="avatar">
                </v-avatar>
                <h2 class="mb-3">Custom PC</h2>
                <v-btn class="primary">Customized Now</v-btn>
              </v-flex>
              <v-flex xs12 lg4 pt-3 pb-3>
                <v-avatar color="grey lighten-4" class="mb-3" size="200">
                  <img src="/images/icons/banner.jpeg" alt="avatar">
                </v-avatar>
                <h2 class="mb-3">Modified Rig</h2>
                <v-btn class="primary">Modify Now</v-btn>
              </v-flex>
            </v-layout>
          </v-flex>
        </v-layout>
      </v-flex>
    </v-layout>

    <v-layout pa-4>
      <v-flex xs10 offset-xs1>
        <v-layout mb-4>
          <v-flex class="text-xs-center">
            <h1>ABOUT US</h1>
          </v-flex>
        </v-layout>

        <v-layout mb-4>
          <v-flex class="text-xs-center">
            <v-divider></v-divider>
          </v-flex>
        </v-layout>

        <v-layout mb-4>
          <v-flex pt-3>
            <v-timeline>
              <v-timeline-item v-for="n in 4" :key="n" color="primary" large>
                <template v-slot:opposite>
                  <span>Tus eu perfecto</span>
                </template>
                <v-card class="elevation-2">
                  <v-card-title class="headline">Lorem ipsum</v-card-title>
                  <v-card-text>Lorem ipsum dolor sit amet, no nam oblique veritus. Commune scaevola imperdiet nec ut, sed euismod convenire principes at. Est et nobis iisque percipit, an vim zril disputando voluptatibus, vix an salutandi sententiae.</v-card-text>
                </v-card>
              </v-timeline-item>
            </v-timeline>
          </v-flex>
        </v-layout>
      </v-flex>
    </v-layout>

    <v-layout pa-4 class="white">
      <v-flex xs10 offset-xs1>
        <v-layout mb-4>
          <v-flex class="text-xs-center">
            <h1>CONTACT US</h1>
          </v-flex>
        </v-layout>

        <v-layout mb-4>
          <v-flex class="text-xs-center">
            <v-divider></v-divider>
          </v-flex>
        </v-layout>

        <v-layout mb-4 wrap>
          <v-flex xs6 offset-xs3 pt-3>
            <h4>Full Name</h4>
            <v-text-field placeholder="Enter full name" type="text" required></v-text-field>
          </v-flex>
          <v-flex xs6 offset-xs3>
            <h4>Email Address</h4>
            <v-text-field placeholder="Enter email address" type="text" required></v-text-field>
          </v-flex>
          <v-flex xs6 offset-xs3>
            <h4>Message</h4>
            <v-textarea placeholder="Enter message" type="text" required></v-textarea>
          </v-flex>
          <v-flex xs6 offset-xs3>
            <v-btn class="primary" block>Send</v-btn>
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
      products: []
    };
  },
  created() {
    this.load_main();
    this.fetchFeatured();
  },
  methods: {
    load_main() {
      this.$store.dispatch("load_main");
    },
    fetchFeatured() {
      fetch("/api/featured")
        .then(res => res.json())
        .then(res => {
          this.products = res;
        })
        .catch(err => console.log(err));
    },
    viewDetails(item) {
      this.$router.push("/product/" + item.id);
    },
    addToCart(item) {
      item.quantity = 1;
      this.$store.dispatch("addToCart", item);
    },
    build() {
      this.$router.push("/build");
    }
  }
};
</script>


<style scoped>
#home_banner {
  height: auto;
  width: 100vw;
}

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

.banner-title {
  text-shadow: 1px 1px 10px #000000;
}
</style>




