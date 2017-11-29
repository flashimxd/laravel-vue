import {BankAccount} from '../services/resources';
import SearchOptions from '../services/search-options';

const state = {
    bankAccounts:[],
    bankAccountDelete:null,
    bankAccountSave: {
        name: 'Minha conta',
        agency: '',
        account: '',
        bank_id: '',
        'default': false
    },
    searchOptions: new SearchOptions('bank')
};

const mutations = {
    updateName(state, name){
        state.bankAccountSave.name = name;
    },
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
        let sort = state.searchOptions.order.sort;
        state.searchOptions.order.sort = sort == 'desc'? 'asc' : 'desc';

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
    },
    'delete'(context){
        let id = context.state.bankAccountDelete.id;
        return BankAccount.delete({id: id}).then((response) => {
            context.commit('delete');
            context.commit('setDelete', null);

            let bankAccounts = context.state.bankAccounts;
            let pagination   =  context.state.searchOptions.pagination;
            if(bankAccounts.length === 0 && pagination.current_page > 0){
                context.commit('setCurrentPage', pagination.current_page--);
            }

            return response;
        });
    },
    save(context, bankAccount){
        return BankAccount.save({}, bankAccount).then((response)=> {
            return response;
        })
    },
    update(context, {id, bankAccount}){
        return BankAccount.update({id: id}, bankAccount).then((response)=> {
            return response;
        })
    }
}

const module = {namespaced: true, state, mutations,actions};

export default module;