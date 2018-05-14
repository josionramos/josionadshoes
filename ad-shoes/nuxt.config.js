const session = require('express-session')
const bodyParser = require('body-parser')

module.exports = {

  dev: true,/*(process.env.NODE_ENV !== 'production'),*/
  generate: {
    minify: false
  },
  /*
  ** Headers of the page
  */
  head: {
    titleTemplate: '%s - AD Shoes',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: 'AD Shoes traz coleções inovadoras aliadas a versatilidade e exclusividade, fazendo com que as clientes sejam únicas. A inspiração vem das jóias sendo utilizadas como acessórios para os calçados.' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css?family=Montserrat:100,300' }
    ]
  },
  router: {
    middleware: ['nav', 'checkout'],
    linkActiveClass: 'active'
  },
  /*
  ** Customize the progress bar color
  */
  loading: { color: '#d5b491', height: '5px' },
  /*
  ** Build configuration
  */
  build: {
    /*
    ** Run ESLint on save
    */
    extend (config, ctx) {
      if (ctx.isDev && ctx.isClient) {
        config.module.rules.push({
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules)/
        })

        config.module.rules.push({
          test: /\.(png|jpe?g|gif|svg)$/,
          loader: 'url-loader',
          query: {
            limit: 1000, // 1KO
            name: 'img/[name].[hash:7].[ext]'
          }
        })
      }
    },
    vendor: ['axios', 'moment', 'vanilla-masker']
  },
  css: [
    '~/assets/sass/style.sass'
  ],
  modules: [
    '@nuxtjs/dotenv'
  ],
  plugins: [
    '~/plugins/filters',
    '~/plugins/ui',
    '~/plugins/axios',
    '~/plugins/form'
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
