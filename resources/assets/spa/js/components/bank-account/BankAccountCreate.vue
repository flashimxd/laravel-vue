<template src="./_form.html"></template>

<script type="text/javascript">
    import PageTitleComponent from '../PageTitle.vue';
    import 'materialize-autocomplete';
    import store from '../../store/store';

    export default {
        components: {
            'page-title': PageTitleComponent
        },
        data(){
            return {
                title: 'Criar Conta Bancária',
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
        },
        computed: {
            banks(){
                return store.state.bank.banks;
            }
        },
        methods: {
            submit(){
                store.dispatch('bankAccount/save', this.bankAccount).then(()=> {
                    Materialize.toast('Conta Bancária Criada Com Sucesso!', 4000);
                    this.$router.go({name: 'bank-account.list'});
                })
            },
            getBank(){
                store.dispatch('bank/query').then((response) => {
                    this.initAutocomplete();
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