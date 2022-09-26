<template>
    <el-drawer
        title="Pengaturan Postingan"
        :visible.sync="drawer"
        :direction="direction"
        :close-on-press-escape="false"
        :wrapperClosable="false"
        :custom-class="'demo-drawer'"
        ref="drawer"
        v-loading="loading"
    >
        <div class="demo-drawer__content p-3">
            <el-form
                :model="post_setting"
                ref="postSetting"
                size="mini"
                label-position="top"
            >
                <el-form-item label="Url Postingan" prop="thumbnail">
                    <el-input
                        placeholder="Cth : link-postingan-saya"
                        v-model="post_setting.slug"
                    ></el-input>
                </el-form-item>
                <el-form-item label="Upload Thumbnail" prop="thumbnail">
                    <el-upload
                        :auto-upload="false"
                        action="#"
                        list-type="picture-card"
                        :on-preview="handlePictureCardPreview"
                        :on-remove="handleRemove"
                        :limit="1"
                        :on-change="handleChangeThumbnail"
                        :file-list="thumbnail"
                    >
                        <i class="el-icon-plus"></i>
                    </el-upload>
                </el-form-item>
                <el-form-item label="Kategori Postingan" prop="thumbnail">
                    <el-select
                        multiple
                        filterable
                        clearble
                        v-model="post_setting.category_id"
                    >
                        <el-option
                            v-for="(item, index) in list_categories"
                            :key="index"
                            :label="item.name"
                            :value="item.id"
                        ></el-option>
                    </el-select>
                </el-form-item>
            </el-form>
            <div class="demo-drawer__footer">
                <el-button @click="drawer = false">Batal</el-button>
                <el-button type="primary" @click="onSubmit">Simpan</el-button>
            </div>
        </div>
    </el-drawer>
</template>

<script>
import Form from "form-backend-validation";
export default {
    props: {
        show: false,
        post: null,
    },
    data() {
        return {
            drawer: false,
            direction: "rtl",
            post_setting: {
                thumbnail: "",
                category_id: [],
                slug: "",
            },

            list_categories: [],
            loading: false,
            thumbnail: [],
        };
    },

    watch: {
        show: function (value) {
            this.drawer = value;
        },

        drawer: function (value) {
            this.$emit("update:show", value);
        },

        post: function (value) {
            if (value) {
                this.post_setting.slug = value.slug;
                this.post_setting.category_id = value.category.map(
                    (item) => item.id
                );
                if(value.thumbnail) {
                    this.thumbnail = [
                        {
                            name: value.thumbnail.file_name,
                            url: value.thumbnail.original_url
                        }
                    ];
                }
            }
        },
    },

    methods: {
        fetchCategory() {
            axios
                .get(route("api.category.index"), {
                    params: {
                        paginate: false,
                    },
                })

                .then((response) => {
                    this.list_categories = response.data.data;
                });
        },

        handlePictureCardPreview(file) {
            console.log(file);
        },

        handleRemove(file, fileList) {
            console.log(file, fileList);
        },

        onSubmit() {
            this.$confirm(
                "Apakah anda yakin menyimpan settingan ?",
                "Konfirmasi",
                {
                    confirmButtonText: "Draft",
                    cancelButtonText: "Batal",
                    type: "warning",
                }
            ).then((result) => {
                this.loading = true;

                let data = this.post_setting;
                data._method = 'PUT';

                let formData = new Form(this.post_setting);

                formData
                    .post(
                        route("api.post.update", {
                            post: this.$route.params.post,
                        }),
                        {
                            Headers: 'multipart/form-data'
                        }
                    )
                    .then((response) => {
                        this.loading = false;
                        this.drawer = false;

                        this.$notify({
                            title: "Pemberitahuan",
                            message: response.message,
                            type: "success",
                        });
                        this.$emit("onSubmitSetting", response.data);
                    })
                    .catch((response) => {
                        this.loading = false;
                    });
            });
        },

        handleChangeThumbnail(file, fileList) {
            // console.log(file);
            this.post_setting.thumbnail = file.raw;
        },
    },

    mounted() {
        this.fetchCategory();
        this.post_setting.slug = this.post.slug;
        if(this.post.thumbnail) {
            this.thumbnail = [
                {
                    name: this.post.thumbnail.file_name,
                    url: this.post.thumbnail.original_url
                }
            ];
        }
    },
};
</script>