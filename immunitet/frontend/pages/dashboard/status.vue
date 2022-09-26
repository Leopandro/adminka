<template>
  <div class="section__content section__content--p30">
    <div class="container-fluid">
      <div class="row">

      </div>


      <div class="row m-t-25">
        <div class="col-sm-6 col-lg-3">
          <div class="overview-item overview-item--c2">
            <div class="overview__inner">
              <div class="overview-box clearfix">
                <div class="icon">
                  <i class="zmdi zmdi-cloud"></i>
                </div>
                <div class="text">
                  <h2>98%</h2>
                  <span>ИТ периметр</span>
                </div>
              </div>
              <div class="overview-chart"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                <canvas id="widgetChartCommon" height="230" style="display: block; height: 115px; width: 210px;" width="420" class="chartjs-render-monitor"></canvas>
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="overview-item overview-item--c2">
            <div class="overview__inner">
              <div class="overview-box clearfix">
                <div class="icon">
                  <i class="zmdi zmdi-http"></i>
                </div>
                <div class="text">
                  <h2>98%</h2>
                  <span>Веб-сайты</span>
                </div>
              </div>
              <div class="overview-chart"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                <canvas id="widgetChartWeb" height="230" style="display: block; height: 115px; width: 210px;" width="420" class="chartjs-render-monitor"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="overview-item overview-item--c2">
            <div class="overview__inner">
              <div class="overview-box clearfix">
                <div class="icon">
                  <i class="zmdi zmdi-email-open"></i>
                </div>
                <div class="text">
                  <h2>Не обнаружено</h2>
                  <span>Почтовых систем</span>
                </div>
              </div>
              <div class="overview-chart"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                <canvas id="widgetChartMail" height="230" style="display: block; height: 115px; width: 210px;" width="420" class="chartjs-render-monitor"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="overview-item overview-item--c2">
            <div class="overview__inner">
              <div class="overview-box clearfix">
                <div class="icon">
                  <i class="zmdi zmdi-phone-sip"></i>
                </div>
                <div class="text">
                  <h2>Не обнаружено</h2>
                  <span>Систем телефонии</span>
                </div>
              </div>
              <div class="overview-chart"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                <canvas id="widgetChartPhone" height="230" style="display: block; height: 115px; width: 210px;" width="420" class="chartjs-render-monitor"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row m-t-25">
        <div class="col-sm-6 col-lg-3">
          <div class="overview-item overview-item--c2">
            <div class="overview__inner">
              <div class="overview-box clearfix">
                <div class="icon">
                  <i class="zmdi zmdi-dns"></i>
                </div>
                <div class="text">
                  <h2>Не обнаружено</h2>
                  <span>Систем управления доменами</span>
                </div>
              </div>
              <div class="overview-chart"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                <canvas id="widgetChartDomain" height="230" style="display: block; height: 115px; width: 210px;" width="420" class="chartjs-render-monitor"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="overview-item overview-item--c2">
            <div class="overview__inner">
              <div class="overview-box clearfix">
                <div class="icon">
                  <i class="zmdi zmdi-router"></i>
                </div>
                <div class="text">
                  <h2>97%</h2>
                  <span>Шлюзы</span>
                </div>
              </div>
              <div class="overview-chart"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                <canvas id="widgetChartGates" height="230" style="display: block; height: 115px; width: 210px;" width="420" class="chartjs-render-monitor"></canvas>
              </div>
            </div>
          </div>
        </div>


        <div class="col-sm-6 col-lg-3">
          <div class="overview-item overview-item--c2">
            <div class="overview__inner">
              <div class="overview-box clearfix">
                <div class="icon">
                  <i class="zmdi zmdi-network-setting"></i>
                </div>
                <div class="text">
                  <h2>Не обнаружено</h2>
                  <span>Сетевых устройств</span>
                </div>
              </div>
              <div class="overview-chart"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                <canvas id="widgetChartNet" height="230" style="display: block; height: 115px; width: 210px;" width="420" class="chartjs-render-monitor"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="overview-item overview-item--c2">
            <div class="overview__inner">
              <div class="overview-box clearfix">
                <div class="icon">
                  <i class="zmdi zmdi-favorite"></i>
                </div>
                <div class="text">
                  <h2>100%</h2>
                  <span>Общие</span>
                </div>
              </div>
              <div class="overview-chart"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                <canvas id="widgetChartNA" height="230" style="display: block; height: 115px; width: 210px;" width="420" class="chartjs-render-monitor"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>



      <div class="row m-t-25">
        <div class="col-sm-6 col-lg-3">
          <div class="overview-item overview-item--c2">
            <div class="overview__inner">
              <div class="overview-box clearfix">
                <div class="icon">
                  <i class="zmdi zmdi-file-text"></i>
                </div>
                <div class="text">
                  <h2>100%</h2>
                  <span>Бэкенд</span>
                </div>
              </div>
              <div class="overview-chart"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                <canvas id="widgetChartBackEnd" height="230" style="display: block; height: 115px; width: 210px;" width="420" class="chartjs-render-monitor"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="overview-item overview-item--c2">
            <div class="overview__inner">
              <div class="overview-box clearfix">
                <div class="icon">
                  <i class="zmdi zmdi-laptop"></i>
                </div>
                <div class="text">
                  <h2>100%</h2>
                  <span>Разработка</span>
                </div>
              </div>
              <div class="overview-chart"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                <canvas id="widgetChartDev" height="230" style="display: block; height: 115px; width: 210px;" width="420" class="chartjs-render-monitor"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="overview-item overview-item--c2">
            <div class="overview__inner">
              <div class="overview-box clearfix">
                <div class="icon">
                  <i class="zmdi zmdi-storage"></i>
                </div>
                <div class="text">
                  <h2>88%</h2>
                  <span>Данные</span>
                </div>
              </div>
              <div class="overview-chart"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                <canvas id="widgetChartData" height="230" style="display: block; height: 115px; width: 210px;" width="420" class="chartjs-render-monitor"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="overview-item overview-item--c2">
            <div class="overview__inner">
              <div class="overview-box clearfix">
                <div class="icon">
                  <i class="zmdi zmdi-balance-wallet"></i>
                </div>
                <div class="text">
                  <h2>Не обнаружено</h2>
                  <span>Финансовых систем</span>
                </div>
              </div>
              <div class="overview-chart"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                <canvas id="widgetChartFin" height="230" style="display: block; height: 115px; width: 210px;" width="420" class="chartjs-render-monitor"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="row">

      </div>




      <div class="row">
      </div>
      <div class="row">
      </div>
    </div>
  </div>
</template>

<script>
export default {
  auth: true,
  name: 'DashboardStatus',
  layout: 'dashboard',
  async asyncData() {
  },
  mounted() {
    console.log(this.$auth.loggedIn);
  }
}
</script>
