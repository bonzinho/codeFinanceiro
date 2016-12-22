<template>
    <div class="container">
        <div class="row">
            <div class="card-panel green lighten-3">
                <span class="green-text text-darken-2">
                    <h5>As minhas contas bancárias</h5>
                </span>
            </div>
            <table class="bordered striped highlight responsive-table z-depth-5">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Agência</th>
                    <th>C/C</th>
                    <th>Acções</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(index,o) in bankAccounts">
                    <td>&nbsp;{{ index + 1 }}</td>
                    <td>{{ o.name }}</td>
                    <td>{{ o.agency }}</td>
                    <td>{{ o.account }}</td>
                    <td>
                        <a v-link="{ name: 'bank-account.update', params: {id: o.id} }">Editar</a>
                        <a href="#" @click.prevent="openModalDelete(o)">Apagar</a>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="fixed-action-btn">
                <a class="btn-floating btn-large" href="http://google.pt"></a>
                <i class="large material-icons">add</i>
            </div>
        </div>
    </div>
    <modal :modal="modal">
        <div slot="content" v-if="bankAccountToDelete">
            <h4>Mensagem de confirmação</h4>
            <p><strong>Deseja apagar esta conta bancária?</strong></p>
            <div class="divider"></div>
            <p>Nome: <strong>{{ bankAccountToDelete.name }}</strong></p>
            <p>Agência: <strong>{{ bankAccountToDelete.agency }}</strong></p>
            <p>C/C: <strong>{{ bankAccountToDelete.account }}</strong></p>
            <div class="divider"></div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-flat waves-effect-green lighten-2 modal-close modal-action" @click="destroy()"> OK </button>
            <button class="btn btn-flat waves-effect waves-red modal-close modal-action"> Cancelar </button>
        </div>
    </modal>
</template>
<script>
    import { BankAccount } from '../../services/resources';
    import ModalComponent from '../../../../_default/components/Modal.vue';

    export default{
        components:{
            'modal': ModalComponent,
        },
        data(){
            return{
               bankAccounts: [],
               bankAccountToDelete: null,
               modal:{
                    id: 'modal-delete'
               }
            };
        },
        created(){
            BankAccount.query().then((response) => {
                this.bankAccounts = response.data.data;  //data.data por causa do fractal
            });
        },
        methods: {
            destroy(){
                BankAccount.delete({id: this.bankAccountToDelete.id}).then((response) => {
                    this.bankAccounts.$remove(this.bankAccountToDelete);
                    this.bankAccounttoDelete = null;
                    Materialize.toast('Conta bancária apagada com sucesso!', 4000);
                });
            },
            openModalDelete(bankAccount){
                this.bankAccountToDelete = bankAccount;
                $('#modal-delete').modal('open');
            },
        }
    };
</script>
