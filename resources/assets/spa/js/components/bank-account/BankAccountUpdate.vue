<template src="./_form.html"></template>

<script type="text/javascript">
    import {BankAccount, Bank} from '../../services/resources';
    import PageTitleComponent from '../PageTitle.vue';
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
                banks: []
            }
        },
        created(){
            this.getBank();
            this.getBankAccount(this.$route.params.id);
        },
        methods: {
            submit(){
                let id = this.$route.params.id;
                BankAccount.update({id: id}, this.bankAccount).then(()=> {
                    Materialize.toast('Conta Atualizada Criada Com Sucesso!', 4000);
                    this.$router.go({name: 'bank-account.list'});
                })
            },
            getBank(){
                Bank.query().then((response) => {
                    this.banks = response.data.data;
                })
            },
            getBankAccount(id){
                BankAccount.get({id: id}).then((response)=> {
                    this.bankAccount = response.data.data;
                })
            }
        }
    }
</script>