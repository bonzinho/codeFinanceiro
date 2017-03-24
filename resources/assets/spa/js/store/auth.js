import JwtToken from '../services/jwt-token';
import LocalStorage from '../services/localStorage';  // importar o ficheiro do localstorage para o gerir
import {User} from '../services/resources';

const USER = 'user'; // valor que vai ser guardado no local storage

//estado da aplicação
const state = {
    user: LocalStorage.getObject(USER) || {name: ''},
    check: JwtToken.token != null  //guarda true ou false
}

const mutations = {
    setUser(state, user){ //acedemos à constante state
        state.user = user;
        if(user != null){
            LocalStorage.setObject(USER, user);
        }else{
            LocalStorage.remove(USER);
        }

    },
    authenticated(state){
        state.check = true;
    },
    unauthenticated(state){
        state.check = false;
    }

}

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
    },
    clearAuth(context){
        context.commit('unauthenticated');
        context.commit('setUser', null); // passa nul para fazer logout
    },
    logout(context){
        let afterLogout = (response) => {
            context.dispatch('clearAuth');
            return response;
        };
        return JwtToken.revokeToken()
            .then(afterLogout)
            .catch(afterLogout);

    }

}
const module = {
    state, mutations, actions
}
export default module;