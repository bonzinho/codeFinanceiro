import LoginComponent from './components/Login.vue';
import LogoutComponent from './components/Logout.vue';
import DashboardComponent from './components/Dashboard.vue';
import BankAccountListComponent from './components/bank-account/BankAccountList.vue';
import BankAccountCreateComponent from './components/bank-account/BankAccountCreate.vue';
import BankAccountUpdateComponent from './components/bank-account/BankAccountUpdate.vue';


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

    '/bank-accounts': {
        component:{template: "<router-view></router-view>"},
        subRoutes:{
            '/':{
                name:'bank-account.list',
                component: BankAccountListComponent,
                //auth:true
            },
            '/create':{
                name: 'bank-account.create',
                component: BankAccountCreateComponent
            },
            '/:id/update':{
                name: 'bank-account.update',
                component: BankAccountUpdateComponent
            }
        }
    },
    
}
