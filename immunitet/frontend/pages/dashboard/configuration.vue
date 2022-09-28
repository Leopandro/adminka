<template>
  <div class="section__content section__content--p30">
    <div class="container-fluid">
      <div class="row">
        <Verify />
        <EmailNotification />
      </div>
    </div>
  </div>
</template>

<script>
import Verify from "~/components/configuration/SiteVerification";
import EmailNotification from "~/components/configuration/EmailNorification";
export default {
  components: {EmailNotification, Verify},
  auth: true,
  name: 'DashboardConfiguration',
  layout: 'dashboard',
  async asyncData() {
  },
  mounted() {
    console.log(this.$auth.loggedIn);
  }
}
</script>
