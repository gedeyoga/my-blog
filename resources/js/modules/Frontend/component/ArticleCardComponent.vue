<template>
    <div class="card article-card">
        <div class="card-body">
            <div class="thumbnail-container">
                <img class="img-thumbnail" src="https://fahram.dev/image-series/MSUIwPJaNIHY65ykpN0YzFvenSpL9T2L87D7epeg.png" alt="">
            </div>
            <a href="#" @click.prevent="$router.push({name:'article.detail' , params : {slug: article.slug} })">
                <h3 class="title-article">{{ article.title }}</h3>
            </a>
            <a href="#"><span class="text-general author">{{ article.author.name }}</span></a>
            <div class="d-flex list-category">
                <a href="#" v-for="(category , index) in article.categories" :key="index"><span class="text-general category">{{ category.name }}</span></a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        article: null,
    },
}
</script>