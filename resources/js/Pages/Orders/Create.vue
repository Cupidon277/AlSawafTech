<template>
  <app-layout>
    <div class="col-12 col-md-8 m-auto">
      <div class="row">
        <div class="col-12 d-flex align-items-center justify-content-between">
          <h4 class="no-gutters">Create New Order</h4>
        </div>
        <div class="col-12">
          <hr>
        </div>
      </div>
      <form @submit.prevent="submit">
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
        <button type="button" class="btn btn-sm btn-success" @click="save(form)">
          Save
        </button>
        <a :href="this.route('orders.index')" class="btn btn-sm btn-danger">Cancel</a>
      </form>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
export default {
  components: {
      AppLayout,
  },
  props: [
    'customers'
  ],
  data() {
    return {
      form: this.$inertia.form({
        CustomerId: "",
        OrderDate: null
      }),
    }
  },
  methods: {
    save: function (data)
    {
        this.$inertia.post(this.route('orders.store'), data);
    }
  }
}
</script>
<style lang="css" scoped>
</style>
