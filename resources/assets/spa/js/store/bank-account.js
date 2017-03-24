import {BankAccount} from '../services/resources';



//estado da aplicação
const state = {
    bankAccounts: [],
    bankAccountDelete: null,
}

const mutations = {
    set(state, bankAccounts){ //acedemos à constante state
        state.bankAccounts = bankAccounts

    },
    setDelete(state, bankAccount){
      state.bankAccountDelete = bankAccount;
    },
    'delete'(state){
        atate.bankAccounts.$remove(state.bankAccountDelete);
    }

}

const actions = {
    //lista de contas bancarias
    query(context, {pagination, order, search}){  //context é a instancia do proprio store
        return BankAccount.query({
            page: pagination.current_page + 1,
            orderBy: order.key,
            sortedBy: order.sort,
            search: search,
            include: 'bank'
        }).then((response) => {
            context.commit('set', response.data.data);  //data.data por causa do fractal
            let pagination_ = response.data.meta.pagination;
            pagination_.current_page--; // para subtrair 1 ao valor e ficar certo com a posição do array
            pagination_ = pagination_; //dados do meta vindos do jason, (verificar postman)
        });
    },

}
const module = {
    state, mutations, actions
}
export default module;