<template>
    <button type="button" @click="updateUser">Atualizar</button>
    {{user.name}}
</template>

<script>
    import store from '../store/store';
    export default {

        computed:{
            user(){
                return store.state.auth.user;
            }
        },

        methods:{
            updateUser(){
                store.commit('setUser', {name: 'Vitor andre'});
            }
        }

    }
</script>
