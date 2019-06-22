<template>
  <div>
    <h1 class="text-xs-center">Gallery</h1>
  </div>
</template>

<script>
export default {
  data() {
    return {
      gallery: []
    };
  },
  created() {
    this.fetchGallery();
    this.load_main();
  },
  methods: {
    load_main() {
      this.$store.dispatch("load_main");
    },
    fetchGallery() {
      fetch("/api/active_gallery")
        .then(res => res.json())
        .then(res => {
          this.gallery = res;
        })
        .catch(err => console.log(err));
      setTimeout(() => {
        this.loading = false;
      }, 1000);
    },
    viewDetails(item) {
      this.$router.push("/build/" + item.id);
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

figure figcaption h3 {
  font-weight: bold;
  font-size: 1.5rem;
  text-transform: uppercase;
  background: black;
  display: inline-block;
  padding: 0.5rem 0.7rem;
  margin-bottom: 0.5vw;
}

figure figcaption .additional p {
  font-size: 1.25rem;
  margin-bottom: 0.5vw;
  text-align: justify;
}

figure figcaption .additional .v-btn {
  font-size: 1.25rem;
  text-transform: uppercase;
  font-weight: bold;
  padding-left: 0.7rem;
  padding-right: 0.7rem;
  padding-top: 0.8rem;
  padding-bottom: 2.5rem;
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
</style>

