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
                title: 'Criar Conta Bancária',
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
        },
        methods: {
            submit(){
                BankAccount.save({}, this.bankAccount).then(()=> { //olhaaa
                    Materialize.toast('Conta Bancária Criada Com Sucesso!', 4000);
                    this.$router.go({name: 'bank-account.list'});
                })
            },
            getBank(){
                Bank.query().then((response) => {
                    this.banks = response.data.data;
                })
            }
        }
    }
</script>