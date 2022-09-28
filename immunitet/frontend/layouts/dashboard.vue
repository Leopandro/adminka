<template>
  <div class="page-wrapper">
    <Aside />
    <div class="page-container">
      <!-- HEADER DESKTOP-->
      <header class="header-desktop">
        <div class="section__content section__content--p30">
          <div class="container-fluid">
            <div class="header-wrap">
              <form class="form-header" action="" method="POST">
                <input class="au-input au-input--xl" type="text" name="search" placeholder="Поиск по дате &amp; имени..." />
                <button class="au-btn--submit" type="submit">
                  <i class="zmdi zmdi-search"></i>
                </button>
              </form>
              <div class="header-button">
                <div class="noti-wrap">
                  <div class="noti__item js-item-menu">
                    <i class="zmdi zmdi-notifications"></i>
                    <span class="quantity">3</span>
                    <div class="notifi-dropdown js-dropdown">
                      <div class="notifi__title">
                        <p>У Вас 3 задачи</p>
                      </div>
                      <div class="notifi__item">
                        <div class="bg-c1 img-cir img-40">
                          <i class="zmdi zmdi-email-open"></i>
                        </div>
                        <div class="content">
                          <p>Задача 1</p>
                          <span class="date">14.09.2022 06:50</span>
                        </div>
                      </div>
                      <div class="notifi__item">
                        <div class="bg-c2 img-cir img-40">
                          <i class="zmdi zmdi-account-box"></i>
                        </div>
                        <div class="content">
                          <p>Задача 2</p>
                          <span class="date">14.09.2022 07:50</span>
                        </div>
                      </div>
                      <div class="notifi__item">
                        <div class="bg-c3 img-cir img-40">
                          <i class="zmdi zmdi-file-text"></i>
                        </div>
                        <div class="content">
                          <p>Задача 3</p>
                          <span class="date">14.09.2022 08:50</span>
                        </div>
                      </div>
                      <div class="notifi__footer">
                        <a href="#">Все задачи</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="account-wrap">
                  <div v-bind:class="dropDownMenuClass" v-on:click="toggleMenu($event)">
                    <div class="image">
                      <img src="~/assets/images/icon/avatar-01.jpg" v-bind:title="this.getUserNameSurname()" />
                    </div>
                    <div class="content">
                      <a class="js-acc-btn" href="#">{{ this.getUserNameSurname() }}</a>
                    </div>
                    <div class="account-dropdown js-dropdown">
                      <div class="info clearfix">
                        <div class="image">
                          <a href="#">
                            <img src="~/assets/images/icon/avatar-01.jpg" v-bind:alt="this.getUserNameSurname()" />
                          </a>
                        </div>
                        <div class="content">
                          <h5 class="name">
                            <a href="#">{{ this.getUserNameSurname() }}</a>
                          </h5>
                          <span class="email">{{  this.getUserEmail() }}</span>
                        </div>
                      </div>
                      <div class="account-dropdown__body">
                        <div class="account-dropdown__item">
                          <nuxt-link to="/user/password" prefetch><i class="zmdi zmdi-account"></i>Аккаунт</nuxt-link>
                        </div>
                        <div class="account-dropdown__item">
                          <nuxt-link to="/dashboard/configuration" prefetch><i class="zmdi zmdi-settings"></i>Настройки</nuxt-link>
                        </div>
                        <div class="account-dropdown__item">
                          <nuxt-link to="/dashboard/payment" prefetch><i class="zmdi zmdi-money-box"></i>Биллинг</nuxt-link>
                        </div>
                      </div>
                      <div class="account-dropdown__footer">
                        <a href="#" v-on:click="logout()">
                          <i class="zmdi zmdi-power"></i>Выход</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>
      <div class="main-content">
        <Nuxt />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  auth: true,
  name: 'DashboardLayout',
  data() {
    return {
      user: this.$auth.user,
      showTopMenu: false,
    };
  },
  methods: {
    logout: function() {
      this.$auth.logout().then(() => {
        this.$router.push({
          path: '/login'
        })
      });
    },
    toggleMenu: function(event) {
      this.showTopMenu = !this.showTopMenu;
    },
    getUserEmail: function() {
      let user = this.user;
      return user.email;
    },
    getUserNameSurname: function() {
      let user = this.user;
      return user.name + ' ' + user.surname;
    }
  },
  mounted() {
    console.log(this.$auth.user);
    console.log(this.$auth.strategy.token.get());
  },
  computed: {
    dropDownMenuClass: function() {
      return this.showTopMenu ? 'account-item clearfix js-item-menu show-dropdown' : 'account-item clearfix js-item-menu';
    }
  }
}
</script>
