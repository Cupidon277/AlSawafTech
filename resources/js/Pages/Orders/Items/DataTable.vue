<template>
  <div class="row">
    <div class="col-12">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Product</th>
            <th>Unit Price</th>
            <th>Quantity</th>
            <th>Amount</th>
            <th></th>
          </tr>
        </thead>
        <tr class="data-row" v-for="orderItem in orderItems">
          <td>{{orderItem.product.ProductName}}</td>
          <td>{{orderItem.UnitPrice}}</td>
          <td>{{orderItem.Quantity}}</td>
          <td>{{orderItem.Quantity * orderItem.UnitPrice}}</td>
          <td width="75">
            <div class="action-cell">
              <button @click="edit(orderItem)" title="Edit" class="icon-btn btn btn-sm text-primary">
                <i class="fa fa-edit"></i>
              </button>
              <button @click="deleteRow(orderItem)" title="Delete" class="icon-btn btn btn-sm text-danger">
                <i class="fa fa-trash"></i>
              </button>
            </div>
          </td>
        </tr>
      </table>
      <modal-form ref="modalForm" @change-modal-state="changeModalState" :products="products" :isOpen.sync="isOpen" :editMode.sync="editMode" :orderId="orderId"></modal-form>
    </div>
  </div>
</template>

<script>
    import ModalForm from '@/Pages/Orders/Items/ModalForm'
    //
    export default {
        props: ['products', 'orderItems', 'orderId'],
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
              this.openModal('orderItemModal');
          },
          deleteRow: function (data)
          {
              if (!confirm('Are you sure want to remove?')) return;
              data._method = 'DELETE'
              this.$inertia.post(this.route('order-items.destroy', data.id), data)
          },
          changeModalState: function(data)
          {
            this.isOpen = data.isOpen;
            this.editMode = data.editMode;
          }
        }
    }
</script>
