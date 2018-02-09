<template src="../_form.html"></template>

<script type="text/javascript">
    import billPayMixin from '../../../mixins/bill-mixin';

    export default {
        ready(){
            this.initSelect2();
            $('.datepicker').pickadate({format: 'dd/mm/yyyy', selectMounths: true, selectYears: 15})
        },
        mixins: [billPayMixin],
        methods: {
            namespace(){
                return 'billPay';
            },
            categoryNamespace(){
                return 'categoryExpense';
            },
            title(){
                return 'Novo Pagamento';
            }
        }
    }
</script>

<style type="text/css" src="../_style.css" scoped></style>