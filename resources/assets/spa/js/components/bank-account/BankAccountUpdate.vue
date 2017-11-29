<template src="./_form.html"></template>

<script type="text/javascript">
    import {BankAccount} from '../../services/resources';
    import PageTitleComponent from '../PageTitle.vue';
    import 'materialize-autocomplete';
    import store from '../../store/store';

    export default {
        components: {
            'page-title': PageTitleComponent
        },
        data(){
            return {
                title: 'Atualização de Conta Bancária',
                bankAccount: {
                    name: '',
                    agency: '',
                    account: '',
                    bank_id: '',
                    'default': false
                },
                bank: {
                    name: ""
                }
            }
        },
        created(){
            this.getBank();
            this.getBankAccount(this.$route.params.id);
        },
        computed:{
            banks(){
                return store.state.bank.banks;
            }
        },
        methods: {
            submit(){
                let id = this.$route.params.id;
                store.dispatch('bankAccount/update', {id: id, bankAccount: this.bankAccount}).then(()=> {
                    Materialize.toast('Conta Atualizada Criada Com Sucesso!', 4000);
                    this.$router.go({name: 'bank-account.list'});
                })
            },
            getBank(){
                store.dispatch('bank/query').then((response) => {
                    this.initAutocomplete();
                })
            },
            getBankAccount(id){
                BankAccount.get({id: id, include: 'bank'}).then((response)=> {
                    this.bankAccount = response.data.data;
                    this.bank = response.data.data.bank.data;
                })
            },
            initAutocomplete(){
                let self = this;
                $(document).ready(() => {
                    $('#bank-id').materialize_autocomplete({
                        limit: 10,
                        multiple: {
                            enable: false
                        },
                        dropdown: {
                            el: '#bank-id-dropdown'
                        },
                        getData(value, callback){
                            let mapBank = store.getters['bank/mapBanks'];
                            let banks = mapBank(value);
                            callback(value, banks);
                        },
                        onSelect(item){
                            self.bankAccount.bank_id = item.id;
                        }
                    });
                });
            }
        }
    }
</script>