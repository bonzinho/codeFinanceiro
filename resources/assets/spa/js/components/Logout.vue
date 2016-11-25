<template>
    <div class="container">
        <div class="row">
            <div class="col s8 offset-s2 z-depth-2">
                <h4 class="center">A sair...</h4>               
                <div class="progress">
                    <div class="indeterminate"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
import Auth from '../services/auth';
    export default{
        ready(){
            setTimeout( () => {  // função deposis de a pagina estar carregada espera 1seg e envia para o logout
                this.logout();
            }, 1000);
        },
        methods: {
            logout(){
               let goToLogin = () => this.$router.go({name: 'auth.login'})
               Auth.logout()
                    .then(()=>goToLogin()) // se for válido
                    .catch(() => goToLogin()); // se não
            }
        }
    }

</script>