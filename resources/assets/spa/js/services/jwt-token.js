import {Jwt} from './resources'; // importat class class
import LocalStorage from './localStorage';  // importar o ficheiro do localstorage para o gerir

const TOKEN = 'token';
export default{
    get token(){
        return LocalStorage.get(TOKEN);
    },
    set token(value){
        // se existir o valor envia para o nosso localstorage se não tiver remove
        return value ? LocalStorage.set(TOKEN, value) : LocalStorage.remove(TOKEN);
    },
    accessToken(email, password){
        // envia a requisição e guarda o token no local storage
        return Jwt.accessToken(email, password).then((response) =>{
            this.token = response.data.token;
            return response;
        });
    },
    refreshToken(){
        return Jwt.refreshToken().then((response) => {
            this.token = response.data.token; // atribui o token novamente
            return response; //retorn a aresposta para o caso de ser necessario de fazer mais alguam coisa

        });
    },
    revokeToken(){
        let afterRevokeToken = (response) => {
            this.token = null; // limpa o token (função desta pagina)
            return response;
        }
        return Jwt.logout()
            .then(afterRevokeToken)
            .catch(afterRevokeToken);
    },
    //metodo para envio de tokencom o Bearer
    getAuthorizationHeader(){
        return `Bearer ${LocalStorage.get(TOKEN)}`;  // retorna o token necessario para enviar para o header
    },

}
