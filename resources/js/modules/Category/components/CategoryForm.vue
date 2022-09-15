<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Kategori</h1>
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item">
                        <a href="#">List Kategori</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Tambah Kategori
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <span>Tambah Kategori</span>
            </div>
            <div class="card-body">
                <el-form
                    :model="data_category"
                    :rules="rules"
                    ref="categoryForm"
                    size="small"
                    label-position="top"
                    v-loading="loading"
                >
                    <el-form-item label="Kategori" prop="name">
                        <el-input
                            v-model="data_category.name"
                            placeholder="Cth: Yoga Permana"
                        ></el-input>
                    </el-form-item>
                    <el-form-item label="Deskripsi" prop="description">
                        <el-input
                            type="text"
                            v-model="data_category.description"
                            placeholder="Cth: permana0912@gmail.com"
                        ></el-input>
                    </el-form-item>

                    <el-form-item>
                        <div class="text-center mt-3">
                            <el-button
                                v-loading="loading"
                                @click.prevent="$router.back()"
                                >Kembali</el-button
                            >
                            <el-button
                                v-loading="loading"
                                type="primary"
                                @click="onSubmit()"
                            >
                                {{
                                    $route.params.category
                                        ? "Simpan Kategori"
                                        : "Tambah Kategori"
                                }}
                            </el-button>
                        </div>
                    </el-form-item>
                </el-form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            data_category: {
                name: "",
                description: "",
            },
            loading: false,
            rules: {
                name: [{ required: true, message: "Kategori tidak boleh kosong!" }],
                description: [
                    { required: true, message: "Deskripsi tidak boleh kosong" },
                ],
            },

        };
    },
    methods: {
        onSubmit() {
            this.$refs["categoryForm"].validate((valid) => {
                let fields = this.$refs["categoryForm"].fields;
                for (let i = 0; i < fields.length; i++) {
                    if (fields[i].validateState == "error") {
                        $(fields[i].$el).find("input").focus();
                        return false;
                    }
                }

                if (valid) {
                    this.$confirm("Apakah anda yakin ?", "Konfirmasi", {
                        confirmButtonText: "Simpan",
                        cancelButtonText: "Batal",
                        type: "warning",
                    }).then((result) => {
                        this.loading = true;

                        this.getRoute()
                            .then((response) => {
                                this.loading = false;
                                this.$notify({
                                    title: "Pemberitahuan",
                                    message: response.data.message,
                                    type: "success",
                                });
                                this.$router.push({ name: "categories.index" });
                            })
                            .catch((response) => {
                                this.loading = false;
                            });
                    });
                }
            });
        },

        fetchData() {
            axios
                .get(
                    route("api.category.show", {
                        category: this.$route.params.category,
                    })
                )
                .then((response) => {
                    let category = response.data.data;
                    this.data_category = category;
                });
        },

        getRoute() {
            if (typeof this.$route.params.category != "undefined") {
                return axios.put(
                    route("api.category.update", {
                        category: this.$route.params.category,
                    }),
                    this.data_category
                );
            }
            return axios.post(route("api.category.store"), this.data_category);
        },
    },

    mounted() {
        if (typeof this.$route.params.category != "undefined") {
            this.fetchData();
        }
    }
};
</script>