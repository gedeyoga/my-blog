<template>
    <div>
        <section class="content mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="title">PORTOFOLIO</h2>
                        <p class="text-general">
                            Lorem ipsum dolor sit amet consectetur, adipisicing
                            elit. Dolor assumenda eius vitae rerum, ullam
                            voluptatem officiis sapiente eum! Inventore
                            consequuntur, voluptatibus nesciunt odit maiores
                            quam cumque similique vitae placeat minima.
                        </p>
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
                        type="text"
                        class="form-control"
                        id="inlineFormInputGroupUsername"
                        placeholder="Username"
                    />
                    <div class="input-group-append">
                        <button class="btn button-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

                <div class="row mt-5">
                    <div
                        class="col-lg-4 mt-5"
                        v-for="(article, index) in articles"
                        :key="index"
                    >
                        <article-card-component
                            :article="article"
                        ></article-card-component>
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
            articles: [
                {
                    title: "Tutorial Laravel Pemula",
                    slug: "asfsaf-nkadnk",
                    categories: [{ name: "Laravel" }],
                    author: {
                        name: "Yoga Permana",
                    },
                },
                {
                    title: "Tutorial Laravel Pemula",
                    slug: "asfsaf-nkadnk",
                    categories: [{ name: "PHP" }, { name: "Laravel" }],
                    author: {
                        name: "Yoga Permana",
                    },
                },
                {
                    title: "Tutorial Laravel Pemula",
                    slug: "asfsaf-nkadnk",
                    categories: [{ name: "PHP" }, { name: "Laravel" }],
                    author: {
                        name: "Yoga Permana",
                    },
                },
                {
                    title: "Tutorial Laravel Pemula",
                    slug: "asfsaf-nkadnk",
                    categories: [{ name: "Laravel" }],
                    author: {
                        name: "Yoga Permana",
                    },
                },
                {
                    title: "Tutorial Laravel Pemula",
                    slug: "asfsaf-nkadnk",
                    categories: [{ name: "PHP" }, { name: "Laravel" }],
                    author: {
                        name: "Yoga Permana",
                    },
                },
                {
                    title: "Tutorial Laravel Pemula",
                    slug: "asfsaf-nkadnk",
                    categories: [{ name: "PHP" }, { name: "Laravel" }],
                    author: {
                        name: "Yoga Permana",
                    },
                },
                {
                    title: "Tutorial Laravel Pemula",
                    slug: "asfsaf-nkadnk",
                    categories: [{ name: "Laravel" }],
                    author: {
                        name: "Yoga Permana",
                    },
                },
                {
                    title: "Tutorial Laravel Pemula",
                    slug: "asfsaf-nkadnk",
                    categories: [{ name: "PHP" }, { name: "Laravel" }],
                    author: {
                        name: "Yoga Permana",
                    },
                },
                {
                    title: "Tutorial Laravel Pemula",
                    slug: "asfsaf-nkadnk",
                    categories: [{ name: "PHP" }, { name: "Laravel" }],
                    author: {
                        name: "Yoga Permana",
                    },
                },
            ],
        };
    },
};
</script>
