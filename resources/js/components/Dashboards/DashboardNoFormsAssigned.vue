<template>
<div class="w-100 py-3">
    <div class="row">
        <div class="col-md-9">
            <h3 style="font-weight: 500; color: #333; font-size: 1.575rem;">Form Manager</h3>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="unicef-card unicef-dashboard-menu p-4">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12  rounded-sm mainContent ">
                            <div class="row">
                                <div class="col-lg-12 align-self-center text-center py-3">
                                    <div class="card-body">
                                        <img src="/images/icons/asset.forms.png" class="m-auto no-form-image" style="height: 140px;">
                                    </div>
                                    <h3 style="text-align: center; font-size: 18px; color: #333;" class="mt-2">No forms has been assigned to you yet</h3>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 m-0 text-center">
                                    <h5 class="pt-2 text-center">When a form has been assigned to you, it will appear here</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="unicef-card unicef-dashboard-menu p-3">
                        <div class="row">
                            <div class="col-lg-12 py-3 px-4">
                                <h6 class="form-head" style="font-size: 16px; color: #999;">Forms</h6>
                                <h4 class="pt-4 pb-0"  style="font-weight: bold;">0</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="unicef-card unicef-dashboard-menu p-3">
                        <div class="row">
                            <div class="col-lg-12 py-3 px-4">
                                <h6 class="form-head" style="font-size: 16px; color: #999;">Data</h6>
                                <h4 class="pt-4 pb-0"  style="font-weight: bold;">0</h4>
                            </div>
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
    name: "DashboardNoFormsAssigned",

    components: {

    },

    data() {

        return {

        }

    },

    methods: {

    },

}
</script>

<style scoped>
.user_left {
    float: left;
}

.user_right {
    float: right;
}

.user_tag a {
    display: inline-block;
}

.flex-container {
    display: flex;
}

.flex-child {
    flex: 1;

}

.flex-child:first-child {
    margin-right: 2px;
}
</style>
