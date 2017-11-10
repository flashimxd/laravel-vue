<template>
    <div class="row">
        <page-title>
            <h5>Administração de categorias</h5>
        </page-title>
        <div class="card-panel z-depth-5">
            <category-tree :categories="categories"></category-tree>
        </div>

        <category-save :modal-options="modalOptionsSave" :category.sync="categorySave" :cp-options="cpOptions" @save-category="saveCategory">
            <span slot="title">{{title}}</span>
            <div slot="footer">
                <button type="submit" class="btn btn-flat waves-effect green lighten-2  modal-close modal-action">OK</button>
                <button class="btn btn-flat waves-effect waves-red modal-close modal-action">Cancelar</button>
            </div>
        </category-save>
    </div>

</template>

<script type="text/javascript">
    import PageTitleComponent from '../PageTitle.vue';
    import CategoryTreeComponent from './CategoryTree.vue';
    import CategorySaveComponent from './CategorySave.vue';
    import {Category} from '../../services/resources';

    export default {
        components: {
            'page-title': PageTitleComponent,
            'category-tree': CategoryTreeComponent,
            'category-save': CategorySaveComponent
        },
        data(){
            return {
                categories: [],
                categoriesFormated: [],
                categorySave: {
                    id: 0,
                    name: '',
                    parent_id: 0
                },
                title: 'Adicionar Categoria',
                modalOptionsSave: {
                    id: 'modal-category-save'
                },
                options: {
                    data: [
                        {id: 1, text: 'valor 1'},
                        {id: 2, text: 'valor 2'},
                        {id: 3, text: 'valor 3'}
                    ]
                },
                selected: 3
            }
        },
        computed: {
            cpOptions(){
                return {
                    data: this.categoriesFormated
                }
            }
        },
        created(){
            this.getCategories();
        },
        methods: {
            getCategories(){
                Category.query().then((response) => {
                    this.categories = response.data.data;
                    this.formatCategories();
                });
            },
            saveCategory(){
                console.log('save category');
            },
            modalNew(category){
                this.categorySave = category;
                $(`#${this.modalOptionsSave.id}`).modal('open');
            },
            modalEdit(category){

            },
            formatCategories(){
                for(let category of this.categories){
                    this.categoriesFormated.push({ id: category.id, text: category.name });
                }
                //this.categoriesFormated = this.categories;
            }
        },
        events: {
            'category-new'(category){
                this.modalNew(category);
            },
            'category-edit'(category){

            }
        }
    }
</script>