import LoginComponent from './components/Login.vue';
import LogoutComponent from './components/Logout.vue';
import DashboardComponent from './components/Dashboard.vue';

export default{
    '/login':{
        name: 'auth.login',
        component: LoginComponent,
        auth: false // para acessar a esta rota NÂO È necessario estar autenticado      
    },

    '/logout':{
        name: 'auth.logout',
        component: LogoutComponent,
        auth: true // para acessar a esta rota É necessario estar autenticado     

    },

    '/dashboard':{
        name: 'dashboard',
        component: DashboardComponent,
        auth: true // para acessar a esta rota É necessario estar autenticado       
    },
    
}
