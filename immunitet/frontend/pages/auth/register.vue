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
                  <label>Имя пользователя</label>
                  <input class="au-input au-input--full" type="text" v-model="model.login" placeholder="Username">
                  <div class="alert alert-danger" v-if="form.errors['login']">
                    {{ form.errors['login'][0] }}
                  </div>
                </div>
                <div class="form-group">
                  <label>Адрес Email</label>
                  <input class="au-input au-input--full" type="text" v-model="model.email" placeholder="Email">
                  <div class="alert alert-danger" v-if="form.errors['email']">
                    {{ form.errors['email'][0] }}
                  </div>
                </div>
                <div class="form-group">
                  <label>Пароль</label>
                  <input class="au-input au-input--full" type="password" v-model="model.password" placeholder="Password">
                  <div class="alert alert-danger" v-if="form.errors['password']">
                    {{ form.errors['password'][0] }}
                  </div>
                </div>
                <div class="login-checkbox">
                  <label>
                    <input type="checkbox" v-model="model.agree">Согласен с условия использования
                  </label>
                </div>
                <button v-on:click="submit()" v-bind:disabled="model.agree === false" class="au-btn au-btn--block au-btn--green m-b-20" type="button">Регистрация</button>
              </form>
              <div class="register-link">
                <p>
                  У Вас есть доступ?
                  <a href="register.php">Получить приват</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</template>

<script>

import {
  $axios, handlerResponse,
} from '@/shared/utils/api';
export default {
  auth: false,
  name: 'Register',
  data() {
    return {
      form: {
        error: false,
        errors: []
      },
      model: {
        email: '',
        login: '',
        password: '',
        agree: false,
      }
    }
  },
  methods: {
    submit() {
      $axios.post('/api/auth/register', {
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
