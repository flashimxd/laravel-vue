import {CategoryRevenue, CategoryExpense} from './resources';

export class CategoryFormat {

    static getCategoriesFormatted(categories){

        let categoriesFormatted = this._formatCategories(categories);
        categoriesFormatted.unshift({
            id: 0,
            text: 'Nenhuma Categoria',
            level: 0,
            hasChildren: false
        });

        return categoriesFormatted;
    }

    static _formatCategories(categories, categoryCollection = []){
        for(let category of categories){
            let categoryNew = {
                id: category.id,
                text: category.name,
                level: category.depth,
                hasChildren: category.children.data.length > 0
            }

            categoryCollection.push(categoryNew);
            this._formatCategories(category.children.data, categoryCollection);
        }
        return categoryCollection;
    }
}

export class CategoryService {

    constructor(type){
        this.resource = type == 'revenue'? CategoryRevenue : CategoryExpense;
    }

    save(category, parent, categories, categoryOriginal){
            if(category.id === 0){
                return this.new(category, parent, categories);
            }else{
                return this.edit(category, parent, categories, categoryOriginal);
            }
    }

    new(category, parent, categories){
        let categoryCopy = $.extend(true, {}, category);
        if(categoryCopy.parent_id === null){
            delete categoryCopy.parent_id;
        }
        return this.resource.save(categoryCopy).then((response) => {
            let categoryAdded = response.data.data;
            if(categoryAdded.parent_id === null){
                categories.push(categoryAdded);
            }else{
                parent.children.data.push(categoryAdded);
            }
            return response;
        })
    }

    edit(category, parent, categories, categoryOriginal){
        let categoryCopy = $.extend(true, {}, category);
        if(categoryCopy.parent_id === null){
            delete categoryCopy.parent_id;
        }

        let self = this;
        return this.resource.update({id: categoryCopy.id},categoryCopy).then((response) => {

            let categoryUpdated = response.data.data;

            if(categoryUpdated.parent_id === null){

                //categoria alterada, esta sem pai, antes tinha um pai
                if(parent){
                    parent.children.data.$remove(categoryOriginal);
                    categories.push(categoryUpdated);
                    return response;
                }

            }else{
                //categoria alterada, esta sem pai
                if(parent){
                    //troca categoria de pai
                    if(parent.id != categoryUpdated.parent_id){
                        parent.children.data.$remove(categoryOriginal);
                        CategoryService._addChild(categoryUpdated, categories);
                        return response;
                    }
                }else{
                    //torna categoria um filho, antes era um pai
                    categories.$remove(categoryOriginal);
                    CategoryService._addChild(categoryUpdated, categories);
                    return response;
                }
            }

            //Alteração somente do nome da categoria
            //Atualizar o nó na árvore
            if(parent){

                //busca o index do filho
                let index = parent.children.data.findIndex(element => {
                    return element.id == categoryUpdated.id;
                })

                //atualiza a arvore (filho) apenas no nó alterado
                parent.children.data.$set(index, categoryUpdated);
            }else{

                //busca o index do pai (root)
                let index = categories.findIndex(element => {
                    return element.id == categoryUpdated.id;
                })

                //atualiza a arvore (root) apenas no nó alterado
                categories.$set(index, categoryUpdated);
            }

            return response;
        })
    }

    destroy(category, parent, categories){
        return this.resource.delete({id: category.id}).then(response => {
            if(parent){
                parent.children.data.$remove(category);
            }else{
                categories.$remove(category);
            }

            return response;
        });
    }

    query(){
        return this.resource.query();
    }

    static _addChild(child, categories){
        let parent = this._findParent(child.parent_id, categories);
        parent.children.data.push(child);
    }

    static _findParent(id, categories){
        let result = null;

        for(let category of categories){
            if(id == category.id){
                result = category;
                break;
            }

            result = this._findParent(id, category.children.data);
            if(result != null){
                break;
            }
        }

        return result;
    }
}