import colors from 'vuetify/es5/util/colors'

export default {
  server: {
    port: 3005 // default: 3000
  },
  watchQuery: ['page', 'order', 'q'],
  axios: {
    baseURL: process.env.NODE_ENV !== 'production' ? 'http://localhost:8000' : process.env.PRODUCTION_URL , // Used as fallback if no runtime config is provided
  },
  env: {
    baseUrl: process.env.BASE_URL || 'http://localhost:3000'
  },

  router: {
    middleware: [
      'auth',
    ],
  },

  auth: {
    strategies: {
      local: {
        endpoints: {
          login: {
            url: '/api/auth/login',
            method: 'post',
            propertyName: 'token',
          },
          user: {
            url: '/api/user/profile',
            method: 'get',
            propertyName: false,
            autoFetch: true
          },
          logout: false,
        },
      },
    }
  },

  // Disable server-side rendering: https://go.nuxtjs.dev/ssr-mode
  ssr: false,

  // Target: https://go.nuxtjs.dev/config-target
  target: 'static',

  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    titleTemplate: '%s - immunitet',
    title: 'immunitet',
    htmlAttrs: {
      lang: 'en'
    },
    script: [
      { hid: 'stripe', src: 'https://checkout.cloudpayments.ru/checkout.js', defer: true}
    ],
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' },
      { name: 'format-detection', content: 'telephone=no' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
    // Load a Node.js module directly (here it's a Sass file)
    // CSS file in the project
    '@/assets/font-face.css',
    '@/vendor/font-awesome-4.7/css/font-awesome.min.css',
    '@/vendor/font-awesome-5/css/fontawesome-all.min.css',
    '@/vendor/mdi-font/css/material-design-iconic-font.min.css',
    '@/vendor/bootstrap-4.1/bootstrap.min.css',
    '@/vendor/animsition/animsition.min.css',
    '@/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css',
    '@/vendor/wow/animate.css',
    '@/vendor/css-hamburgers/hamburgers.min.css',
    '@/vendor/slick/slick.css',
    '@/vendor/perfect-scrollbar/perfect-scrollbar.css',
    '@/assets/theme.css',
  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [

    './plugins/axios-interceptors.js',
    './plugins/axios-accessor.js',
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    // https://go.nuxtjs.dev/vuetify
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    '@nuxtjs/axios',
    '@nuxtjs/auth-next'
  ],

  middleware: ['auth'],

  // Vuetify module configuration: https://go.nuxtjs.dev/config-vuetify
  vuetify: {
    customVariables: false,
    theme: false
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
  }
}
