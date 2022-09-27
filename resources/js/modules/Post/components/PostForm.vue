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
                            @click="dialog_setting = true"
                            >Pengaturan</el-button
                        >
                        <el-button
                            size="small"
                            type="warning"
                            icon="el-icon-document"
                            v-loading="loading"
                            @click="onDraft"
                            >Draft</el-button
                        >
                        <el-button
                            size="small"
                            type="primary"
                            icon="el-icon-upload2"
                            @click="onPublished"
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

        <post-setting
            :show.sync="dialog_setting"
            :post="data_post"
            @onSubmitSetting="onSubmitSetting"
        ></post-setting>
    </div>
</template>

<script>
import _ from "lodash";
import PostSetting from "./PostSetting.vue";

export default {
    components: {
        PostSetting,
    },
    data() {

        let token = this.$csrfToken.content
        let url = this.$url;
        return {
            data_post: {
                id: null,
                title: "",
                article: "",
                created_by: null,
                status: "draft",
            },
            editorConfig: {
                filebrowserImageBrowseUrl: url +"/admin/laravel-filemanager?type=Images",
                filebrowserImageUploadUrl: url +"/admin/laravel-filemanager/upload?type=Images&_token=" + token,
                filebrowserBrowseUrl: url +"/admin/laravel-filemanager?type=Files",
                filebrowserUploadUrl: url +"/admin/laravel-filemanager/upload?type=Files&_token=" +token,
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

            dialog_setting: false,
        };
    },
    methods: {
        onSubmit(callback) {
            this.loading = true;

            axios
                .put(
                    route("api.post.update", {
                        post: this.$route.params.post,
                    }),
                    this.data_post
                )
                .then((response) => {
                    this.loading = false;

                    callback(response);
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
            this.onSubmit((response) => {
                this.data_post = response.data.data;
            });
        }),

        onPublished() {
            this.$confirm(
                "Apakah anda yakin publish postingan ?",
                "Konfirmasi",
                {
                    confirmButtonText: "Publish",
                    cancelButtonText: "Batal",
                    type: "warning",
                }
            ).then((result) => {
                this.data_post.status = "publish";
                this.loading = true;
                axios
                    .put(
                        route("api.post.status-change", {
                            post: this.$route.params.post,
                        }),
                        this.data_post
                    )
                    .then((response) => {
                        this.loading = false;
                        this.$notify({
                            title: "Pemberitahuan",
                            message: response.data.message,
                            type: "success",
                        });
                    })
                    .catch(() => (this.loading = false));
            });
        },

        onDraft() {
            this.$confirm(
                "Apakah anda yakin mendraft postingan ?",
                "Konfirmasi",
                {
                    confirmButtonText: "Draft",
                    cancelButtonText: "Batal",
                    type: "warning",
                }
            ).then((result) => {
                this.data_post.status = "draft";
                this.loading = true;
                axios
                    .put(
                        route("api.post.status-change", {
                            post: this.$route.params.post,
                        }),
                        this.data_post
                    )
                    .then((response) => {
                        this.loading = false;
                        this.$notify({
                            title: "Pemberitahuan",
                            message: response.data.message,
                            type: "success",
                        });
                    })
                    .catch(() => (this.loading = false));
            });
        },

        onSubmitSetting(post) {
            this.data_post = post;
        },
    },

    mounted() {
        if (typeof this.$route.params.post != "undefined") {
            this.fetchData();
        }
    },
};
</script>
