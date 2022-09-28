<template>

</template>
<script>
export default {
  name: 'Index',
  mounted() {
    if (this.$auth.loggedIn) {
      this.$router.push({
        path: '/dashboard/payment'
      })
    } else {
      this.$router.push({
        path: '/login'
      })
    }
  }
}
</script>
