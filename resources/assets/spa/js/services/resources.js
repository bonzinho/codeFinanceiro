export class Jwt{

    static accessToken(email, password){
        return Vue.http.post('access_token', {
            email: email,
            password: password
        });  // acede à nossa rota da API (../routes/api.php)
    }
    //logout
    static logout(){
        return Vue.http.post('logout'); //(../routes/api.php)
    }
    // refresh token (para quando o token expiar não ser necessário fazer login novamente)
    static refreshToken(){
        return Vue.http.post('refresh_token'); // estes Vue.http.post('****') são as nossas rotas definidas nas nossas rotas do laravel
    }
}

let User = Vue.resource('user');
let BankAccount = Vue.resource('bank_accounts'); // com o vue resource temos todas as operações put. delete update etc

export {User};
export {BankAccount};