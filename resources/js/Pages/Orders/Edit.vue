<template>
  <app-layout>
    <div class="col-12 col-md-8 m-auto">
      <div class="row">
        <div class="col-12 d-flex align-items-center justify-content-between">
          <h4 class="no-gutters">Edit Order Number {{order.OrderNumber}}</h4>
          <a :href="this.route('orders.index')" class="btn btn-sm btn-danger">Cancel</a>
        </div>
        <div class="col-12">
          <hr>
        </div>
      </div>
      <form class="update-order-form" @submit.prevent="submit">
        <div class="form-group">
          <label>Customer</label>
          <select class="form-control form-control-sm" v-model="form.CustomerId">
            <option disabled value="">Choose Customer</option>
            <option v-for="customer in customers" v-bind:value="customer.id">
              {{ customer.FirstName + ' ' + customer.LastName }}
            </option>
          </select>
          <div class="text-danger" v-if="$page.props.errors.CustomerId">{{ $page.props.errors.CustomerId }}</div>
        </div>
        <div class="form-group">
          <label>Date</label>
          <input class="form-control form-control-sm" type="date" v-model="form.OrderDate">
          <div class="text-danger" v-if="$page.props.errors.OrderDate">{{ $page.props.errors.OrderDate }}</div>
        </div>
        <button type="button" class="btn btn-sm btn-success" @click="update(form)">
          Update
        </button>
      </form>
      <div class="row">
        <div class="col-12 d-flex align-items-center justify-content-between">
          <div>
            <h4 class="no-gutters">Order Items</h4>
            <p class="no-gutters">Total Amount: {{order.TotalAmount}}</p>
          </div>
          <b-button class="btn-sm" v-b-modal.orderItemModal>Add Product</b-button>
        </div>
        <div class="col-12">
          <hr>
        </div>
      </div>
      <order-items-data-table :orderItems="order.order_items" :products="products" :orderId="order.id" />
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import OrderItemsDataTable from '@/Pages/Orders/Items/DataTable'
export default {
  components: {
      AppLayout,
      OrderItemsDataTable,
  },
  props: [
    'customers',
    'order',
    'products'
  ],
  data() {
    return {
      form: this.$inertia.form({
        CustomerId: this.order.CustomerId,
        OrderDate: this.order.OrderDate
      }),
    }
  },
  methods: {
    update: function (data)
    {
        data._method = 'PUT';
        this.$inertia.post(this.route('orders.update', this.order.id), data)
    }
  }
}
</script>
<style lang="css" scoped>
  .update-order-form {
    margin-bottom: 30px;
  }
</style>
