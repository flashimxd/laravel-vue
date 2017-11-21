import appConfing from './services/appConfig';
//import Vuex from 'vuex';
require('materialize-css');

window.Vue = require('vue');

require('vue-resource');
require('vuex');

Vue.http.options.root = appConfing.api_url;

require('./services/inteceptors');

require('./router');
