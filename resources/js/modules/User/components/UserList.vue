<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">List User</h1>
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb bg-light">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        User
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div
                class="card-header d-flex justify-content-between align-items-center"
            >
                <span>List User</span>
                <el-button type="primary" size="small" icon="fas fa-plus"
                    >Tambah</el-button
                >
            </div>
            <div class="card-body">
                <el-table
                    :data="data"
                    stripe
                    style="width: 100%"
                    ref="pageTable"
                    v-loading.body="tableIsLoading"
                >
                    <el-table-column prop="full_name" label="Nama">
                        <template slot-scope="scope">
                            <a @click.prevent="goToEdit(scope)" href="#">
                                {{ scope.row.full_name }}
                            </a>
                        </template>
                    </el-table-column>
                    <el-table-column prop="phone" label="Telepon">
                        <template slot-scope="scope">
                            <a @click.prevent="goToEdit(scope)" href="#">
                                {{ scope.row.phone }}
                            </a>
                        </template>
                    </el-table-column>
                    <el-table-column prop="email" label="Email">
                        <template slot-scope="scope">
                            <a @click.prevent="goToEdit(scope)" href="#">
                                {{ scope.row.email }}
                            </a>
                        </template>
                    </el-table-column>
                    <el-table-column prop="actions" label="Aksi">
                        <template slot-scope="scope">
                            <el-button-group>
                                <edit-button
                                    :to="{
                                        name: 'admin.user.users.edit',
                                        params: { userId: scope.row.id },
                                    }"
                                ></edit-button>
                                <delete-button
                                    :scope="scope"
                                    :rows="data"
                                ></delete-button>
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
            axios
                .get(
                    route(
                        "api.user.user.index",
                        _.merge(properties, customProperties)
                    )
                )
                .then((response) => {
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
            this.queryServer({
                per_page: event,
            });
        },
        handleCurrentChange(event) {
            console.log(`current page :${event}`);
            this.tableIsLoading = true;
            this.queryServer({
                page: event,
            });
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
    },
};
</script>