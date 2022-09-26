<template>
  <div class="menu-sidebar__content js-scrollbar1">
    <nav class="navbar-sidebar">
      <ul class="list-unstyled navbar__list">
        <li>
          <nuxt-link to="/dashboard/status" prefetch><i class="fas fa-tachometer-alt"></i>Статус</nuxt-link>
        </li>
        <li>
          <nuxt-link to="/dashboard/advanced" prefetch><i class="fas fa-chart-bar"></i>Подробнее</nuxt-link>
        </li>
        <li>
          <nuxt-link to="/dashboard/recommendation" prefetch><i class="far fa-check-square"></i>Рекомендации</nuxt-link>
        </li>
        <li>
          <nuxt-link to="/dashboard/configuration" prefetch><i class="fas fa-calendar-alt"></i>Конфигурация</nuxt-link>
        </li>
        <li>
          <nuxt-link to="/dashboard/payment" prefetch><i class="fas fa-rouble"></i>Оплата</nuxt-link>
        </li>
        <li class="active has-sub">
          <a class="js-arrow" href="#">
            <i class="fas fa-copy"></i>Авторизация</a>
          <ul class="list-unstyled navbar__sub-list js-sub-list">
            <li>
              <a href="login.php">Вход</a>
            </li>
            <li>
              <a href="register.php">Регистрация</a>
            </li>
            <li>
              <a href="forget-pass.php">Забыл пароль</a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {
  name: 'Sidebar'
}
</script>
