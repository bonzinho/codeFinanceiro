<template>
    <select></select>
</template>

<script type="text/javascript">
    import 'select2';

    export default{
        props: {
            options:{
                type: Object,
                required:true

            },
            selected:{
                // alteramos o type e o required para o seguinte validator, para as categorias pai mostrarem a afrase "sem categoria pai", pois este têm o level como null
                validator(value){
                    return typeof value == 'string' || typeof  value == 'number' || value === null;
                }
            }
        },
        ready(){
            let self = this;
            $(this.$el)
                    .select2(this.options)
                    .on('change', function(){
                        if(parseInt(this.value, 10) !== 0){
                            self.selected = this.value; // ao selecionarmos alteramos logo o nosso selected
                        }else{
                            // se o value for = 0, ou seja quisemos alterar a categoria filha para uma categoria pai
                            self.selected = null;
                        }
                    })
            $(this.$el).val(this.selected !== null ? this.selected :0).trigger('change');
        },
        watch: {
            //propriedade que vai ter a coleção dasw informações necessarias
            'options.data'(data){
                $(this.$el).empty();
                //faz um merge das opções existentes (this.options em cima) com as novas
                $(this.$el).select2(this.options);
            },
            // selecionar a categoria pai predefinida aquando abrir o modal
            'selected'(selected){
               if(selected != $(this.$el).val()){
                   $(this.$el).val(selected !== null ? this.selected :0).trigger('change');
               }
            }
        }
    }
</script>
