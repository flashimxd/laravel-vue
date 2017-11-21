import JwtToken from './jwt-token';
import store from '../store';
import appConfig from './appConfig';

Vue.http.interceptors.push((request, next) => {
    request.headers.set('Authorization', JwtToken.getAuthorizantionHeader());
    next();
});

Vue.http.interceptors.push((request, next) => {
    next((response) => {
        if(response.status === 401){
            return JwtToken.refreshToken()
                .then(() => {
                    return Vue.http(request);
                })
                .catch(() => {
                    store.dispatch('clearAuth');
                    window.location.href = appConfig.login_url
                });
        }
    })
})