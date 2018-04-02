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
    scope: 'customer'
  }

  axios.post(process.env.OAUTH_CLIENT_URL, data).then(res => {
    // Set session and axios token
    request.session.token = res.data.access_token
    axios.defaults.headers.common['Authorization'] = `Bearer ${res.data.access_token}`

    // Check if token is valid
    return axios.get(process.env.API_BASEURL + '/customers/me').then(customer => {
      return response.json({
        ...res.data,
        customer: customer.data
      })
    }).catch(error => {
      let res = error.response
      console.log(error)
      return response.status(res.status).json(res.data)
    })
  }).catch(error => {
    let res = error.response
    console.log(error)
    return response.status(res.status).json(res.data)
  })
})

// GET /api/logout
router.get('/logout', function (request, response) {
  delete request.session.token

  return response.json({ 'message': 'You have been successfully logged out!' })
})

module.exports = {
  path: '/api',
  handler: router
}
