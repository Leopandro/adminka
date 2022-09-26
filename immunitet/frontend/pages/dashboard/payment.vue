<template>
  <div class="section__content section__content--p30">
    <div class="container-fluid">
      <div class="row">

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
                  {{form.errors['name'][0]}}
                </div>
              </div>
              <div class="form-group">
                <label for="vat" class=" form-control-label">ИНН</label>
                <input v-model="company.inn" type="text" id="vat" placeholder="XYZXXXXXXXX" class="form-control">
                <div class="alert alert-danger" v-if="form.errors['inn']">
                  {{form.errors['inn'][0]}}
                </div>
              </div>


              <div class="form-group">
                <label for="country" class=" form-control-label">Страна</label>
                <select v-model="company.country_id" class="form-control">
                  <option v-for="country in country_list" v-bind:value="country.id">
                    {{country.name}}
                  </option>
                </select>
                <div class="alert alert-danger" v-if="form.errors['country_id']">
                  {{form.errors['country_id'][0]}}
                </div>
              </div>

              <div class="row form-group">
                <div class="col-8">
                  <div class="form-group">
                    <label for="postal-code" class=" form-control-label">Почтовый Индекс</label>
                    <input v-model="company.postcode" type="text" id="postal-code" placeholder="123123" class="form-control">
                    <div class="alert alert-danger" v-if="form.errors['postcode']">
                      {{form.errors['postcode'][0]}}
                    </div>
                  </div>
                </div>
                <div class="col-8">
                  <div class="form-group">
                    <label for="city" class=" form-control-label">Город</label>
                    <input v-model="company.city" type="text" id="city" placeholder="Город регистрации юр.лица" class="form-control">
                    <div class="alert alert-danger" v-if="form.errors['city']">
                      {{form.errors['city'][0]}}
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="street" class=" form-control-label">Адрес</label>
                <input v-model="company.address" type="text" id="street" placeholder="Юридический адрес" class="form-control">
                <div class="alert alert-danger" v-if="form.errors['address']">
                  {{form.errors['address'][0]}}
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

        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">Оплата</div>
            <div class="card-body">
              <div class="card-title">
                <h3 class="text-center title-2">Оплата картой</h3>
              </div>
              <hr>
              <form action="" method="post" novalidate="novalidate" autocomplete="off">
                <div class="form-group">
                  <label for="cc-payment" class="control-label mb-1">Сумма платежа</label>
                  <input v-model="payment.sum" type="text" class="form-control" aria-required="true" aria-invalid="false" value="5000.00">
                </div>
                <div class="form-group">
                  <label for="cc-number" class="control-label mb-1">Номер карты</label>
                  <input :value="card.cardNumber | formatCardNumber" @input="updateValue" class="form-control cc-number identified visa" type="tel" inputmode="numeric" pattern="[0-9\s]{13,19}" autocomplete="cc-number" maxlength="19" placeholder="xxxx xxxx xxxx xxxx">
                  <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
                </div>
                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label for="cc-exp" class="control-label mb-1">Дата окончания</label>
                      <div class="expiration">
                          <input v-model="card.expDateMonth" class="form-control expiration-date" autocomplete="off" placeholder="MM" maxlength="2" size="2" />
                          <span>/</span>
                          <input v-model="card.expDateYear" class="form-control expiration-date" autocomplete="off" placeholder="YY" maxlength="2" size="2" />
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <label for="x_card_code" class="control-label mb-1">CVV</label>
                    <div class="input-group">
                      <input v-model="card.cvv" class="form-control cvv hidden-input" type="text" autocomplete="off" maxlength="3" size="3">
                    </div>
                  </div>
                </div>
                <div class="row" v-if="paymentResult.visible">
                  <div v-bind:class="paymentResult.class">
                    {{paymentResult.message}}
                  </div>
                </div>
                <div>
                  <button id="payment-button" v-on:click="initiateScript()" type="button" class="btn btn-lg btn-info btn-block">
                    <i class="fa fa-lock fa-lg"></i>&nbsp;
                    <span>Перевести 5000р.</span>
                    <span id="payment-button-sending" style="display:none;">Отправка…</span>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="row">
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  auth: true,
  name: 'DashboardPayment',
  layout: 'dashboard',
  data() {
    return {
      form: {
        error: false,
        errors: []
      },
      paymentResult: {
        message: '',
        visible: false,
        class: ''
      },
      payment: {
        sum: 5000,
      },
      card: {
        cvv: '',
        cardNumber: '',
        expDateMonth: '',
        expDateYear: ''
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
  filters: {
    formatCardNumber(value){
      return value ? value.match(/.{1,4}/g).join(' ') : '';
    }
  },
  async asyncData() {
  },
  methods: {
    async getCompany() {
      this.$axios
        .get('/api/company/get')
        .then((response) => {
          console.log(response);
          this.company = response.data.data;
        });
    },
    async saveCompany() {
      let company = this.company;
      this.$axios
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
    async initiateScript() {
      const checkout = new cp.Checkout({
        publicId: 'pk_c9dd7043c7eafce25cba83f4fe502',
      });
      const parsedCardNumber = this.card.cardNumber.replace(/.{4}/g, '$& ');
      const fieldValues = {
        cvv: this.card.cvv,
        cardNumber: parsedCardNumber,
        expDateMonth: this.card.expDateMonth,
        expDateYear: this.card.expDateYear,
      }
      this.paymentResult.visible = false;
      this.paymentResult.message = '';
      checkout.createPaymentCryptogram(fieldValues)
        .then((cryptogram) => {
          console.log(cryptogram);
          this.initiatePaymentProcess({
            ...fieldValues,
            payment_cryptogram: cryptogram,
            sum: this.payment.sum
          })
        }).catch((errors) => {
        console.log();
        this.showErrorMessage('Неправильно введены банковские данные, проверьте правильность ввода: ' + Object.keys(errors)[0]);
      });
    },
    initiatePaymentProcess(paymentData) {
        this.$axios.post('/api/payment/cryptogram_payment', {
          ...paymentData
        }).then(response => this.handleResult(response.data))
          .catch(errors => console.log(errors))
    },
    handleResult(data) {
      console.log(data);
      const responseData = data.data;
      if (responseData.status === "need_3d_secure") {
        window.open(responseData.urlRedirect, '_blank').focus();
        this.showSuccessMessage(responseData.message);
      }
      if (data.success === false) {
        this.showErrorMessage(responseData.message);
      }
    },
    showSuccessMessage(message) {
      this.paymentResult.class = 'alert alert-success';
      this.paymentResult.message = message;
      this.paymentResult.visible = true;
    },
    showErrorMessage(message) {
      this.paymentResult.class = 'alert alert-danger';
      this.paymentResult.message = message;
      this.paymentResult.visible = true;
    },
    updateValue(e){
      this.card.cardNumber = e.target.value.replace(/ /g,'');
    }
  },
  mounted() {
    this.getCompany();
    console.log(this.$auth.loggedIn);
  }
}
</script>
<style>
@font-face {
  font-family: 'password';
  font-style: normal;
  font-weight: 400;
  src: url(https://jsbin-user-assets.s3.amazonaws.com/rafaelcastrocouto/password.ttf);
}
.hidden-input {
  font-family: 'password';
}
.cvv {
  width: 30%;
}
.expiration-date {
  width: 30%;
  display: inline-block;
}
</style>
