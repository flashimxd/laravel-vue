<template>
    <div class="row">
        <page-title>
            <h5>Plano de Contas</h5>
        </page-title>
        <div class="card-panel z-depth-5">
            <h5>Categorias de Receita</h5>
            <category-revenue v-ref:revenue></category-revenue>
            <h5>Categorias de Despesas</h5>
            <category-expense v-ref:expense></category-expense>
        </div>

        <div class="fixed-action-btn horizontal">

            <a class="btn-floating btn-large">
                <i class="large material-icons">add</i>
            </a>

            <ul>
                <li>
                    <a class="btn-floating green" href="#" @click.prevent="newRevenue" title="Nova Categoria de Receita">
                        <i class="large material-icons">attach_money</i>
                    </a>
                </li>

                <li>
                    <a class="btn-floating red" href="#" @click.prevent="newExpense" title="Nova Categoria de Despesa">
                        <i class="large material-icons">money_off</i>
                    </a>
                </li>
            </ul>

        </div>

    </div>

</template>

<script type="text/javascript">
    import PageTitleComponent from '../PageTitle.vue';
    import CategoryRevenue from './CategoryRevenue.vue';
    import CategoryExpense from './CategoryExpense.vue';

    export default {
        components: {
            CategoryExpense,
            CategoryRevenue,
            'page-title': PageTitleComponent,
            'category-revenue': CategoryRevenue,
            'category-expense': CategoryExpense,
        },
        methods: {
            newRevenue(){
                this.$refs.revenue.modalNew(null);
            }  ,
            newExpense(){
                this.$refs.expense.modalNew(null);
            }
        }
    }
</script>