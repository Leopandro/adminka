<template>
  <div class="section__content section__content--p30">
    <div class="container-fluid">
      <div class="row">
        <CompanyRequisites/>
        <PaymentCard/>
        <div class="row">
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  auth: true,
  name: 'DashboardPayment',
  layout: 'dashboard',
  data() {
    return {
    }
  },

  async asyncData() {
  },
  methods: {
  },
}
</script>
