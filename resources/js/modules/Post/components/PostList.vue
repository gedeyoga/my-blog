<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">List Postingan</h1>
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Postingan
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <span>List Postingan</span>
                <el-button 
                    v-if="hasAccess('post.post-create')"
                    type="primary"
                    size="small"
                    icon="fas fa-plus"
                    @click="onCreateDraftPost"
                    v-loading="loading_draft"
                    >Tambah Postingan</el-button
                >
            </div>
            <div class="card-body">
                <div class="row mb-3 align-items-end">
                    <div class="col-md-9">
                        <div class="btn-group float-right">
                            <el-input
                                size="mini"
                                prefix-icon="el-icon-search"
                                @keyup.enter.native="fetchData"
                                v-model="filter.search"
                                :placeholder="'Cari..'"
                            >
                                <template slot="append">
                                    <el-button @click="fetchData">
                                        <span class="fa fa-search"></span>
                                    </el-button>
                                </template>
                            </el-input>
                        </div>
                    </div>
                </div>

                <div class="border-bottom"></div>

                <el-table
                    :data="data"
                    stripe
                    style="width: 100%"
                    ref="pageTable"
                    v-loading.body="tableIsLoading"
                >
                    <el-table-column prop="name" label="Thubmnail" width="120px">
                        <template slot-scope="scope">
                            <img class="img-thumbnail" :src="scope.row.thumbnail ? scope.row.thumbnail.original_url : '#'" alt="">
                        </template>
                    </el-table-column>
                    <el-table-column prop="name" label="Postingan">
                        <template slot-scope="scope">
                            <a
                                v-if="scope.row.title"
                                @click.prevent="
                                    $router.push({
                                        name: 'posts.draft',
                                        params: {
                                            post: scope.row.id,
                                        },
                                    })
                                "
                                href="#"
                            >
                                {{ scope.row.title }} <br>
                                <span v-for="(item, index) in scope.row.category" :key="index" class="badge badge-primary mr-1"><small>{{ item.name }}</small></span>
                            </a>
                            <span v-else class="text-warning"
                                ><i>(Judul belum dibuat)</i></span
                            >
                            - <span class="text-danger" v-if="scope.row.status == 'draft'"><b><i>{{ scope.row.status }}</i></b></span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="updated_at" label="Diperbaharui">
                        <template slot-scope="scope">
                            {{ scope.row.updated_at }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="actions" label="Aksi">
                        <template slot-scope="scope">
                            <el-button-group>
                                <el-button
                                    v-if="hasAccess('post.post-update')"
                                    type="primary"
                                    size="small"
                                    icon="el-icon-edit"
                                    @click="
                                        $router.push({
                                            name: 'posts.draft',
                                            params: {
                                                post: scope.row.id,
                                            },
                                        })
                                    "
                                ></el-button>
                                <el-button
                                    v-if="hasAccess('post.post-delete')"
                                    size="small"
                                    type="danger"
                                    plain
                                    icon="el-icon-delete"
                                    @click="onDelete(scope.row)"
                                ></el-button>
                            </el-button-group>
                        </template>
                    </el-table-column>
                </el-table>
                <div
                    class="pagination-wrap"
                    style="text-align: center; padding-top: 20px"
                >
                    <el-pagination
                        @size-change="handleSizeChange"
                        @current-change="handleCurrentChange"
                        :current-page.sync="meta.current_page"
                        :page-sizes="[10, 20, 50, 100]"
                        :page-size="parseInt(meta.per_page)"
                        layout="total, sizes, prev, pager, next, jumper"
                        :total="meta.total"
                    ></el-pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import _ from "lodash";

export default {
    data() {
        return {
            data: [],
            tableIsLoading: false,
            meta: {
                current_page: 1,
                per_page: 10,
            },
            order_meta: {
                order_by: "",
                order: "",
            },
            list_roles: [],
            filter: {
                search: "",
            },
            loading_draft: false,
        };
    },

    methods: {
        queryServer(customProperties) {
            const cancelSource = axios.CancelToken.source();
            const properties = {
                params: {
                    page: this.meta.current_page,
                    per_page: this.meta.per_page,
                    order_by: this.order_meta.order_by,
                    order: this.order_meta.order,
                    search: this.searchQuery,
                },
                cancelToken: cancelSource.token,
            };
            this.request = {
                cancel: cancelSource.cancel,
            };
            axios.get(route("api.post.index"), properties).then((response) => {
                if (typeof response !== "undefined") {
                    this.tableIsLoading = false;
                    this.data = response.data.data;
                    this.meta = response.data.meta;
                    this.links = response.data.links;
                    this.order_meta.order_by = properties.order_by;
                    this.order_meta.order = properties.order;
                }
            });
        },
        fetchData() {
            this.tableIsLoading = true;
            if (this.request) this.cancel();
            this.queryServer();
        },
        handleSizeChange(event) {
            console.log(`per page :${event}`);
            this.tableIsLoading = true;
            this.meta.per_page = event;
            this.queryServer();
        },
        handleCurrentChange(event) {
            console.log(`current page :${event}`);
            this.tableIsLoading = true;
            this.meta.current_page = event;
            this.queryServer();
        },
        handleSortChange(event) {
            console.log("sorting", event);
            this.tableIsLoading = true;
            this.queryServer({
                order_by: event.prop,
                order: event.order,
            });
        },
        performSearch: _.debounce(function (query) {
            console.log(`searching:${query.target.value}`);
            this.tableIsLoading = true;
            this.queryServer({
                search: query.target.value,
            });
        }, 300),
        cancel() {
            this.request.cancel();
        },

        onDelete(row) {
            this.$confirm("Apakah anda yakin ?", "Konfirmasi", {
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                type: "warning",
            }).then((result) => {
                axios
                    .delete(
                        route("api.post.destroy", {
                            post: row.id,
                        })
                    )
                    .then((response) => {
                        this.$notify({
                            title: "Pemberitahuan",
                            message: response.data.message,
                            type: "success",
                        });
    
                        this.fetchData();
                    });
            })
        },

        onCreateDraftPost() {
            this.loading_draft = true;
            axios
                .post(route("api.post.store"), {
                    slug: null,
                    title: null,
                    article: null,
                    created_by: this.user.id,
                })
                .then((response) => {
                    this.loading_draft = false;
                    this.$router.push({
                        name: "posts.draft",
                        params: {
                            post: response.data.data.id,
                        },
                    });
                })
                .catch(() => {
                    this.loading_draft = false;
                });
        },
    },

    mounted() {
        this.fetchData();
    },
};
</script>

<style>
.filter-text {
    font-size: 14px !important;
}
</style>