<template>
  <div class="row">
    <div class="col-12">
      <div class="row">
        <div class="col-12 d-flex align-items-center justify-content-between">
          <h4 class="no-gutters">Orders</h4>
          <a :href="route('orders.create')" class="btn btn-sm btn-secondary">Add New Order</a>
        </div>
        <div class="col-12">
          <hr>
        </div>
      </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Order Number</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Total</th>
            <th></th>
          </tr>
        </thead>
        <tr class="data-row" v-for="order in orders">
          <td>{{order.OrderNumber}}</td>
          <td>
            <i class="fa fa-user"></i>
            {{order.customer.FirstName + ' ' + order.customer.LastName}}
            <div v-if="order.customer.City || order.customer.Country">
              <i class="fa fa-map-marker"></i>
              <span>{{order.customer.City}}, {{order.customer.Country}}</span>
            </div>
            <div v-if="order.customer.Phone">
              <i class="fa fa-phone"></i>
              <a v-if="order.customer.Phone" :href="'tel:'+order.customer.Phone">{{order.customer.Phone}}</a>
            </div>
          </td>
          <td>{{order.OrderDate}}</td>
          <td>{{order.TotalAmount}}</td>
          <td width="75">
            <div class="action-cell">
              <a :href="route('orders.edit', order.id)" class="icon-btn btn btn-sm text-primary">
                <i class="fa fa-edit"></i>
              </a>
              <button @click="deleteRow(order)" title="Delete" class="icon-btn btn btn-sm text-danger">
                <i class="fa fa-trash"></i>
              </button>
            </div>
          </td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
    export default {
        props: ['orders'],
        components: {

        },
        data() {
            return {
            }
        },
        methods: {
          deleteRow: function (data)
          {
              if (!confirm('Are you sure want to remove?')) return;
              data._method = 'DELETE'
              this.$inertia.post(this.route('orders.destroy', data.id), data)
          }
        }
    }
</script>
