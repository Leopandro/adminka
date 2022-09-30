<template>
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <strong>Cписок адресов для проверки</strong>
        <small> </small>
      </div>
      <div class="card-body card-block">
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
            <textarea v-model="model.verification_list"  rows="9" placeholder="https://wwww." class="form-control"></textarea>
            <div class="alert alert-danger" v-if="form.errors['verification_list']">
              {{ form.errors['verification_list'][0] }}
            </div>
          </div>
        </div>
        <div class="row form-group">
          <div class="col col-md-3">
            <label for="file-input" class="form-control-label">Загрузить список сайтов</label>
          </div>
          <div class="col-12 col-md-9">
            <input @change="uploadFile" type="file"
                   name="file" ref="file" class="form-control-file">
          </div>
        </div>
        <div class="row form-group">
          <div class="col col-md-3">
            <label for="select" class=" form-control-label">Период</label>
          </div>
          <div class="col-12 col-md-9">
            <select v-model="model.period"  class="form-control">
              <option value="">Пожалуйста сделайте выбор</option>
              <option v-for="period of periodList" v-bind:value="period.type">{{ period.label }}</option>
            </select>
            <div class="alert alert-danger" v-if="form.errors['period']">
              {{ form.errors['period'][0] }}
            </div>
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

        <div class="row" v-if="queryResult.visible">
          <div v-bind:class="queryResult.class">
            {{ queryResult.message }}
          </div>
        </div>
        <div class="card-footer">
          <button v-on:click="save()" type="button" class="btn btn-primary btn-sm">
            <i class="fa fa-dot-circle-o"></i> Сохранить
          </button>
          <button v-on:click="get()" type="reset" class="btn btn-danger btn-sm">
            <i class="fa fa-ban"></i> Сбросить
          </button>
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
  auth: true,
  name: 'Verify',
  data() {
    return {
      queryResult: {
        message: '',
        visible: false,
        class: ''
      },
      form: {
        error: false,
        errors: []
      },
      periodList: [],
      file: null,
      model: {
        verification_list: '',
        period: '',
      },
    }
  },
  methods: {
    uploadFile(event) {
      const file = this.$refs.file.files[0];
      file.text().then((data) => {
        this.model.verification_list = data
      })
    },
    async getPeriodList() {
      $axios
        .get('/api/site-requisites/getPeriodList')
        .then((response) => {
          console.log(response);
          this.periodList = response.data.data;
        });
    },
    async get() {
      $axios
        .get('/api/site-requisites/get')
        .then((response) => {
          const modelData = response.data.data;
          modelData.verification_list = modelData.verification_list.join('\n');
          this.model = modelData;
        });
    },
    async save() {
      let model = this.model;
      this.queryResult.visible = false;
      $axios
        .post('/api/site-requisites/create', {
          ...model
        })
        .then((response) => {
          this.form.errors = [];
          this.showSuccessMessage("Успешно сохранено!");
        }).catch((error) => {
        const result = error.response.data;
        this.form.errors = result.errors;
        this.form.error = true;
      });
    },
    showSuccessMessage(message) {
      this.queryResult.class = 'alert alert-success';
      this.queryResult.message = message;
      this.queryResult.visible = true;
    },
    showErrorMessage(message) {
      this.queryResult.class = 'alert alert-danger';
      this.queryResult.message = message;
      this.queryResult.visible = true;
    },
  },
  mounted() {
    this.getPeriodList();
    this.get();
  }
}
</script>
