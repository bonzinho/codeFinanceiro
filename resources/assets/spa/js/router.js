import AppComponent from './components/App.vue';
import routerMap from './router.map';
import VueRouter from 'vue-router';
import Auth from './services/auth'; 

const router = new VueRouter();

router.map(routerMap); // faz o mapeamento

//evento //permite que a transição seja capturada antes de ser feita (antes que a rota seja feita passa por aqui)
router.beforeEach(({to, next}) =>{
    if(to.auth && !Auth.user.check){
        return router.go({name: 'auth.login'});
    }   
    next(); // caso não entre na condição em cima significa que pode avançar      
}); 

router.start({
    components: {
        'app': AppComponent
    }
}, 'body');


