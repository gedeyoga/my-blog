<template>
    <div>
        <el-form
            :model="data_post"
            :rules="rules"
            ref="postForm"
            size="mini"
            label-position="top"
        >
            <div class="row align-items-center mb-3">
                <div class="col-md-8">
                    <el-form-item label="Judul" prop="title">
                        <el-input
                            v-model="data_post.title"
                            placeholder="Masukkan judul postingan..."
                            @change="onEditPost"
                        ></el-input>
                    </el-form-item>
                </div>
                <div class="col-md-4 d-flex justify-content-md-end">
                    <el-button-group>
                        <el-button
                            size="small"
                            type="plain"
                            icon="el-icon-setting"
                            >Pengaturan</el-button
                        >
                        <el-button
                            size="small"
                            type="warning"
                            icon="el-icon-document"
                            v-loading="loading"
                            >Draft</el-button
                        >
                        <el-button
                            size="small"
                            type="primary"
                            icon="el-icon-upload2"
                            >Publish</el-button
                        >
                    </el-button-group>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <ckeditor
                        v-model="data_post.article"
                        :config="editorConfig"
                        @blur="onEditPost"
                    ></ckeditor>

                    <el-form-item>
                        <div class="text-center mt-3">
                            <el-button @click.prevent="$router.back()"
                                >Kembali</el-button
                            >
                        </div>
                    </el-form-item>
                </div>
            </div>
        </el-form>
    </div>
</template>

<script>
import _ from "lodash";

export default {
    data() {
        return {
            data_post: {
                title: "",
                article: "",
                created_by: null,
            },
            editorConfig: {
                // The configuration of the editor.
            },
            loading: false,
            rules: {
                name: [
                    {
                        required: true,
                        message: "Postingan tidak boleh kosong!",
                    },
                ],
                description: [
                    { required: true, message: "Deskripsi tidak boleh kosong" },
                ],
            },
        };
    },
    methods: {
        onSubmit() {
            this.loading = true;
            let data = this.data_post;
            data.created_by = this.user.id;

            axios
                .put(
                    route("api.post.update", {
                        post: this.$route.params.post,
                    }),
                    this.data_post
                )
                .then((response) => {
                    this.loading = false;
                })
                .catch((response) => {
                    this.loading = false;
                });
        },

        fetchData() {
            axios
                .get(
                    route("api.post.show", {
                        post: this.$route.params.post,
                    })
                )
                .then((response) => {
                    let post = response.data.data;
                    this.data_post = post;
                });
        },

        onEditPost: _.debounce(function () {
            this.onSubmit();
        }),
    },

    mounted() {
        if (typeof this.$route.params.post != "undefined") {
            this.fetchData();
        }
    },
};
</script>