<template src="../_form.html"></template>

<script type="text/javascript">
    import billReceiveMixin from '../../../mixins/bill-mixin';
    import validatorOffRemoveMixin from '../../../mixins/validator-off-remove-mixin';

    export default {
        ready(){
            this.initSelect2();
            $('.datepicker').pickadate({format: 'dd/mm/yyyy', selectMounths: true, selectYears: 15})
        },
        mixins: [billReceiveMixin, validatorOffRemoveMixin],
        methods: {
            namespace(){
                return 'billReceive';
            },
            categoryNamespace(){
                return 'categoryRevenue';
            },
            title(){
                return 'Novo Recebimento';
            }
        }
    }
</script>

<style type="text/css" src="../_style.css" scoped></style>