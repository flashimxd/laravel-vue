<template>
    <ul class="category-tree">
        <li v-for="(i, category) in categories" class="category-child">
            <div class="valign-wrapper">
                <a :data-activates="dropdownId(category)" href="#" class="category-symbol" :class="{'green-text': category.children.data.length > 0, 'grey-text': !category.children.data.length}">
                    <i class="material-icons">{{categoryIcon(category)}}</i>
                </a>
                <ul :id="dropdownId(category)" class="dropdown-content">
                    <li><a href="#" @click.prevent="categoryNew(category)">Adicionar</a></li>
                    <li><a href="#" @click.prevent="categoryEdit(category)">Editar</a></li>
                    <li><a href="#" @click.prevent="categoryDelete(category)">Excluir</a></li>
                </ul>
                <span class="valign">{{{categoryText(category)}}}</span>
            </div>
            <category-tree :categories="category.children.data" :parent="category"></category-tree>
        </li>
    </ul>
</template>

<script type="text/javascript">
    export default {
        name: 'category-tree',
        props: {
            categories: {
                type: Array,
                required: true
            },
            parent: {
                type: Object,
                required: false,
                'default'(){
                    return null;
                }
            }
        },
        watch: {
            categories: {
                handler(categories){
                    $('.category-child > div > a').dropdown({
                        hover: true,
                        inDuration: 300,
                        outDuration: 400,
                        belowOrigin: true
                    })
                },
                deep: true
            }
        },
        methods: {
            dropdownId(category){
                return `category-tree-dropdown-${category.id}`;
            },
            categoryText(category){
                return category.children.data.length > 0 ? `<strong>${category.name}</strong>` : category.name;
            },
            categoryIcon(category){
                return category.children.data.length > 0 ? 'folder' : 'label';
            },
            categoryNew(category){
                this.$dispatch('category-new', category);
            },
            categoryEdit(category){
                this.$dispatch('category-edit', category, this.parent);
            },
            categoryDelete(category){
                this.$dispatch('category-delete', category, this.parent);
            }
        }
    }
</script>