import Vuex from 'vuex';
import auth from './auth';
import bankAccount from './bank-account';
import bank from './bank';
import CategoryModule from './category';
import BillModule from './bill';
import { CategoryRevenue, CategoryExpense, BillPay} from '../services/resources';

let categoryRevenue = CategoryModule(), categoryExpense = CategoryModule();
let billPay = BillModule();

//Cada um vai ter uma instancia de resource, mas, a propriedade resource será diferente para cada módulo
categoryRevenue.state.resource = CategoryRevenue;
categoryExpense.state.resource = CategoryExpense;
billPay.state.resource = BillPay;

export default new Vuex.Store({
    modules: {
        auth,bankAccount, bank,
        categoryRevenue, categoryExpense, billPay
    }
});