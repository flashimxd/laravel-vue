import Auth from './auth';
import appConfig from './appConfig';

Vue.http.interceptors.push((request, next) => {
    request.headers.set('Authorization', Auth.getAuthorizantionHeader());
    next();
});

Vue.http.interceptors.push((request, next) => {
    next((response) => {
        if(response.status === 401){
            return Auth.refreshToken()
                .then(() => {
                    return Vue.http(request);
                })
                .catch(() => window.location.href = appConfig.login_url);
        }
    })
})