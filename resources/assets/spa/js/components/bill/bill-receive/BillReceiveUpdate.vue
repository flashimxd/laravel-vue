<template src="../_form.html"></template>

<script type="text/javascript">
    import billReceiveMixin from '../../../mixins/bill-mixin';
    import store from '../../../store/store';
    import BillReceive from '../../../models/bill-receive';
    import validatorOffRemoveMixin from '../../../mixins/validator-off-remove-mixin';
    
    export default {
        mixins: [billReceiveMixin, validatorOffRemoveMixin],
        created(){
            let self = this;
            this.modalOptions.options={};
            this.modalOptions.options.ready = () => {
                self.getBill();
            };
        },
        methods: {
            namespace(){
                return 'billReceive';
            },
            categoryNamespace(){
                return 'categoryRevenue';
            },
            title(){
                return 'Editar Recebimento';
            },
            getBill(){
                this.resetScope();
                let bill = store.getters[`${this.namespace()}/billByIndex`](this.index)
                this.bill = new BillPay(bill);
                let text = store.getters['bankAccount/textAutoComplete'](bill.bankAccount.data);
                this.bankAccount.text = text;
            }
        }
    }
</script>