<template>
  <app-layout>
    <div class="col-12 col-md-8 m-auto">
      <data-table :orders="orders"></data-table>
    </div>
  </app-layout>
</template>

<script>
  import AppLayout from '@/Layouts/AppLayout'
  import DataTable from '@/Pages/Orders/DataTable'
  //
  export default {
      components: {
          AppLayout,
          DataTable
      },
      props: [
        'orders',
      ]
  }
</script>
