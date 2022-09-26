<template>
  <div class="section__content section__content--p30">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <strong>Cписок адресов для проверки</strong>
            </div>
            <div class="card-body card-block">
              <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="row form-group">
                  <div class="col col-md-3">
                    <label class=" form-control-label">Допустимые обозначения</label>
                  </div>
                  <div class="col-12 col-md-9">
                    <p class="form-control-static">Сайты, IP адреса, Подсети, Автономные системы</p>
                  </div>
                </div>

                <div class="row form-group">
                  <div class="col col-md-3">
                    <label for="textarea-input" class=" form-control-label">Список для мониторинга</label>
                  </div>
                  <div class="col-12 col-md-9">
                    <textarea name="textarea-input" id="textarea-input" rows="9" placeholder="https://wwww." class="form-control"></textarea>
                  </div>
                </div>

                <div class="row form-group">
                  <div class="col col-md-3">
                    <label for="file-input" class=" form-control-label">Загрузить список</label>
                  </div>
                  <div class="col-12 col-md-9">
                    <input type="file" id="file-input" name="file-input" class="form-control-file">
                  </div>
                </div>

                <div class="row form-group">
                  <div class="col col-md-3">
                    <label for="select" class=" form-control-label">Период</label>
                  </div>
                  <div class="col-12 col-md-9">
                    <select name="select" id="select" class="form-control">
                      <option value="0">Пожалуйста сделйте выбор</option>
                      <option value="1">1 раз в неделю</option>
                      <option value="2">1 раз в сутки</option>
                      <option value="3">Непрерывный (Рекомендовано)</option>
                    </select>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col col-md-3">
                    <label for="disabledSelect" class=" form-control-label">Расширенные возможности</label>
                  </div>
                  <div class="col-12 col-md-9">
                    <select name="disabledSelect" id="disabledSelect" disabled="" class="form-control">
                      <option value="0">Пожалуйста сделйте выбор</option>
                      <option value="1">Option #1</option>
                      <option value="2">Option #2</option>
                      <option value="3">Option #3</option>
                    </select>
                  </div>
                </div>
              </form>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa fa-dot-circle-o"></i> Сохранить
              </button>
              <button type="reset" class="btn btn-danger btn-sm">
                <i class="fa fa-ban"></i> Сбросить
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <strong>Список адресов для уведомлений</strong>
            </div>
            <div class="card-body card-block">
              <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="row form-group">
                  <div class="col col-md-3">
                    <label class=" form-control-label">Допустимые обозначения</label>
                  </div>
                  <div class="col-12 col-md-9">
                    <p class="form-control-static">Email адреса</p>
                  </div>
                </div>

                <div class="row form-group">
                  <div class="col col-md-3">
                    <label for="textarea-input" class=" form-control-label">Список Email адресов</label>
                  </div>
                  <div class="col-12 col-md-9">
                    <textarea name="textarea-input" id="textarea-input" rows="9" placeholder="username@example.org" class="form-control"></textarea>
                  </div>
                </div>

                <div class="row form-group">
                  <div class="col col-md-3">
                    <label for="file-input" class=" form-control-label">Загрузить список</label>
                  </div>
                  <div class="col-12 col-md-9">
                    <input type="file" id="file-input" name="file-input" class="form-control-file">
                  </div>
                </div>

                <div class="row form-group">
                  <div class="col col-md-3">
                    <label for="select" class=" form-control-label">Обязательность</label>
                  </div>
                  <div class="col-12 col-md-9">
                    <select name="select" id="select" class="form-control">
                      <option value="0">Пожалуйста сделйте выбор</option>
                      <option value="2">1 раз в сутки</option>
                      <option value="3">Незамедлительно (Рекомендовано)</option>
                    </select>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col col-md-3">
                    <label for="disabledSelect" class=" form-control-label">Расширенные возможности</label>
                  </div>
                  <div class="col-12 col-md-9">
                    <select name="disabledSelect" id="disabledSelect" disabled="" class="form-control">
                      <option value="0">Пожалуйста сделйте выбор</option>
                      <option value="1">Option #1</option>
                      <option value="2">Option #2</option>
                      <option value="3">Option #3</option>
                    </select>
                  </div>
                </div>
              </form>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa fa-dot-circle-o"></i> Сохранить
              </button>
              <button type="reset" class="btn btn-danger btn-sm">
                <i class="fa fa-ban"></i> Сбросить
              </button>
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
  name: 'DashboardConfiguration',
  layout: 'dashboard',
  async asyncData() {
  },
  mounted() {
    console.log(this.$auth.loggedIn);
  }
}
</script>
