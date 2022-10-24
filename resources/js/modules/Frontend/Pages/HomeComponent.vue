<template>
    <div>
        <section class="hero">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="title">
                            SELAMAT <br />
                            DATANG.
                        </h2>
                        <p class="text-general">
                            Website ini adalah tempat memajang hasil karya
                            <br />
                            saya diantaranya
                        </p>

                        <div class="d-flex">
                            <div class="item-count mr-5">
                                <label>10</label>
                                <span class="d-block">Artikel</span>
                            </div>
                            <div class="item-count mr-5">
                                <label>4</label>
                                <span class="d-block">Portofolio</span>
                            </div>
                            <div class="item-count mr-5">
                                <label>4</label>
                                <span class="d-block">Pengalaman Kerja</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card-img">
                            <img class="" :src="$url + '/img/my-profile.png'" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="box bgc-primary"></div>
        </section>

        <section class="portofolio">
            <div class="container">
                <h2 class="sub-title">portofolio</h2>
                <div class="row">
                    <div class="col-lg-4"  v-for="(article , index) in articles" :key="index">
                        <aricle-card-component 
                            :article="article"
                        ></aricle-card-component>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <a href="#" class="btn button-primary">Lihat Semua</a>
                </div>
            </div>
        </section>

        <section class="article">
            <div class="container">
                <h2 class="sub-title">artikel</h2>
                <div class="row">
                    <div class="col-lg-4"  v-for="(article , index) in articles" :key="index">
                        <aricle-card-component 
                            :article="article"
                        ></aricle-card-component>
                    </div>
                </div>

                <div class="text-center mt-5">
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