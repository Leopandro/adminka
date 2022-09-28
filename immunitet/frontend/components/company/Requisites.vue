<template>
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <strong>Реквизиты компании</strong>
        <small> </small>
      </div>
      <div class="card-body card-block">
        <div class="form-group">
          <label for="company" class=" form-control-label">Названии организации</label>
          <input v-model="company.name" type="text" id="company" placeholder="ООО Ромашка-Пример" class="form-control">
          <div class="alert alert-danger" v-if="form.errors['name']">
            {{ form.errors['name'][0] }}
          </div>
        </div>
        <div class="form-group">
          <label for="vat" class=" form-control-label">ИНН</label>
          <input v-model="company.inn" type="text" id="vat" placeholder="XYZXXXXXXXX" class="form-control">
          <div class="alert alert-danger" v-if="form.errors['inn']">
            {{ form.errors['inn'][0] }}
          </div>
        </div>


        <div class="form-group">
          <label for="country" class=" form-control-label">Страна</label>
          <select v-model="company.country_id" class="form-control">
            <option v-for="country in country_list" v-bind:value="country.id">
              {{ country.name }}
            </option>
          </select>
          <div class="alert alert-danger" v-if="form.errors['country_id']">
            {{ form.errors['country_id'][0] }}
          </div>
        </div>

        <div class="row form-group">
          <div class="col-8">
            <div class="form-group">
              <label for="postal-code" class=" form-control-label">Почтовый Индекс</label>
              <input v-model="company.postcode" type="text" id="postal-code" placeholder="123123" class="form-control">
              <div class="alert alert-danger" v-if="form.errors['postcode']">
                {{ form.errors['postcode'][0] }}
              </div>
            </div>
          </div>
          <div class="col-8">
            <div class="form-group">
              <label for="city" class=" form-control-label">Город</label>
              <input v-model="company.city" type="text" id="city" placeholder="Город регистрации юр.лица"
                     class="form-control">
              <div class="alert alert-danger" v-if="form.errors['city']">
                {{ form.errors['city'][0] }}
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="street" class=" form-control-label">Адрес</label>
          <input v-model="company.address" type="text" id="street" placeholder="Юридический адрес" class="form-control">
          <div class="alert alert-danger" v-if="form.errors['address']">
            {{ form.errors['address'][0] }}
          </div>
        </div>
        <div class="card-footer">
          <button v-on:click="saveCompany()" type="button" class="btn btn-primary btn-sm">
            <i class="fa fa-dot-circle-o"></i> Сохранить
          </button>
          <button v-on:click="getCompany()" type="reset" class="btn btn-danger btn-sm">
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
  name: 'CompanyRequisites',
  data() {
    return {
      form: {
        error: false,
        errors: []
      },
      company: {
        name: '',
        inn: '',
        postcode: '',
        country_id: '',
        city: '',
        address: '',
      },
      country_list: [
        {id: 1, name: 'Армения'},
        {id: 2, name: 'Белоруссия'},
        {id: 3, name: 'Грузия'},
        {id: 4, name: 'Россия'},
        {id: 5, name: 'Казахстан'},
        {id: 6, name: 'Киргизия'},
        {id: 7, name: 'Таджикистан'},
        {id: 8, name: 'Украина'},
        {id: 8, name: 'Узбекистан'},
      ],
    }
  },
  methods: {
    async getCompany() {
      $axios
        .get('/api/company/get')
        .then((response) => {
          console.log(response);
          this.company = response.data.data;
        });
    },
    async saveCompany() {
      let company = this.company;
      $axios
        .post('/api/company/create', {
          ...company
        })
        .then((response) => {
          this.form.errors = [];
        }).catch((error) => {
        const result = error.response.data;
        this.form.errors = result.errors;
        this.form.error = true;
      });
    },
  },
  mounted() {
    this.getCompany();
    console.log(this.$auth.loggedIn);
  }
}

</script>
