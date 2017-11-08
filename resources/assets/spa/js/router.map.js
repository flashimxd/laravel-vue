import LoginComponent from './components/Login.vue';
import LogoutComponent from './components/Logout.vue';
import DashBoardComponent from './components/Dashboard.vue';
import BankAccountListComponent from './components/bank-account/BankAccountList.vue';
import BankAccountCreateComponent from './components/bank-account/BankAccountCreate.vue';
import BankAccountUpdateComponent from './components/bank-account/BankAccountUpdate.vue';
import CategoryListComponent from './components/category/CategoryList.vue';

export default {
    '/login': {
        name: 'auth.login',
        component: LoginComponent,
        auth: false
    },
    '/logout': {
        name: 'auth.logout',
        component: LogoutComponent,
        auth: true
    },
    '/dashboard': {
        name: 'dashboard',
        component: DashBoardComponent,
        auth: true
    },
    '/bank-accounts': {
        component: {template: "<router-view></router-view>"},
        subRoutes: {
            '/': {
                name: 'bank-account.list',
                component: BankAccountListComponent,
                auth: true
            },
            '/create': {
                name: 'bank-account.create',
                component: BankAccountCreateComponent,
                auth: true
            },
            '/:id/update': {
                name: 'bank-account.update',
                component: BankAccountUpdateComponent,
                auth: true
            }
        }
    },
    '/categories': {
        name: 'category.list',
        component: CategoryListComponent,
        auth: true

    }
}