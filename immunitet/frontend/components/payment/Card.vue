<template>
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
            <select class="form-control" v-model="payment.sum">
              <option v-for="type of getPaymentTariffList()" v-bind:value="type.sum">{{type.type}}</option>
            </select>
          </div>
          <div class="form-group">
            <label for="cc-number" class="control-label mb-1">Номер карты</label>
            <input :value="card.cardNumber | formatCardNumber" @input="updateValue"
                   class="form-control cc-number identified visa" type="tel" inputmode="numeric"
                   pattern="[0-9\s]{13,19}" autocomplete="cc-number" maxlength="19" placeholder="xxxx xxxx xxxx xxxx">
            <span class="help-block" data-valmsg-for="cc-number" data-valmsg-replace="true"></span>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="cc-exp" class="control-label mb-1">Дата окончания</label>
                <div class="expiration">
                  <input v-model="card.expDateMonth" class="form-control expiration-date" autocomplete="off"
                         placeholder="MM" maxlength="2" size="2"/>
                  <span>/</span>
                  <input v-model="card.expDateYear" class="form-control expiration-date" autocomplete="off"
                         placeholder="YY" maxlength="2" size="2"/>
                </div>
              </div>
            </div>
            <div class="col-6">
              <label for="x_card_code" class="control-label mb-1">CVV</label>
              <div class="input-group">
                <input v-model="card.cvv" class="form-control cvv hidden-input" type="text" autocomplete="off"
                       maxlength="3" size="3">
              </div>
            </div>
          </div>
          <div class="row" v-if="paymentResult.visible">
            <div v-bind:class="paymentResult.class">
              {{ paymentResult.message }}
            </div>
          </div>
          <div>
            <button id="payment-button" v-on:click="initiateScript()" type="button"
                    class="btn btn-lg btn-info btn-block">
              <i class="fa fa-lock fa-lg"></i>&nbsp;
              <span>Перевести {{ payment.sum }}р.</span>
              <span id="payment-button-sending" style="display:none;">Отправка…</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  auth: true,
  name: 'PaymentCard',
  data() {
    return {
      paymentResult: {
        message: '',
        visible: false,
        class: ''
      },
      payment: {
        sum: 1000,
      },
      card: {
        cvv: '',
        cardNumber: '',
        expDateMonth: '',
        expDateYear: ''
      },
    }
  },
  filters: {
    formatCardNumber(value){
      return value ? value.match(/.{1,4}/g).join(' ') : '';
    }
  },
  methods: {
    updateValue(e) {
      this.card.cardNumber = e.target.value.replace(/ /g, '');
    },
    getPaymentTariffList() {
      return [
        {id: 1, type: 'free', sum: 1},
        {id: 2, type: '1000 руб', sum: 1000},
        {id: 3, type: '5000 руб', sum: 5000},
      ];
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
        .catch(errors => this.showErrorMessage('Ошибка: сессия истекла ' + Object.keys(errors)[0]))
    },
    handleResult(data) {
      console.log(data);
      const responseData = data.data;
      if (responseData.status === "need_3d_secure") {
        window.open(responseData.urlRedirect, '_blank').focus();
        this.showSuccessMessage(responseData.message);
      }
      if (data.success === true) {
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
