<template>
    <ul class="pagination">
        <li :class="{'disabled': currentPage == 0 }">
            <a @click.prevent="previousPage" href="#"><i class="material-icons">chevron_left</i></a>

        </li>

        <li v-for="o in pages" class="waves-effect" :class="{'active': currentPage == o}">
            <a @click.prevent="setCurrentPage(o)" href="#">{{ o + 1 }}</a>

        </li>

        <li :class="{'disabled': currentPage == pages - 1}">
            <a @click.prevent="nextPage" href="#">
                <i class="material-icons">chevron_right</i>
            </a>

        </li>

    </ul>
</template>

<script type="text/javascript">
    export default{
        props:{

            currentPage: {
                type: Number,
                'default': 0
            },
            perPage:{
              type: Number,
              required: true
            },
            totalRecords:{
                type: Number,
                required: true
            }
        },
        computed:{
            pages(){
                let pages = Math.ceil(this.totalRecords / this.perPage); // 55/10 = 5.xxx com o ceil retorna o inteiro maior ou igual 5.2 = 6
                return Math.max(pages, 1);
            }
        },
        methods:{
            previousPage(){
                if(this.currentPage > 0){
                    this.currentPage--;
                }
            },
            setCurrentPage(page){
                this.currentPage = page;

            },
            nextPage(){
                if(this.currentPage < this.pages -1){
                    this.currentPage++;
                }
            },
        },
        watch:{ //verifica se existe alguma mudança
            currentPage(newValue){
                this.$dispatch('pagination::changed', newValue); // disparao evento
            }
        }

    }
</script>
