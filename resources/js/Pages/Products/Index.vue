<template>
  <app-layout>
    <div class="col-12 col-md-8 m-auto">
      <data-table :products="products" :suppliers="suppliers"></data-table>
    </div>
  </app-layout>
</template>

<script>
  import AppLayout from '@/Layouts/AppLayout'
  import DataTable from '@/Pages/Products/DataTable'
  //
  export default {
      components: {
          AppLayout,
          DataTable
      },
      props: [
        'products',
        'suppliers'
      ]
  }
</script>
