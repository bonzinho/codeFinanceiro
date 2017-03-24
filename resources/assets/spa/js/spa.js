
import appConfig from './services/appConfig';  // importação do nosso ficheiro de configuração mesclado com o ficheiro de configuração atuomatico
//import Vuex from 'vuex';

require('materialize-css'); //load do css do materialize
window.Vue = require('vue');
//window.Vue.use(Vuex);
require('vue-resource');
require('vuex');
Vue.http.options.root = appConfig.api_url;  //variavel de configuração que vem do ficheiro ./services/appConfig


require('./services/interceptors'); //importaçaao do nosso ficheiro de interceptors
require('./router'); // ficheiro de configuração de rotas

//console.log(appConfig.login_url);



// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
