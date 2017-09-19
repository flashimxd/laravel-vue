import appConfing from './services/appConfig';
require('materialize-css');

window.Vue = require('vue');

require('vue-resource');

Vue.http.options.root = appConfing.api_url;

require('./services/inteceptors');

require('./router');
