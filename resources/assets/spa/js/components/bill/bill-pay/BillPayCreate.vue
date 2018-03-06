<template src="../_form.html"></template>

<script type="text/javascript">
    import billPayMixin from '../../../mixins/bill-mixin';
    import validatorOffRemoveMixin from '../../../mixins/validator-off-remove-mixin';

    export default {
        ready(){
            this.initSelect2();
            $('.datepicker').pickadate({format: 'dd/mm/yyyy', selectMounths: true, selectYears: 15})
        },
        mixins: [billPayMixin, validatorOffRemoveMixin],
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