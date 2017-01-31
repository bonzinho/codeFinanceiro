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
}
