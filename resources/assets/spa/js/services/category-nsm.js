import {Category} from './resources';

// classe responsavel por formatar as categorias e o tipo de formatação a ser feita
export class CategoryFormat{
    // vamos trabalhar com um etodo estatico para nao ser necessario estanciar a classe
    // retorna um array com todas as categorias para depois serem formatadas no select2
    static getCategoriesFormatted(categories){
        let categoriesformatted = this._formatCategories(categories);
        categoriesformatted.unshift({
            id: 0,
            text: 'Sem categoria Pai',
            level: 0, // important para saber os espaços da margem esquerda
            hasChildren: false, // saber se ac ategoria tem ou não filhos
        });
        console.log(categoriesformatted);
        return categoriesformatted; // retorna um array comn todas as nossas categorias
    }

    // função recursiva, chama-se a si mesmo
    static _formatCategories(categories, categoryCollection = []){
        for(let category of categories){
            let categoryNew = {
                id: category.id,
                text: category.name,
                level: category.depth, // important para saber os espaços da margem esquerda
                hasChildren: category.children.data.length > 0, // saber se ac ategoria tem ou não filhos
            };

            categoryCollection.push(categoryNew);
            this._formatCategories(category.children.data, categoryCollection);
        }
        return categoryCollection;
    }
}


export class CategoryService{

    static save(category, parent, categories,categoryOriginal){
        if(category.id === 0){
            return this.new(category, parent, categories)
        }else{
            return this.edit(category, parent, categories, categoryOriginal);
        }
    }

    static new(category, parent, categories){
        let categoryCopy = $.extend(true, {}, category); // fazemos uma copia da categoria para a variavel categoryCopy para podermos manipular sem alterar o original
        if(categoryCopy.parent_id === null){
            delete categoryCopy.parent_id;
        }

        return Category.save(categoryCopy).then(response => {
            let categoryAdded = response.data.data;
            if(categoryAdded.parent_id === null){
                categories.push(categoryAdded);
            }else{
                parent.children.data.push(categoryAdded);
            }
            return response;
        })
    }

    static edit(category, parent, categories, categoryOriginal){
        let categoryCopy = $.extend(true, {}, category); // fazemos uma copia da categoria para a variavel categoryCopy para podermos manipular sem alterar o original
        // se a categoria nao tiver parant_id, a mesma é removida
        if(categoryCopy.parent_id === null){
            delete categoryCopy.parent_id;
        }

        let self = this; //para poder usar o yhis dentro do return

        return Category.update({id: categoryCopy.id}, categoryCopy).then(response => {
            // depois de feito o update recebemos a response com os dados da categoria
            let categoryUpdated = response.data.data;
            // verificamos se a categoria editada tem parent_id
            if(categoryUpdated.parent_id === null){
                /*
                 * Categoria alterada, está sem pai
                 * E antes tinha um pai
                 */
                if(parent){
                    parent.children.data.$remove(categoryOriginal); // removemos os parents da categoria Origial
                    categories.push(categoryUpdated); // adicionamos a nossa nova categoria na raiz
                    return response;
                }
            }else{ // se a nossa categoria tiver categoria pai
                /*
                 * Categoria alterada, e tem um pai
                 */
                if(parent){
                    /*
                     * trocar categoria de pai
                     */
                    if(parent.id != categoryUpdated.parent_id){ // verificar se a categoria pai é diferente da antiga
                        parent.children.data.$remove(categoryOriginal);
                        self._addchild(categoryUpdated, categories);
                        return response;
                    }
                }else{
                    /*
                     * tornar categoria um filho
                     * Antes a categoria era pai
                     */
                    categories.$remove(categoryOriginal); // remove da raiz
                    self._addchild(categoryUpdated, categories);
                    return response;

                }
            }
            /**
             * Alteração só do nome da categoria
             * Atualiza as informações na arvore
             **/
            if(parent){
                let index = parent.children.data.findIndex(element => {
                    return element.id == categoryUpdated.id;
                });
                parent.children.data.$set(index, categoryUpdated); // atualiza a categoria no indicie correto
            }else{
                let index = categories.findIndex(element => {
                    return element.id == categoryUpdated.id;
                });
                categories.$set(index, categoryUpdated); // atualiza a categoria no indicie correto

            }

            return response;
        })
    }

    static _addchild(child, categories){
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
            if(result !== null){
                break;
            }
        }
        return result;
    }
}
