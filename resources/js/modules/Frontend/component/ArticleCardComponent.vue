<template>
    <div class="card article-card">
        <div class="card-body">
            <div class="thumbnail-container">
                <img class="img-thumbnail" :src="article.thumbnail.original_url" alt="">
            </div>
            <div class="d-flex list-category mb-3">
                <a href="#" v-for="(category , index) in article.category" :key="index"><span class="text-general category">{{ category.name }}</span></a>
            </div>
            <a href="#" @click.prevent="$router.push({name:'article.detail' , params : {slug: article.slug} })">
                <h3 class="title-article">{{ article.title }}</h3>
            </a>
            <div class="text-general" style="text-align: justify;" v-html="article.short_text"></div>
            <!-- <a href="#"><span class="text-general author">{{ article.writer.name }}</span></a> -->
            <div class="mt-5 text-white text-general">{{ article.created_at | formatDate }} <span class="px-2" style="vertical-align: super;">.</span> <i class="el-icon-reading"></i> {{ article.read_time }}</div>
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

<style>
.article-card .thumbnail-container .img-thumbnail{
    background: none !important;
}
.article-card .img-thumbnail{
    border-radius: 15px !important;
    max-height: 460px !important;
}
</style>