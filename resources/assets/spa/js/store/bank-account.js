import {BankAccount} from '../services/resources';
import SearchOptions from '../services/search-options';

const state = {
    bankAccounts:[],
    bankAccountDelete:null,
    searchOptions: new SearchOptions('bank')
};

const mutations = {
    set(state, bankAccounts) {
        state.bankAccounts = bankAccounts;
    },
    setDelete(state, bankAccount){
        state.bankAccountDelete = bankAccount;
    },
    'delete'(state){
        state.bankAccounts.$remove(state.bankAccountDelete);
    },
    setOrder(state, key){
        state.searchOptions.order.key = key;
    },
    setPagination(state, pagination){
      state.searchOptions.pagination = pagination;
    },
    setCurrentPage(state, page){
        state.searchOptions.pagination.current_page = page;
    },
    setFilter(state, filter){
        state.searchOptions.search = filter;
    }
};

const actions = {
    query(context){
        let searchOptions = context.state.searchOptions;
        return BankAccount.query(searchOptions.createOptions()).then((response) => {
            context.commit('set', response.data.data);
            context.commit('setPagination', response.data.meta.pagination);
        });
    },
    queryWithSortBy(context, key){
        context.commit('setOrder', key);
        context.dispatch('query');
    },
    queryWithPagination(context, page){
        context.commit('setCurrentPage', page);
        context.dispatch('query');
    },
    queryWithFilter(context){
        context.dispatch('query');
    }
}

const module = {state, mutations,actions};

export default module;