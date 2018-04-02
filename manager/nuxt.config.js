const bodyParser = require('body-parser')
const session = require('express-session')

module.exports = {
  /*
  ** Headers of the page
  */
  head: {
    titleTemplate: '%s - Vertex',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: 'Nuxt.js project' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },
  /*
  ** Customize the progress bar color
  */
  loading: { color: '#6943d0' },
  router: {
    linkActiveClass: 'is-active'
  },
  /*
  ** Build configuration
  */
  build: {
    /*
    ** Run ESLint on save
    */
    extend (config, { isDev }) {
      if (isDev && process.client) {
        config.module.rules.push({
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules)/
        })
      }
    },
    vendor: ['axios', 'moment', 'slugify', 'lodash']
  },
  css: [
    '~/assets/sass/style.sass'
  ],
  modules: [
    '@nuxtjs/dotenv'
  ],
  plugins: [
    '~/plugins/ui',
    '~/plugins/axios',
    '~/plugins/auth',
    '~/plugins/buefy',
    '~/plugins/moment',
    '~/plugins/filters',
    { src: '~/plugins/quill-editor', ssr: false }
  ],
  serverMiddleware: [
    bodyParser.json(),
    session({
      secret: 'super-secret-key',
      resave: false,
      saveUninitialized: false,
      cookie: { maxAge: 900000000 }
    }),
    '~/api'
  ]
}
