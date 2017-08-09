import AppComponent from './components/App.vue';
import routerMap from './router.map';
import vueRouter from 'vue-router';

const router = new vueRouter();

router.map(routerMap);

router.start({
    components: {
        'app': AppComponent
    }
}, 'body');