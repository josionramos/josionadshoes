require('dotenv').config()
const axios = require('axios')
const express = require('express')
const router = express.Router()

var app = express()

router.use((req, res, next) => {
  Object.setPrototypeOf(req, app.request)
  Object.setPrototypeOf(res, app.response)
  req.res = res
  res.req = req
  next()
})

// POST /api/login
router.post('/login', function (request, response) {
  let data = {
    grant_type: 'password',
    client_id: process.env.OAUTH_CLIENT_ID,
    client_secret: process.env.OAUTH_CLIENT_SECRET,
    username: request.body.email,
    password: request.body.password,
    scope: 'manager'
  }

  axios.post(process.env.OAUTH_CLIENT_URL, data).then(({ data }) => {
    // Set session and axios token
    request.session.token = data.access_token
    axios.defaults.headers.common['Authorization'] = `Bearer ${data.access_token}`


    return axios.get(process.env.API_BASEURL + '/users/me').then(res => {
      request.session.user = res.data

      return response.json({
        user: res.data,
        ...data
      })
    }).catch(error => {
      let res = error.response
      console.log(error)
      return response.status(res.status).json(res)
    })
  }).catch(error => {
    let res = error.response
    console.log(error)
    return response.status(res.status).json(res)
  })
})

// POST /api/logout
router.post('/logout', function (request, response) {
  delete request.session.token

  response.json({
    success: true
  })
})

module.exports = {
  path: '/api',
  handler: router
}
