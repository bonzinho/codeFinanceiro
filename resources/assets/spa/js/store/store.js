import Vuex from 'vuex'; //instancia do vuex com o vu.js
import auth from './auth'; // importar o modulo de vuex auth.js
import bank from './bank-account'; // importar modulo de contas bancarias


// temos de registar todos os modulos criados para pode usar a nossa fonte da verdade e todos os modulos associados
export default new Vuex.Store({
    modules: {
        auth, bankAccount
    }
});