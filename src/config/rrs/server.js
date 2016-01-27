'use strict';

var express        = require('express');
var React          = require('react');
var ReactDOMServer = require('react-dom/server');
var app            = express();

require('babel-core/register');
require('dotenv').config();

console.log('Initalizing React Render Server.');

app.get('/', function(req, res) {

  var props = JSON.parse(req.query.props || '{}');

  try {
    var component = require('./src/' + req.query.component);
  } catch (e) {
    res.send(process.env.RRS_DEBUG ? e : '');
    return;
  }

  res.send(ReactDOMServer.renderToString(
    React.createElement(component, props)
  ));

});

app.listen(process.env.RRS_PORT);

console.log('React Render Server listening on port ' + process.env.RRS_PORT + '...');
