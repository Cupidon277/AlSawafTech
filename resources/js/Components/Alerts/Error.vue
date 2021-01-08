<template lang="html">
  <div class="alert alert-danger">
    {{message}}
  </div>
</template>

<script>
export default {
  props: [
    'message'
  ]
}
</script>

<style lang="css" scoped>
</style>
