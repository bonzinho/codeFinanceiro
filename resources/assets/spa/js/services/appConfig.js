import config from '../config'; // importa as configurações que são feitas automaticamente no ./resources/assets/spa/js/

const LOCATION = window.location;

let localConfig = {
    host: `${LOCATION.protocol}//${LOCATION.hostname}:${LOCATION.port}`,  //http://localhost:porta
    get login_url(){
        return `${this.host}${config.app_path}${config.login_path}`;
    }  
};

const appConfig = Object.assign({}, config, localConfig); // mescala dos dois ficheiros

export default appConfig 