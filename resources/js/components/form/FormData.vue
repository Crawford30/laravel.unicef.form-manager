<template>
<div class="w-100 py-3">
    <div class="row">
        <div class="col-md-9">
            <h3 style="font-weight: 500; color: #333; font-size: 1.575rem;">Data</h3>
        </div>
        <div class="col-md-3" v-if="session != null && session.permissions.includes('forms')">
            <button type="button" style="width: 100%;" class="btn btn-primary" @click="createNewForm()">New Form</button>
        </div>
    </div>
    <div>
        <div class="row mt-3">
            <div class="col-md-8">
                <div class="form-card shadow-sm table-padding">
                    <div class="row mt-2" style="position: relative;">
                        <div style="width: 272px !important; text-align: right;">
                            <h3 style="font-size: 16px; text-align: right;">Created Forms</h3>
                        </div>
                        <div class="col-md-4">
                            <h3 style="font-size: 16px; padding-left: 12px;">Collected Data</h3>
                        </div>
                        <div>
                            <select @change="updateDataCount" class="form-control custom-select" style="position: absolute; right: 0; top: -6px; width: 140px; font-size: 12px;">
                                <option value="0">Entire Lifetime</option>
                                <option value="6">Last 6 months</option>
                                <option value="3">Last 3 months</option>
                                <option value="1">Last Month</option>
                            </select>
                        </div>
                    </div>
                    <HorizontalBarGraph :categoryHeight="55" :textSize="13" :data="dataStats" class="mt-3" width="100%" barId="unicef-collected-data-stats"></HorizontalBarGraph>
                    <div class="row">
                        <div class="col text-right">
                            <img @click="loadVerticalBarGraph" src="/images/icons/Icon.reports.png" width="50" height="50"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-card shadow-sm table-padding" v-if="session != null && session.permissions.includes('forms')">
                    <div class="unicef-timeline mb-0">
                        <div class="timeline-icon" style="border-color: #4ad991; width: 40px; height: 40px;">
                            <i class="fas fa-user-friends" style="color: #4ad991; line-height: 40px;"></i>
                        </div>
                        <div class="timeline-text" style="margin-left: 52px;">
                            <h6 class="mb-0" style="color: #4ad991">{{users}}</h6>
                            <p class="text mb-0 mt-0" style="font-size: 12px;">Total Users</p>
                            <p class="date mb-0 mt-0">Users can collect data using the forms</p>
                        </div>
                    </div>
                </div>
                <div class="form-card shadow-sm table-padding mt-3">
                    <div class="unicef-timeline mb-0">
                        <div class="timeline-icon" style="border-color: #a3a0fb; width: 40px; height: 40px;">
                            <i class="fas fa-database" style="color: #a3a0fb; line-height: 40px;"></i>
                        </div>
                        <div class="timeline-text" style="margin-left: 52px;">
                            <h6 class="mb-0" style="color: #a3a0fb">{{data}}</h6>
                            <p class="text mb-0 mt-0" style="font-size: 12px;">Total Records</p>
                        </div>
                    </div>
                </div>
                <div class="form-card shadow-sm table-padding mt-3" v-if="session != null && session.permissions.includes('forms')">
                    <div class="unicef-timeline mb-0">
                        <div class="timeline-icon" style="border-color: #ff6565; width: 40px; height: 40px;">
                            <i class="fas fa-user-friends" style="color: #ff6565; line-height: 40px;"></i>
                        </div>
                        <div class="timeline-text" style="margin-left: 52px;">
                            <h6 class="mb-0" style="color: #ff6565">{{viewers}}</h6>
                            <p class="text mb-0 mt-0" style="font-size: 12px;">Total Viewers</p>
                            <p class="date mb-0 mt-0">Viewers can see the data collected using the forms</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>

import HorizontalBarGraph from "./../graph/HorizontalBarGraph.vue"

export default {
    name: "FormData",
    components: {HorizontalBarGraph},
    props: ["user", "users", "data", "viewers", "stats"],
    data() {
        return {
            session: null,
            dataStats: []
        }
    },
    mounted() {
        let app = this;
        app.session = app.$props.user;
        app.dataStats = app.$props.stats;
    },
    methods: {
        loadVerticalBarGraph(){

        },
        createNewForm() {
            window.location.href = '/forms/create';
        },
        updateDataCount(e) {
            let app = this;
            let month = $(e.target).val();

            $.ajax({
                url: '/api/form/data/stats',
                data: {month: month},
                success: function(response) {
                    app.dataStats = response.results;
                }
            })
        }
    },
}
</script>

<style scoped>
.form-view,
.form-card {
    background: #fff;
}

.table-padding {
    padding: 25px 35px;
}

.shadow-sm {
    box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
}
</style>
