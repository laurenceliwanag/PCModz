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
        <v-dialog v-model="dialog" :persistent="!view" max-width="500px">
          <template v-slot:activator="{ on }">
            <v-spacer></v-spacer>
            <v-btn color="black" dark v-on="on" @click="newCategory()">New Category</v-btn>
          </template>

          <v-card>
            <form @submit.prevent="addCategory()">
              <v-card-title>
                <span class="headline">{{ dialog_title }} Category</span>
              </v-card-title>

              <v-card-text>
                <v-container grid-list-md>
                  <v-layout wrap v-if="view">
                    <v-flex xs12 class="text-xs-center">
                      <img
                        id="view_category_image"
                        v-bind:src="'/storage/img/categories/' + category.image"
                      >
                    </v-flex>
                    <v-flex xs12>
                      <h3>Name</h3>
                      <div>{{ category.name }}</div>
                    </v-flex>
                  </v-layout>
                  <v-layout wrap v-else>
                    <v-flex xs12 mb-3>
                      <input type="file" name="file" id="file" @change="fieldChange">
                    </v-flex>
                    <v-flex xs12>
                      <h4>Name*</h4>
                      <v-text-field
                        placeholder="Enter Category Name*"
                        v-model="category.name"
                        type="text"
                        required
                      ></v-text-field>
                    </v-flex>
                    <small>* Indicates Required Field</small>
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
            Categories
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
            :items="categories"
            :search="search"
            :loading="loading"
            :rows-per-page-items="rowsPerPageItems"
            :pagination.sync="pagination"
            hide-actions
          >
            <template v-slot:items="props">
              <td class="text-xs-center">
                <img
                  id="tbl_product_image"
                  v-bind:src="'/storage/img/categories/' + props.item.image"
                >
              </td>
              <td class="text-xs">{{ props.item.name }}</td>
              <td class="text-xs-center">
                <v-tooltip top>
                  <template v-slot:activator="{ on }">
                    <v-icon
                      small
                      class="ma-2"
                      color="black"
                      v-on="on"
                      @click="viewCategory(props.item)"
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
                      @click="editCategory(props.item)"
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
                      @click="deleteCategory(props.item.id)"
                    >far fa-trash-alt</v-icon>
                  </template>
                  <span>Delete</span>
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
          <v-card-text>Are you sure you want to delete this category?</v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn flat @click="dialog_delete = false">Cancel</v-btn>
            <v-btn flat @click="yesDeleteCategory()">Yes, delete it!</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>
  </div>
</template>


<script>
export default {
  data() {
    return {
      categories: [],
      category: {
        category_id: "",
        id: "",
        image: "",
        name: ""
      },
      form: new FormData(),
      edit: false,
      view: false,
      alert: false,
      alert_message: "",
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
          text: "Image",
          align: "center",
          value: "image",
          sortable: false,
          width: "10%"
        },
        { text: "Name", value: "name" },
        { text: "Action", align: "center", width: "15%", sortable: false }
      ],
      status: [{ name: "Active", value: "1" }, { name: "Inactive", value: "0" }]
    };
  },
  created() {
    this.fetchCategories();
    this.load_admin();
  },
  methods: {
    load_admin() {
      this.$store.dispatch("load_admin", "Categories");
    },
    fetchCategories() {
      fetch("/api/categories")
        .then(res => res.json())
        .then(res => {
          this.categories = res;
          this.pagination.totalItems = this.categories.length;
        })
        .catch(err => console.log(err));
    },
    deleteCategory(id) {
      this.dialog_delete = true;
      this.category.category_id = id;
    },
    yesDeleteCategory() {
      fetch(`api/category/${this.category.category_id}`, {
        method: "delete"
      })
        .then(res => res.json())
        .then(data => {
          this.dialog_delete = false;
          this.alert_message = "Category has successfully been deleted";
          this.alert = true;
          this.fetchCategories();
          setTimeout(() => {
            this.alert = false;
          }, 3000);
        })
        .catch(err => console.log(err));
    },
    addCategory() {
      if (this.edit === false) {
        this.form = new FormData();
        this.form.append("image", this.category.image);
        this.form.append("name", this.category.name);

        const config = { headers: { "Content-Type": "multipart/form-data" } };
        axios
          .post("api/category", this.form, { config })
          .then(data => {
            this.dialog = false;
            this.alert_message = "New category has successfully been added";
            this.alert = true;
            this.fetchCategories();
            setTimeout(() => {
              this.alert = false;
            }, 3000);
          })
          .catch(err => console.log(err));
      } else {
        this.form = new FormData();
        this.form.append("category_id", this.category.category_id);
        this.form.append("image", this.category.image);
        this.form.append("name", this.category.name);
        this.form.append("_method", "put");

        const config = { headers: { "Content-Type": "multipart/form-data" } };
        axios
          .post("api/category", this.form, { config })
          .then(data => {
            this.dialog = false;
            this.alert_message = "Category has successfully been updated";
            this.alert = true;
            this.fetchCategories();
            setTimeout(() => {
              this.alert = false;
            }, 3000);
          })
          .catch(err => console.log(err));
      }
    },
    fieldChange(e) {
      let selectedFile = e.target.files[0];
      this.category.image = selectedFile;
    },
    newCategory() {
      this.edit = false;
      this.view = false;
      this.dialog_title = "New";
      this.category.category_id = "";
      this.category.id = "";
      this.category.image = "";
      this.category.name = "";
      this.category.desc = "";
      this.category.category = "";
      this.category.srp = "";
      this.category.critical = "";
      this.category.status = "";
    },
    editCategory(category) {
      this.edit = true;
      this.view = false;
      this.dialog_title = "";
      this.category.category_id = category.id;
      this.category.id = category.id;
      this.category.image = category.image;
      this.category.name = category.name;
      this.category.desc = category.desc;
      this.category.category = category.category;
      this.category.srp = category.srp;
      this.category.critical = category.critical;
      this.category.status = category.status;
      this.dialog = true;
    },
    viewCategory(category) {
      this.edit = false;
      this.view = true;
      this.dialog_title = "";
      this.category.category_id = category.id;
      this.category.id = category.id;
      this.category.image = category.image;
      this.category.name = category.name;
      this.category.desc = category.desc;
      this.category.category = category.category;
      this.category.srp = category.srp;
      this.category.stock = category.stock;
      this.category.critical = category.critical;
      this.category.status = category.status;
      this.dialog = true;
    },
    addStock(category) {
      this.category.category_id = category.id;
      this.category.id = category.id;
      this.category.stock = category.stock;
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

#view_category_image {
  height: 25rem;
  width: 25rem;
}

.v-btn {
  border-radius: 0px;
  margin: 0px;
}
</style>
