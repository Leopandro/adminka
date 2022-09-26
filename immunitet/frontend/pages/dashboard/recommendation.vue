<template>
  <div class="section__content section__content--p30">
    <div class="container-fluid">
      <div class="row">

        <div class="col-md-4">
          <div class="card">
            <div class="card-header bg-secondary">
              <strong class="card-title text-light">Безотлагательная рекомендация</strong>
            </div>
            <div class="card-body text-white bg-danger">
              <p class="card-text text-light">Это пример безотлагательной рекомендации.
                Не выполнение ведет к рискам потери контроля за ИТ системой.
              </p>
              <footer class="blockquote-footer text-light">Рекомендация от
                <cite title="Source Title">Владимира Безопасина</cite>
              </footer>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card">
            <div class="card-header bg-secondary">
              <strong class="card-title text-light">Рекомендация к выполнению</strong>
            </div>
            <div class="card-body text-white bg-warning">
              <p class="card-text text-light">Перенести OpenSSH, внутрь периметра или закрыть VPN или закрыть файровлом.
                Не выполнение ведет к накоплению  рисков потери контроля за ИТ системой.
              </p>
              <footer class="blockquote-footer text-light">Рекомендация от
                <cite title="Source Title">Владимира Безопасина</cite>
              </footer>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card">
            <div class="card-header bg-secondary">
              <strong class="card-title text-light">Рекомендация к хорошему тону</strong>
            </div>
            <div class="card-body text-white bg-primary">
              <p class="card-text text-light">Не выставлять наружу TCP порты 9100 от prometheus или закрыть VPN или закрыть файровлом.
                Не выполнение ведет к накоплению рисков утечки данных из ИТ системы.
              </p>
              <footer class="blockquote-footer text-light">Рекомендация от
                <cite title="Source Title">Владимира Безопасина</cite>
              </footer>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
export default {
  auth: true,
  name: 'DashboardRecommendation',
  layout: 'dashboard',
  async asyncData() {
  },
  mounted() {
    console.log(this.$auth.loggedIn);
  }
}
</script>
