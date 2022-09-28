<template>
  <div class="page-wrapper">
    <div class="page-content--bge5">
      <div class="container">
        <div class="login-wrap">
          <div class="login-content">
            <div class="login-logo">
              <a href="#">
                <img src="~/assets/images/icon/logo.png" alt="ИТ Иммунитет">
              </a>
            </div>
            <div class="login-form">
              <form method="post">
                <div class="form-group">
                  <label>Адрес Email</label>
                  <input class="au-input au-input--full" type="text" v-model="model.email" placeholder="Email">
                  <div class="alert alert-danger" v-if="form.errors['email']">
                    {{ form.errors['email'][0] }}
                  </div>
                </div>
                <button class="au-btn au-btn--block au-btn--green m-b-20" type="button" v-on:click="submit">Восстановить</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import {$axios} from "@/shared/utils/api";

export default  {
  auth: false,
  name: 'ForgotPassword',
  data() {
    return {
      form: {
        error: false,
        errors: []
      },
      model: {
        email: '',
      }
    }
  },
  methods: {
    submit() {
      $axios.post('/api/auth/remind-password', {
        ...this.model
      }).then(
        (result) => {
          this.$router.push({
            path: '/login'
          })
        }
      ).catch((error) => {
        const result = error.response.data;
        this.form.errors = result.errors;
        this.form.error = true;
      });
    }
  }
}
</script>
