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
              <form accept-charset="UTF-8">
                <div class="form-group">
                  <label>Логин</label>
                  <input type="text"
                         v-model="login.login"
                         placeholder="Login"
                         class="au-input au-input--full"
                         name="login">
                </div>
                <div class="form-group">
                  <label>Пароль</label>
                  <input
                         v-model="login.password"
                         class="au-input au-input--full"
                         placeholder="Password"
                         required="required"
                         type="password"
                         name="password" >
                </div>
                <div class="login-checkbox">
                  <label>
                    <input type="checkbox" name="remember">Запомнить в браузере
                  </label>
                  <label>
                    <NuxtLink to="/auth/password-remind">Забыли пароль?</NuxtLink>
                  </label>
                </div>
                <div class="alert-danger m-b-15">{{error}}</div>
                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit" @click.stop.prevent="submit()">Войти</button>
              </form>
              <div class="register-link">
                <p>
                  У Вас есть доступ?
                  <NuxtLink to="/auth/register">Получить приват</NuxtLink>
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
const channelLogin = new BroadcastChannel('login');

export default {
  name: 'IndexPage',
  auth: false,
  data() {
    return {
      error: "",
      login: {
        login: '',
        password: ''
      }
    };
  },
  mounted() {
  },
  methods: {
    getDefaultLink() {
        return '/dashboard/status';
    },
    async submit() {
      console.log(this.login);
      await this.onLogin({...this.login})
    },
    async onLogin({ login, password }) {
        await this.$auth.login({
          data: {
            login,
            password,
          },
        }).then((response) => {
          channelLogin.postMessage({
            data: {
              login,
              password,
            },
          });
          this.$router.push(this.getDefaultLink());
        }).catch((AxiosError) => {
          this.error = AxiosError.response.data.message;
          return 1;
        });
    },
  }
}
</script>
