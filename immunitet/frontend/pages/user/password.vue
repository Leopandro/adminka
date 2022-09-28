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
                  <label>Текущий пароль</label>
                  <input class="au-input au-input--full" type="password" v-model="model.currentPassword" placeholder="Password">
                  <div class="alert alert-danger" v-if="form.errors['currentPassword']">
                    {{ form.errors['currentPassword'][0] }}
                  </div>
                </div>
                <div class="form-group">
                  <label>Новый пароль</label>
                  <input class="au-input au-input--full" type="password" v-model="model.newPassword" placeholder="Password">
                  <div class="alert alert-danger" v-if="form.errors['newPassword']">
                    {{ form.errors['newPassword'][0] }}
                  </div>
                </div>
                <div class="form-group">
                  <label>Повторите пароль</label>
                  <input class="au-input au-input--full" type="password" v-model="model.confirmNewPassword" placeholder="Password">
                  <div class="alert alert-danger" v-if="form.errors['confirmNewPassword']">
                    {{ form.errors['confirmNewPassword'][0] }}
                  </div>
                </div>
                <button class="au-btn au-btn--block au-btn--green m-b-20" v-on:click="submit" type="button">Сохранить</button>
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

export default {
  auth: true,
  name: 'UserPassword',
  layout: 'dashboard',
  data() {
    return {
      model: {
        currentPassword: '',
        newPassword: '',
        confirmNewPassword: ''
      },
      form: {
        errors: [],
        error:false
      }
    }
  },
  async asyncData() {
  },
  mounted() {
    console.log(this.$auth.loggedIn);
  },
  methods: {
    submit() {
      $axios.post('/api/auth/change-password', {
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
