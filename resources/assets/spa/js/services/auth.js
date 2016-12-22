import JwtToken from './jwt-token';
import LocalStorage from './localStorage';  // importar o ficheiro do localstorage para o gerir
import {User} from '../services/resources';

const USER = 'user'; // valor que vai ser guardado no local storage

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
        let afterLogout = () => {
            this.clearAuth(); // limpa o token (função desta pagina)
        }        
        return JwtToken.revokeToken()
            .then(afterLogout())
            .catch(afterLogout());
    },
    clearAuth(){
        this.user.data = null;
        this.user.check = false;
    }
}