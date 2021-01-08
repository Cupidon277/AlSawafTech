<template>
  <div>
    <b-modal id="productModal" title="New Product">
      <form @submit.prevent="submit">
        <div class="row form-group">
          <div class="col-12">
            <label for="productName">Product Name:</label>
          </div>
          <div class="col-12">
            <input class="form-control form-control-sm" id="productName" v-model="form.ProductName" />
            <div class="text-danger" v-if="$page.props.errors.ProductName">{{ $page.props.errors.ProductName }}</div>
          </div>
        </div>
        <div class="row form-group">
          <div class="col-12">
            <label for="supplier">Supplier:</label>
          </div>
          <div class="col-12">
            <select id="supplier" class="form-control form-control-sm" v-model="form.SupplierId">
              <option disabled value="">Choose Supplier</option>
              <option v-for="supplier in suppliers" v-bind:value="supplier.id">
                {{ supplier.CompanyName }}
              </option>
            </select>
            <div class="text-danger" v-if="$page.props.errors.SupplierId">{{ $page.props.errors.SupplierId }}</div>
          </div>
        </div>
        <div class="form-group">
          <label for="unitPrice">Unit Price:</label>
          <input class="form-control form-control-sm" id="unitPrice" v-model="form.UnitPrice" />
          <div class="text-danger" v-if="$page.props.errors.UnitPrice">{{ $page.props.errors.UnitPrice }}</div>
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
    'suppliers'
  ],
  data() {
    return {
      form: this.$inertia.form({
        ProductName: null,
        SupplierId: "",
        UnitPrice: null,
      }),
    }
  },
  methods: {
    closeModal: function ()
    {
      this.$bvModal.hide('productModal');
      this.changeModalState({isOpen: false});
      this.changeModalState({editMode: false});
      //
      this.form.ProductName = null;
      this.form.SupplierId = "";
      this.form.UnitPrice = null;

    },
    save: function (data)
    {
        data._method = 'POST';
        this.$inertia.post(this.route('products.store'), data, {
          onSuccess: () => {
            this.closeModal()
          }
        });
    },
    update: function (data)
    {
        data._method = 'PUT';
        this.$inertia.post(this.route('products.update', data.id), data, {
          onSuccess: () => {
            this.closeModal()
          }
        })
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
