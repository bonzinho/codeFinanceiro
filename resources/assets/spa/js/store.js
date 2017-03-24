import JwtToken from './services/jwt-token';
import LocalStorage from './services/localStorage';  // importar o ficheiro do localstorage para o gerir
import {User} from './services/resources';
import Vuex from 'vuex'; //instancia do vuex com o vu.js

const USER = 'user'; // valor que vai ser guardado no local storage

const state = {
    user: LocalStorage.getObject(USER) || {name: ''},
    check: JwtToken.token != null
};

const mutations = {
    setUser(state, user){ //acedemos à constante state
      state.user = user;
      LocalStorage.setObject(USER, user);
    },
    authenticated(state){
      state.check = true;
    }

};

const actions = {
    login(context, {email, password}){  //context é a instancia do proprio store
        return JwtToken.accessToken(email, password).then((response) =>{ // executa o ajax
            context.commit('authenticated');
            context.dispatch('getUser');
            return response;
        });
    },
    getUser(context){
        return User.get().then((response) => {
                context.commit('setUser', response.data);
            });
    }
};

export default new Vuex.Store({state, mutations, actions});
/*
const afterLogin = function(response){  //esta constante serve para guardar a função de configuração do que aontece depois do login ser feito
    this.user.check = true;
    User.get()
        .then((response) => {
            this.user.data = response.data;
        }); // .then (a nossa promeça), adiciona ao localstorage no valor USER os dados que nos são enviado na requisição
};
export default{
    user: {
        set data(value){
            if(!value){
                LocalStorage.remove(USER);
                this._data = null;
                return;
            }
            this._data = value;
            LocalStorage.setObject(User, value);
        },
        get data(){
            if(!this._data){
                this._data = LocalStorage.getObject(User);
            }
            return this._data;
        },
        check: JwtToken.token ? true : false
    },
    login(email, password){
        return JwtToken.accessToken(email, password).then((response) =>{
            let afterLoginContext = afterLogin.bind(this);
            afterLoginContext(response); // emite a função de configuração afterLogin, se for sucesso corre a função e guarda os dados do USER no localstorage
            return response;
        });
    },
    logout(){
        let afterLogout = (response) => {
            this.clearAuth(); // limpa o token (função desta pagina)
            return response;
        };

        return JwtToken.revokeToken()
            .then(afterLogout)
            .catch(afterLogout);
    },
    clearAuth(){
        this.user.data = null;
        this.user.check = false;
    }
} */
