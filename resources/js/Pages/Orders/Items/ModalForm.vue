<template>
  <div>
    <b-modal id="orderItemModal" title="Add Product">
      <form @submit.prevent="submit">
        <div class="row form-group">
          <input hidden type="text" v-model="form.OrderId">
          <div class="col-12">
            <label>Product:</label>
          </div>
          <div class="col-12">
            <select class="form-control form-control-sm" v-model="form.ProductId">
              <option disabled value="">Choose Product</option>
              <option v-for="product in products" v-bind:value="product.id">
                {{ product.ProductName +' ('+product.UnitPrice+')' }}
              </option>
            </select>
            <div class="text-danger" v-if="$page.props.errors.ProductId">{{ $page.props.errors.ProductId }}</div>
          </div>
        </div>
        <div class="form-group">
          <label>Quantity:</label>
          <input class="form-control form-control-sm" v-model="form.Quantity" />
          <div class="text-danger" v-if="$page.props.errors.Quantity">{{ $page.props.errors.Quantity }}</div>
        </div>
      </form>
      <template #modal-footer>
        <button type="button" class="btn btn-sm btn-success" v-show="!editMode" @click="save(form)">
          Save
        </button>
        <button type="button" class="btn btn-sm btn-success" v-show="editMode" @click="update(form)">
          Update
        </button>
        <button @click="closeModal()" type="button" class="btn btn-sm btn-danger">
          Cancel
        </button>
      </template>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: [
    'editMode',
    'isOpen',
    'products',
    'orderId'
  ],
  data() {
    return {
      form: this.$inertia.form({
        ProductId: "",
        Quantity: null,
        OrderId: this.orderId
      }),
    }
  },
  methods: {
    closeModal: function ()
    {
      this.$bvModal.hide('orderItemModal');
      this.changeModalState({isOpen: false});
      this.changeModalState({editMode: false});
      //
      this.form.ProductId = "";
      this.form.Quantity = null;
    },
    save: function (data)
    {
        data._method = 'POST';
        this.$inertia.post(this.route('order-items.store'), data, {
          onSuccess: () => {
            this.closeModal();
          }
        });
    },
    update: function (data)
    {
        data._method = 'PUT';
        this.$inertia.post(this.route('order-items.update', data.id), data, {
          onSuccess: () => {
            this.closeModal();
          }
        });
    },
    changeModalState: function(data)
    {
        this.$emit('change-modal-state', data);
    }
  }
}
</script>
<style lang="css" scoped>
</style>
