<template>
  <div class="row">
    <div class="col-12">
      <div class="row">
        <div class="col-12 d-flex align-items-center justify-content-between">
          <h4 class="no-gutters">Products</h4>
          <b-button class="btn-sm" @click="openModal('productModal')">Add New Product</b-button>
        </div>
        <div class="col-12">
          <hr>
        </div>
      </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Product Name</th>
            <th>Supplier</th>
            <th>Unit Price</th>
            <th></th>
          </tr>
        </thead>
        <tr class="data-row" v-for="product in products">
          <td>{{product.ProductName}}</td>
          <td>{{product.supplier.CompanyName}}</td>
          <td>{{product.UnitPrice}}</td>
          <td width="75">
            <div class="action-cell">
              <button @click="edit(product)" title="Edit" class="icon-btn btn btn-sm text-primary">
                <i class="fa fa-edit"></i>
              </button>
              <button @click="deleteRow(product)" title="Delete" class="icon-btn btn btn-sm text-danger">
                <i class="fa fa-trash"></i>
              </button>
            </div>
          </td>
        </tr>
      </table>
      <modal-form ref="modalForm" @change-modal-state="changeModalState" :suppliers="suppliers" :isOpen.sync="isOpen" :editMode.sync="editMode"></modal-form>
    </div>
  </div>
</template>

<script>
    import ModalForm from '@/Pages/Products/ModalForm'
    //
    export default {
        props: ['products', 'suppliers'],
        components: {
          ModalForm
        },
        data() {
            return {
                editMode: false,
                isOpen: false,
            }
        },
        methods: {
          openModal: function (modalId)
          {
            this.isOpen = true;
            this.$bvModal.show(modalId)
          },
          edit: function (data)
          {
              this.$refs.modalForm.form =  Object.assign({}, data);
              this.editMode = true;
              this.openModal('productModal');
          },
          deleteRow: function (data)
          {
              if (!confirm('Are you sure want to remove?')) return;
              data._method = 'DELETE'
              this.$inertia.post(this.route('products.destroy', data.id), data)
          },
          changeModalState: function(data)
          {
             this.isOpen = data.isOpen;
             this.editMode = data.editMode;
          }
        }
    }
</script>
