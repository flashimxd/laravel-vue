import appConfing from './services/appConfig';
require('materialize-css');

window.Vue = require('vue');

require('vue-resource');
require('vuex');

Vue.http.options.root = appConfing.api_url;

require('./filters');
require('./validators');
require('./services/inteceptors');
require('./router');