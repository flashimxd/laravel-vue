import config from '../config';

const location = window.location;

let configSpa = {
    host: `${location.protocol}//${location.hostname}:${location.port}`,
    get login_url(){
        return `${this.host}${config.app_path}${config.login_path}`;
    }
}

const localConfig = Object.assign({}, config, configSpa);

export default localConfig;