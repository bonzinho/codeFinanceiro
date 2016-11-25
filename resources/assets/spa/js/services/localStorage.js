//window.localStorage.setItem('nome', 'valor'); // definir
//window.localStorage.setItem('nome', 'valor alterado'); // alterar valor definido
//window.localStorage.clear(); // limpar localStorage do nosso dominio
//window.localStorage.removeItem('nome') // remove o item passando o nome do item


export default{
    // atribuir o valor    
    set(key, value){
        window.localStorage[key] = value;
        return window.localStorage[key];
    },
    // pegar o valor   
    get(key, defaultValue = null){
        return window.localStorage[key] || defaultValue;  // se existir retorn localStorage[key] se não retorna o nosso defaultValue (null)
    },
    // atribuição do objeto
    setObject(key, value){
        window.localStorage[key] = JSON.stringify(value);  // aqui serializa o o nosso objeto para JSON com o JSON.stringify
        return this.getObject(key);
    },
    // pegarvalor
    getObject(key){
        return JSON.parse(window.localStorage[key] || null)  // processo contrário do de cima, retorna o nosso valor se existir, se não existir retorna null
    },
    // remover valor
    remove(key){
        window.localStorage.removeItem(key);
    }
}