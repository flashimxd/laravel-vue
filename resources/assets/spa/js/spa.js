import localStorage from './services/localStorage';
require('materialize-css');

window.Vue = require('vue');

require('vue-resource');

Vue.http.options.root = 'http://localhost:8080/api';

require('./router');

localStorage.set('nome', 'rangel netto');
console.log(localStorage.get('nome'));
console.log(localStorage.setObject('oloko', {id: 15, name: 'no name guy 2 ss'}));
//console.log(localStorage.getObject('oloko'));

