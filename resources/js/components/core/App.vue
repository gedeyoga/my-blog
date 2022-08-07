<template>
    <div>
        <div id="wrapper">
            <side-bar></side-bar>

            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <navbar></navbar>
                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-body">
                                <el-input placeholder="Please input" v-model="input"></el-input>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            input: null,
        }
    },
}
</script>
