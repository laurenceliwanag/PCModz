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
        <v-dialog v-model="dialog" :persistent="!view" max-width="1200px">
          <template v-slot:activator="{ on }">
            <v-btn color="black" dark v-on="on" @click="newProduct()">New Product</v-btn>
          </template>

          <v-card>
            <form @submit.prevent="addProduct()">
              <v-card-title>
                <span class="headline">{{ dialog_title }} Product</span>
                <v-spacer></v-spacer>
                <v-icon
                  small
                  color="yellow darken-2"
                  v-if="product.featured.value == 1 && (view || edit)"
                >fas fa-star</v-icon>
              </v-card-title>

              <v-card-text>
                <v-alert v-model="alert_validation" dismissible type="error">
                  <div
                    v-for="(value, key, index) in alert_validationMessage"
                    v-bind:key="key"
                  >{{ value[index] }}</div>
                </v-alert>
                <v-container grid-list-md>
                  <v-layout wrap v-if="view">
                    <v-flex md6>
                      <v-flex xs12 class="text-xs-center">
                        <img
                          v-bind:src="'/storage/img/products/' + product.image"
                          id="view_product_image"
                        >
                      </v-flex>
                    </v-flex>
                    <v-flex md6>
                      <v-flex xs12 mb-1>
                        <h3>Name</h3>
                        <div>{{ product.name }}</div>
                      </v-flex>
                      <v-flex xs12 mb-1>
                        <h3>Description</h3>
                        <div>{{ product.desc }}</div>
                      </v-flex>
                      <v-flex xs12 mb-1>
                        <h3>Category</h3>
                        <div>{{ product.category.name }}</div>
                      </v-flex>
                      <v-flex xs12 mb-1>
                        <h3>Suggested Retail Price</h3>
                        <div>{{ "₱ " + product.srp.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</div>
                      </v-flex>
                      <v-flex xs12 mb-1>
                        <h3>Stock</h3>
                        <div>{{ product.stock }}</div>
                      </v-flex>
                      <v-flex xs12 mb-1>
                        <h3>Critical Level</h3>
                        <div>{{ product.critical }}</div>
                      </v-flex>
                      <v-flex xs12>
                        <div class="text-xs-center">
                          <v-chip v-if="product.status.value == 1" color="black" dark>
                            <div>{{ product.status.name }}</div>
                          </v-chip>
                          <v-chip v-if="product.status.value == 0">
                            <div>{{ product.status.name }}</div>
                          </v-chip>
                        </div>
                      </v-flex>
                    </v-flex>
                  </v-layout>
                  <v-layout wrap v-else>
                    <v-flex md6>
                      <v-flex xs12>
                        <input type="file" name="file" id="file" @change="fieldChange">
                      </v-flex>
                    </v-flex>
                    <v-flex md6>
                      <v-flex xs12>
                        <h4>Name*</h4>
                        <v-text-field
                          placeholder="Enter Product Name"
                          v-model="product.name"
                          type="text"
                          required
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs12>
                        <h4>Description*</h4>
                        <v-textarea
                          placeholder="Enter Description*"
                          v-model="product.desc"
                          type="text"
                          required
                        ></v-textarea>
                      </v-flex>
                      <v-flex xs12>
                        <h4>Category*</h4>
                        <v-select
                          v-model="product.category"
                          :items="categories"
                          placeholder="Select Category"
                          item-text="name"
                          single-line
                          return-object
                          required
                        ></v-select>
                      </v-flex>
                      <v-flex xs12>
                        <v-layout>
                          <v-flex xs6>
                            <h4>Suggested Retail Price*</h4>
                            <v-text-field
                              placeholder="Enter Suggested Retail Price*"
                              v-model="product.srp"
                              type="decimal"
                              min="0"
                              prefix="₱"
                              required
                            ></v-text-field>
                          </v-flex>
                          <v-flex xs6>
                            <h4>Critical Level*</h4>
                            <v-text-field
                              placeholder="Enter Critical Level*"
                              v-model="product.critical"
                              type="number"
                              min="1"
                              required
                            ></v-text-field>
                          </v-flex>
                        </v-layout>
                      </v-flex>
                      <v-flex xs12>
                        <v-layout>
                          <v-flex xs6>
                            <h4>Status*</h4>
                            <v-select
                              v-model="product.status"
                              :items="status"
                              placeholder="Select Status"
                              item-text="name"
                              single-line
                              return-object
                              required
                            ></v-select>
                          </v-flex>
                          <v-flex xs6>
                            <h4>Feature Product?*</h4>
                            <v-select
                              v-model="product.featured"
                              :items="featured"
                              placeholder="Select Feature"
                              item-text="name"
                              single-line
                              return-object
                              required
                            ></v-select>
                          </v-flex>
                        </v-layout>
                      </v-flex>
                      <small>* Indicates Required Field</small>
                    </v-flex>
                  </v-layout>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn flat @click="dialog = false">Close</v-btn>
                <v-btn flat type="submit" v-if="!view">Save</v-btn>
              </v-card-actions>
            </form>
          </v-card>
        </v-dialog>
      </v-flex>
    </v-layout>

    <v-layout mb-4>
      <v-flex pl-4 pr-4>
        <v-card>
          <v-card-title>
            Products
            <v-spacer></v-spacer>
            <v-text-field
              v-model="search"
              append-icon="search"
              label="Search"
              single-line
              hide-details
            ></v-text-field>
          </v-card-title>

          <v-alert v-model="alert" dismissible type="success">{{ alert_message }}</v-alert>

          <v-data-table
            :headers="headers"
            :items="products"
            :search="search"
            :loading="loading"
            :rows-per-page-items="rowsPerPageItems"
            :pagination.sync="pagination"
            hide-actions
          >
            <template v-slot:items="props">
              <td class="text-xs-center">
                <v-icon
                  small
                  color="yellow darken-2"
                  v-if="props.item.featured.value == 1"
                >fas fa-star</v-icon>
                <v-icon small v-if="props.item.featured.value == 0">far fa-star</v-icon>
              </td>
              <td class="text-xs-center">
                <img
                  id="tbl_product_image"
                  v-bind:src="'/storage/img/products/' + props.item.image"
                >
              </td>
              <td class="text-xs">{{ props.item.name }}</td>
              <td class="text-xs">{{ props.item.desc }}</td>
              <td class="text-xs">{{ props.item.category.name }}</td>
              <td
                class="text-xs"
              >{{ "₱ " + props.item.srp.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}</td>
              <td class="text-xs-center">{{ props.item.stock }}</td>
              <td class="text-xs-center">{{ props.item.critical }}</td>
              <td class="text-xs-center">
                <v-chip
                  v-if="props.item.status.value == 1"
                  class="pa-0"
                  color="black"
                  dark
                >{{ props.item.status.name }}</v-chip>
                <v-chip
                  class="pa-0"
                  v-if="props.item.status.value == 0"
                >{{ props.item.status.name }}</v-chip>
              </td>
              <td class="text-xs-center">
                <v-tooltip top>
                  <template v-slot:activator="{ on }">
                    <v-icon
                      small
                      class="ma-2"
                      color="black"
                      v-on="on"
                      @click="viewProduct(props.item)"
                    >far fa-eye</v-icon>
                  </template>
                  <span>View</span>
                </v-tooltip>

                <v-tooltip top>
                  <template v-slot:activator="{ on }">
                    <v-icon
                      small
                      class="ma-2"
                      color="black"
                      v-on="on"
                      @click="editProduct(props.item)"
                    >far fa-edit</v-icon>
                  </template>
                  <span>Edit</span>
                </v-tooltip>

                <v-tooltip top>
                  <template v-slot:activator="{ on }">
                    <v-icon
                      small
                      class="ma-2"
                      color="black"
                      v-on="on"
                      @click="deleteProduct(props.item.id)"
                    >far fa-trash-alt</v-icon>
                  </template>
                  <span>Delete</span>
                </v-tooltip>

                <v-tooltip top>
                  <template v-slot:activator="{ on }">
                    <v-icon
                      small
                      class="ma-2"
                      color="black"
                      v-on="on"
                      @click="addStock(props.item)"
                      :disabled="props.item.status.value === '0'"
                    >fas fa-plus</v-icon>
                  </template>
                  <span>Add Stock</span>
                </v-tooltip>
              </td>
            </template>
          </v-data-table>
        </v-card>
        <div class="text-xs-center pt-4">
          <v-pagination v-model="pagination.page" :length="pages" total-visible="5" color="black"></v-pagination>
        </div>
      </v-flex>
    </v-layout>

    <v-layout row justify-center>
      <v-dialog v-model="dialog_delete" persistent max-width="300">
        <v-card>
          <v-card-title class="headline">Delete Confirmation</v-card-title>
          <v-card-text>Are you sure you want to delete this product?</v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn flat @click="dialog_delete = false">Cancel</v-btn>
            <v-btn flat @click="yesDeleteProduct()">Yes, delete it!</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>

    <v-layout row justify-center>
      <v-dialog v-model="dialog_stock" persistent max-width="400px">
        <v-card>
          <form @submit.prevent="receiveStock()">
            <v-card-title>
              <span class="headline">Add Stock</span>
            </v-card-title>

            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12 mb-3>
                    <h3>Product</h3>
                    <div>{{ product.name }}</div>
                  </v-flex>
                  <v-flex xs12>
                    <h4>Quantity*</h4>
                    <v-text-field
                      v-model="product.receive_quantity"
                      placeholder="Enter Quantity"
                      type="number"
                      required
                    ></v-text-field>
                  </v-flex>
                  <small>* Indicates Required Field</small>
                </v-layout>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn flat @click="dialog_stock = false">Close</v-btn>
              <v-btn flat type="submit">Add Stock</v-btn>
            </v-card-actions>
          </form>
        </v-card>
      </v-dialog>
    </v-layout>
  </div>
</template>


<script>
export default {
  data() {
    return {
      products: [],
      categories: [],
      product: {
        product_id: "",
        id: "",
        image: "",
        name: "",
        desc: "",
        category: "",
        srp: "",
        stock: "",
        receive_quantity: "",
        critical: "",
        status: "",
        featured: ""
      },
      form: new FormData(),
      edit: false,
      view: false,
      alert: false,
      alert_message: "",
      alert_validation: false,
      alert_validationMessage: "",
      dialog: false,
      dialog_delete: false,
      dialog_stock: false,
      dialog_title: "",
      loading: false,
      search: "",
      rowsPerPageItems: [10, 20, 30, 40],
      pagination: {
        rowsPerPage: 10,
        totalItems: ""
      },
      headers: [
        {
          text: "",
          align: "center",
          value: "featured.value"
        },
        {
          text: "Image",
          align: "center",
          value: "image",
          sortable: false
        },
        { text: "Name", width: "10%", value: "name" },
        { text: "Description", width: "25%", value: "desc" },
        { text: "Category", width: "5%", value: "category.name" },
        { text: "SRP", width: "10%", value: "srp" },
        { text: "Stock", align: "center", width: "5%", value: "stock" },
        {
          text: "Critical Level",
          align: "center",
          width: "5%",
          value: "critical"
        },
        {
          text: "Status",
          align: "center",
          width: "5%",
          value: "status.name"
        },
        { text: "Action", align: "center", width: "15%", sortable: false }
      ],
      status: [
        { name: "Active", value: "1" },
        { name: "Inactive", value: "0" }
      ],
      featured: [{ name: "Yes", value: "1" }, { name: "No", value: "0" }]
    };
  },
  created() {
    this.fetchProducts();
    this.fetchCategories();
    this.load_admin();
  },
  methods: {
    load_admin() {
      this.$store.dispatch("load_admin", "Inventory");
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
      this.loading = true;
      fetch("/api/products")
        .then(res => res.json())
        .then(res => {
          this.products = res;
          this.pagination.totalItems = this.products.length;
        })
        .catch(err => console.log(err));
      setTimeout(() => {
        this.loading = false;
      }, 1000);
    },
    deleteProduct(id) {
      this.dialog_delete = true;
      this.product.product_id = id;
    },
    yesDeleteProduct() {
      fetch(`api/product/${this.product.product_id}`, {
        method: "delete"
      })
        .then(res => res.json())
        .then(data => {
          this.dialog_delete = false;
          this.alert_message = "Product has successfully been deleted";
          this.alert = true;
          this.fetchProducts();
          setTimeout(() => {
            this.alert = false;
          }, 3000);
        })
        .catch(err => console.log(err));
    },
    addProduct() {
      if (this.edit === false) {
        this.form = new FormData();
        this.form.append("image", this.product.image);
        this.form.append("name", this.product.name);
        this.form.append("desc", this.product.desc);
        this.form.append("category_id", this.product.category.id);
        this.form.append("srp", this.product.srp);
        this.form.append("critical", this.product.critical);
        this.form.append("status", this.product.status.value);
        this.form.append("featured", this.product.featured.value);

        const config = { headers: { "Content-Type": "multipart/form-data" } };
        axios
          .post("api/product", this.form, { config })
          .then(data => {
            this.dialog = false;
            this.alert_message = "New product has successfully been added";
            this.alert = true;
            this.fetchProducts();
            setTimeout(() => {
              this.alert = false;
            }, 3000);
          })
          .catch(err => {
            if (err.response.status == 422) {
              this.alert_validationMessage = err.response.data.errors;
              this.alert_validation = true;
              setTimeout(() => {
                this.alert_validation = false;
              }, 3000);
            } else {
              console.log(err);
            }
          });
      } else {
        this.form = new FormData();
        this.form.append("product_id", this.product.product_id);
        this.form.append("image", this.product.image);
        this.form.append("name", this.product.name);
        this.form.append("desc", this.product.desc);
        this.form.append("category_id", this.product.category.id);
        this.form.append("srp", this.product.srp);
        this.form.append("critical", this.product.critical);
        this.form.append("status", this.product.status.value);
        this.form.append("featured", this.product.featured.value);
        this.form.append("_method", "put");

        const config = { headers: { "Content-Type": "multipart/form-data" } };
        axios
          .post("api/product", this.form, { config })
          .then(data => {
            this.dialog = false;
            this.alert_message = "Product has successfully been updated";
            this.alert = true;
            this.fetchProducts();
            setTimeout(() => {
              this.alert = false;
            }, 3000);
          })
          .catch(err => console.log(err));
      }
    },
    receiveStock() {
      fetch("api/receive", {
        method: "put",
        body: JSON.stringify(this.product),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          this.dialog_stock = false;
          this.alert_message = "Stock has successfully been added";
          this.alert = true;
          this.product.receive_quantity = "";
          this.fetchProducts();
          setTimeout(() => {
            this.alert = false;
          }, 3000);
        })
        .catch(err => console.log(err));
    },
    fieldChange(e) {
      let selectedFile = e.target.files[0];
      this.product.image = selectedFile;
    },
    newProduct() {
      this.edit = false;
      this.view = false;
      this.dialog_title = "New";
      this.product.product_id = "";
      this.product.id = "";
      this.product.image = "";
      this.product.name = "";
      this.product.desc = "";
      this.product.category = "";
      this.product.srp = "";
      this.product.critical = "";
      this.product.status = "";
      this.product.featured = "";
    },
    editProduct(product) {
      this.edit = true;
      this.view = false;
      this.dialog_title = "";
      this.product.product_id = product.id;
      this.product.id = product.id;
      this.product.image = product.image;
      this.product.name = product.name;
      this.product.desc = product.desc;
      this.product.category = product.category;
      this.product.srp = product.srp;
      this.product.critical = product.critical;
      this.product.status = product.status;
      this.product.featured = product.featured;
      this.dialog = true;
    },
    viewProduct(product) {
      this.edit = false;
      this.view = true;
      this.dialog_title = "";
      this.product.product_id = product.id;
      this.product.id = product.id;
      this.product.image = product.image;
      this.product.name = product.name;
      this.product.desc = product.desc;
      this.product.category = product.category;
      this.product.srp = product.srp;
      this.product.stock = product.stock;
      this.product.critical = product.critical;
      this.product.status = product.status;
      this.product.featured = product.featured;
      this.dialog = true;
    },
    addStock(product) {
      this.product.product_id = product.id;
      this.product.id = product.id;
      this.product.name = product.name;
      this.product.stock = product.stock;
      this.dialog_stock = true;
    }
  },
  computed: {
    pages() {
      if (
        this.pagination.rowsPerPage == null ||
        this.pagination.totalItems == null
      )
        return 0;

      return Math.ceil(
        this.pagination.totalItems / this.pagination.rowsPerPage
      );
    },
    component_title_admin() {
      return this.$store.state.component_title_admin;
    }
  }
};
</script>

<style scoped>
#tbl_product_image {
  height: 4rem;
  width: 4rem;
  margin-top: 0.45rem;
}

#view_product_image {
  height: 25rem;
  width: 25rem;
}

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
