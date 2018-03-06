<template src="../_form.html"></template>

<script type="text/javascript">
    import billPayMixin from '../../../mixins/bill-mixin';
    import store from '../../../store/store';
    import BillPay from '../../../models/bill-pay';
    import validatorOffRemoveMixin from '../../../mixins/validator-off-remove-mixin';
    
    export default {
        mixins: [billPayMixin, validatorOffRemoveMixin],
        created(){
            let self = this;
            this.modalOptions.options={};
            this.modalOptions.options.ready = () => {
                self.getBill();
            };
        },
        methods: {
            namespace(){
                return 'billPay';
            },
            categoryNamespace(){
                return 'categoryExpense';
            },
            title(){
                return 'Editar Pagamento';
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