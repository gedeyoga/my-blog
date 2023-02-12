<template>
    <div class="content-page">
        <section class="content mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="title">{{ category_detail.name }}</h2>
                        <p class="text-general" v-html="category_detail.description"></p>
                    </div>
                    <div class="col-md-6">
                        <img
                            class="img-thumbnail float-right"
                            style="background: none; border: none"
                            :src="$url + '/img/ilustration-1.png'"
                            alt=""
                        />
                    </div>
                </div>

                <div class="input-group search-article mt-5">
                    <input
                        v-model="filter.search"
                        type="text"
                        class="form-control"
                        id="inlineFormInputGroupUsername"
                        placeholder="Pencarian.."
                        @keyup.enter="fetchFilter"
                    />
                    <div class="input-group-append">
                        <button @click="fetchFilter" class="btn button-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <div class="row mt-5" v-if="!loading">
                    <div
                        class="col-lg-4 mt-5"
                        v-for="(article, index) in list_article"
                        :key="index"
                    >
                        <article-card-component
                            :article="article"
                        ></article-card-component>
                    </div>
                </div>
                <div class="row mt-5" v-else>
                    <div class="col-lg-4 mt-5">
                        <el-skeleton style="width: 100%" animated>
                            <template slot="template">
                                <el-skeleton-item variant="image" style="width: 100%; height: 250px; border-radius: 15px 15px 0 0 " />
                                <div class="mt-3">
                                    <el-skeleton-item variant="text" style="width: 20%" />
                                    <el-skeleton-item variant="text" style="width: 20%" />
                                    <el-skeleton-item variant="text" style="width: 20%" />
                                </div>
                                <el-skeleton-item class="mt-3" variant="h2" style="width: 100%" />
                                <el-skeleton-item class="mt-3" variant="p" style="width: 100%" />
                            </template>
                        </el-skeleton>
                    </div>
                    <div class="col-lg-4 mt-5">
                        <el-skeleton style="width: 100%" animated>
                            <template slot="template">
                                <el-skeleton-item variant="image" style="width: 100%; height: 250px; border-radius: 15px 15px 0 0 " />
                                <div class="mt-3">
                                    <el-skeleton-item variant="text" style="width: 20%" />
                                    <el-skeleton-item variant="text" style="width: 20%" />
                                    <el-skeleton-item variant="text" style="width: 20%" />
                                </div>
                                <el-skeleton-item class="mt-3" variant="h2" style="width: 100%" />
                                <el-skeleton-item class="mt-3" variant="p" style="width: 100%" />
                            </template>
                        </el-skeleton>
                    </div>
                    <div class="col-lg-4 mt-5">
                        <el-skeleton style="width: 100%" animated>
                            <template slot="template">
                                <el-skeleton-item variant="image" style="width: 100%; height: 250px; border-radius: 15px 15px 0 0 " />
                                <div class="mt-3">
                                    <el-skeleton-item variant="text" style="width: 20%" />
                                    <el-skeleton-item variant="text" style="width: 20%" />
                                    <el-skeleton-item variant="text" style="width: 20%" />
                                </div>
                                <el-skeleton-item class="mt-3" variant="h2" style="width: 100%" />
                                <el-skeleton-item class="mt-3" variant="p" style="width: 100%" />
                            </template>
                        </el-skeleton>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import ArticleCardComponent from "../component/ArticleCardComponent.vue";

export default {
    components: {
        ArticleCardComponent,
    },
    data() {
        return {
            articles: [],
            category_detail : {
                name: 'Artikel',
                description: "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolor assumenda eius vitae rerum, ullam voluptatem officiis sapiente eum! Inventore consequuntur, voluptatibus nesciunt odit maiores quam cumque similique vitae placeat minima",
            },
            filter:{
                search: null,
            },
            loading: false,
        };
    },
    computed: {
        list_article(){
            return this.articles;
        }
    },
    async created() {
        if(typeof this.$route.params.category !== 'undefined') {
            await this.fetchCategory()
        }
    },
    methods: {
        fetchCategory() {
            axios
                .get(route('api.category.show-name' , {
                    category: this.$route.params.category,
                    // paginate: false,
                }))
                .then((response) => {
                    this.category_detail = response.data.data;
                })
        },

        fetchArticle() {
            this.loading = true;
            axios
                .get(route('api.public.post') , {
                    params: {
                        category_exclude: 'portofolio',
                        ...this.filter,
                    }
                })
                .then((response) => {
                    this.loading = false;
                    this.articles = response.data.data;
                })
                .catch(() => this.loading = false)
        },

        fetchFilter() {
            this.fetchArticle();
        }
    },

    mounted() {
        if(typeof this.$route.params.category !== 'undefined') {
            // this.fetchCategory()
        }else{
            this.fetchArticle();
        }
    }
};
</script>
<style>

.content-page .el-skeleton.is-animated .el-skeleton__item {
    background: linear-gradient(90deg,#00242f 25%,#003d4f 37%,#00242f 63%);
    background-size: 400% 100%;
    animation: el-skeleton-loading 1.4s ease infinite;
}
</style>