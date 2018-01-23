import Vuex from 'vuex';
import auth from './auth';
import bankAccount from './bank-account';
import bank from './bank';
import CategoryModule from './category';
import { CategoryRevenue, CategoryExpense} from '../services/resources';

let categoryRevenue = CategoryModule(), categoryExpense = CategoryModule();

//Cada um vai ter uma instancia de resource, mas, a propriedade resource será diferente para cada módulo
categoryRevenue.state.resource = CategoryRevenue;
categoryExpense.state.resource = CategoryExpense;

export default new Vuex.Store({
    modules: {
        auth,bankAccount, bank,
        categoryRevenue, categoryExpense
    }
});