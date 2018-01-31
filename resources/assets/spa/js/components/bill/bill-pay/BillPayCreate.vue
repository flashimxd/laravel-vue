<template src="../_form.html"></template>

<script type="text/javascript">
    import billPayMixin from '../../../mixins/bill-mixin';

    export default {
        ready(){
            this.initSelect2();
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