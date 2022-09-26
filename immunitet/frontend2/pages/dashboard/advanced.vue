<template>
  <div class="section__content section__content--p30">
  <div class="container-fluid">
    <div class="row m-t-30">
      <div class="col-md-12">
        <!-- DATA TABLE-->
        <div class="table-responsive m-b-40">
          <table class="table table-borderless table-data3">
            <thead>
            <tr>
              <th>Дата и Время</th>
              <th>Адрес хоста</th>
              <th>Имя сервиса</th>
              <th>CVE, БДУ, CNNVB</th>
              <th>Риск</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>2022-09-12 05:57</td>
              <td>crm.example.com</td>
              <td>OpenSSH</td>
              <td class="process">CVE-XYZZYZ</td>
              <td>7.9</td>
            </tr>
            <tr>
              <td>2022-09-12 07:22</td>
              <td>crm.example.com</td>
              <td>OpenSSH</td>
              <td class="process">CVE-XYZZYZ</td>
              <td>7.9</td>

            </tr>
            <tr>
              <td>2022-09-12 09:12</td>
              <td>crm.example.com</td>
              <td>OpenSSH</td>
              <td class="process">CVE-XYZZYZ</td>
              <td>7.9</td>

            </tr>
            <tr>
              <td>2022-09-12 23:06</td>
              <td>crm.example.com</td>
              <td>OpenSSH</td>
              <td class="process">CVE-XYZZYZ</td>
              <td>7.9</td>

            </tr>
            <tr>
              <td>2022-09-13 19:03</td>

              <td>crm.example.com</td>
              <td>OpenSSH</td>
              <td class="process">CVE-XYZZYZ</td>
              <td>7.9</td>

            </tr>
            <tr>
              <td>2022-09-13 19:57</td>

              <td>crm.example.com</td>
              <td>OpenSSH</td>
              <td class="process">CVE-XYZZYZ</td>
              <td>7.9</td>
            </tr>
            <tr>
              <td>2022-09-14 09:10</td>

              <td>crm.example.com</td>
              <td>OpenSSH</td>
              <td class="process">CVE-XYZZYZ</td>
              <td>7.9</td>
            </tr>
            <tr>
              <td>2022-09-14 10:43</td>

              <td>crm.example.com</td>
              <td>OpenSSH</td>
              <td class="process">CVE-XYZZYZ</td>
              <td>7.9</td>

            </tr>
            </tbody>
          </table>
        </div>
        <!-- END DATA TABLE-->
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <div class="au-card m-b-30">
          <div class="au-card-inner"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
            <h3 class="title-2 m-b-40">Общий ИТ Иммунитет</h3>
            <canvas id="lineChart" height="428" style="display: block; height: 214px; width: 428px;" width="856" class="chartjs-render-monitor"></canvas>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="au-card m-b-30">
          <div class="au-card-inner"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
            <h3 class="title-2 m-b-40">Радар - ИТ Иммунитет</h3>
            <canvas id="radarChart" height="570" style="display: block; height: 285px; width: 428px;" width="856" class="chartjs-render-monitor"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="row">

    </div>
  </div>
</div>
</template>

<script>
export default {
  auth: true,
  name: 'DashboardAdvanced',
  layout: 'dashboard',
  async asyncData() {
  },
  mounted() {
    console.log(this.$auth.loggedIn);
  }
}
</script>
