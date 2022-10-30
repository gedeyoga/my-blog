<template>
    <div>
        <section class="hero">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 text-center text-lg-left">
                        <h2 class="title">
                            SELAMAT <br class="d-none d-lg-block" />
                            DATANG.
                        </h2>
                        <p class="text-general">
                            Website ini adalah tempat memajang hasil karya
                            <br class="d-none d-lg-block" />
                            saya diantaranya
                        </p>

                        <div class="d-flex justify-content-center justify-content-lg-start px-3 px-lg-0">
                            <div class="item-count mr-lg-5 mr-3">
                                <label>10</label>
                                <span class="d-block">Artikel</span>
                            </div>
                            <div class="item-count mr-lg-5 mr-3">
                                <label>4</label>
                                <span class="d-block">Portofolio</span>
                            </div>
                            <div class="item-count ">
                                <label>4</label>
                                <span class="d-block">Pengalaman</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mt-5 mt-lg-0">
                        <div class="card-img text-lg-right text-center">
                            <img class="" :src="$url + '/img/my-profile.png'" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="box bgc-primary d-none d-lg-block"></div>
        </section>

        <section class="portofolio">
            <div class="container">
                <h2 class="sub-title text-center text-lg-left">portofolio</h2>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-12 mb-5"  v-for="(article , index) in articles" :key="index">
                        <aricle-card-component 
                            :article="article"
                        ></aricle-card-component>
                    </div>
                </div>

                <div class="text-center mt-lg-5 mt-3">
                    <a href="#" class="btn button-primary">Lihat Semua</a>
                </div>
            </div>
        </section>

        <section class="article">
            <div class="container">
                <h2 class="sub-title text-center text-lg-left">artikel</h2>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-12 mb-5"  v-for="(article , index) in articles" :key="index">
                        <aricle-card-component 
                            :article="article"
                        ></aricle-card-component>
                    </div>
                </div>

                <div class="text-center mt-lg-5 mt-3">
                    <a href="#" class="btn button-primary">Lihat Semua</a>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import AricleCardComponent from "../component/ArticleCardComponent.vue";
export default {
    components: {
        AricleCardComponent
    },
    data() {
        return {
            articles : [
                {
                    title: 'Tutorial Laravel Pemula',
                    slug: 'asfsaf-nkadnk',
                    categories: [
                        { name: 'Laravel'},
                    ],
                    author: {
                        name: 'Yoga Permana'
                    }
                },
                {
                    title: 'Tutorial Laravel Pemula',
                    slug: 'asfsaf-nkadnk',
                    categories: [
                        { name: 'PHP'},
                        { name: 'Laravel'},
                    ],
                    author: {
                        name: 'Yoga Permana'
                    }
                },
                {
                    title: 'Tutorial Laravel Pemula',
                    slug: 'asfsaf-nkadnk',
                    categories: [
                        { name: 'PHP'},
                        { name: 'Laravel'},
                    ],
                    author: {
                        name: 'Yoga Permana'
                    }
                }
            ]
        };
    },
}
</script>