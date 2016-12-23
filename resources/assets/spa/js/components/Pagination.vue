<template>
    <ul class="pagination">
        <li>
            <a @click.prevent="setCurrentPage(currentPage - 1)" href="#"><i class="material-icons">chevron_left</i></a>

        </li>

        <li v-for="o in pages" class="waves-effect" :class="{'active': currentPage == o}">
            <a @click.prevent="setCurrentPage(o)" href="#">{{ o + 1 }}</a>

        </li>

        <li>
            <a @click.prevent="setCurrentPage(currentPage + 1)" href="#"> <i class="material-icons">chevron_right</i></a>

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

            },
            nextPage(){

            },
            setCurrentPage(page){
                this.currentPage = page;

            }
        }

    }
</script>
