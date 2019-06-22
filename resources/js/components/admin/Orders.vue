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
        <v-dialog v-model="dialog" max-width="500px">
          <v-card>
            <form @submit.prevent="updateOrder()">
              <v-card-title>
                <span class="headline">Invoice No. {{ order.invoice }}</span>
              </v-card-title>

              <v-card-text>
                <v-container grid-list-md>
                  <v-layout wrap v-if="view">
                    <v-flex xs12>
                      <h3></h3>
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
            Orders
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
            :items="orders"
            :search="search"
            :loading="loading"
            :rows-per-page-items="rowsPerPageItems"
            :pagination.sync="pagination"
            hide-actions
          >
            <template v-slot:items="props">
              <td class="text-xs">{{ props.item.created_at.date }}</td>
              <td class="text-xs">{{ props.item.invoice }}</td>
              <td class="text-xs">{{ props.item.incharge_id }}</td>
              <td class="text-xs">{{ props.item.user.user_name }}</td>
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
                      @click="viewOrder(props.item)"
                    >far fa-eye</v-icon>
                  </template>
                  <span>View</span>
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
  </div>
</template>


<script>
export default {
  data() {
    return {
      orders: [],
      order: {},
      form: new FormData(),
      view: false,
      alert: false,
      alert_message: "",
      dialog: false,
      loading: false,
      search: "",
      rowsPerPageItems: [10, 20, 30, 40],
      pagination: {
        rowsPerPage: 10,
        totalItems: ""
      },
      headers: [
        { text: "Date", width: "15%", value: "created_at  " },
        { text: "Invoice", width: "20%", value: "invoice" },
        { text: "Person In-charge", width: "20%", value: "incharge_id" },
        { text: "Customer Name", width: "20%", value: "user_id" },
        { text: "Status", align: "center", value: "status" },
        { text: "Action", align: "center", width: "15%", sortable: false }
      ],
      status: [{ name: "Active", value: "1" }, { name: "Inactive", value: "0" }]
    };
  },
  created() {
    this.fetchOrders();
    this.load_admin();
  },
  methods: {
    load_admin() {
      this.$store.dispatch("load_admin", "Orders");
    },
    fetchOrders() {
      fetch("/api/orders")
        .then(res => res.json())
        .then(res => {
          this.orders = res;
          this.pagination.totalItems = this.orders.length;
        })
        .catch(err => console.log(err));
    },
    viewOrder(order) {
      this.$router.push("/admin/order/" + order.invoice);
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
#view_order_image {
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
