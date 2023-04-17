<template>
<div class="w-100 py-3">
    <div class="row">
        <div class="col-md-12">
            <h3 style="font-weight: 500; color: #333; font-size: 1.575rem;">Data :: Form :: {{form.form_name}}</h3>
        </div>
    </div>
    <div>
        <div class="row mt-3">
            <div class="col-md-8">
                <div class="form-card shadow-sm table-padding">
                    <div class="row mt-2" style="position: relative;">
                        <div style="width: 272px !important; text-align: right;">
                            <h3 style="font-size: 15px; text-align: right;">Form Questions</h3>
                        </div>
                        <div class="col-md-4">
                            <h3 style="font-size: 15px; padding-left: 12px;">Collected Data</h3>
                        </div>
                        <div style="position: absolute; right: 0; top: -6px; width: 220px; font-size: 12px;">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <select id="form-users-select" @change="onFormUserUpdate" class="form-control custom-select" style="font-size: 11px;">
                                        <option value="0">All Users</option>
                                        <option v-for="u in users" :key="'user_q_' + u.id" :value="u.id">{{u.name}}</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select id="form-date-select" @change="onFormTimeUpdate" class="form-control custom-select" style="font-size: 11px;">
                                        <option value="0">Entire Lifetime</option>
                                        <option value="6">Last 6 months</option>
                                        <option value="3">Last 3 months</option>
                                        <option value="1">Last Month</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <HorizontalBarGraph :categoryHeight="75" :textSize="13" :data="dataStats" class="mt-3" width="100%" barId="unicef-collected-data-stats"></HorizontalBarGraph>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-card shadow-sm table-padding">
                    <div class="unicef-timeline mb-0">
                        <div class="timeline-icon" style="border-color: #4ad991; width: 40px; height: 40px;">
                            <i class="fas fa-user-friends" style="color: #4ad991; line-height: 40px;"></i>
                        </div>
                        <div class="timeline-text" style="margin-left: 52px;">
                            <h6 class="mb-0" style="color: #4ad991">{{form.users_count}}</h6>
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
                            <h6 class="mb-0" style="color: #a3a0fb">{{form.data_count}}</h6>
                            <p class="text mb-0 mt-0" style="font-size: 12px;">Total Records</p>
                        </div>
                    </div>
                </div>
                <div class="form-card shadow-sm table-padding mt-3">
                    <div class="unicef-timeline mb-0">
                        <div class="timeline-icon" style="border-color: #ff6565; width: 40px; height: 40px;">
                            <i class="fas fa-user-friends" style="color: #ff6565; line-height: 40px;"></i>
                        </div>
                        <div class="timeline-text" style="margin-left: 52px;">
                            <h6 class="mb-0" style="color: #ff6565">{{form.viewers_count}}</h6>
                            <p class="text mb-0 mt-0" style="font-size: 12px;">Total Viewers</p>
                            <p class="date mb-0 mt-0">Viewers can see the data collected using the forms</p>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button @click="exportData" class="unicef-btn unicef-success px-5 py-3" style="width:100%; font-size: 16px;">
                        EXPORT DATA <i class="fas fa-cloud-download-alt"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-export-data">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal body -->
                <form action="/data-forms/export" method="POST">
                    <div class="modal-body py-4">
                        <h5 style="text-align: center; font-weight: bold;">Export Data</h5>
                        <br>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label>Form</label>
                                    <input type="text" class="form-control" :value="form.form_name" disabled>
                                    <input type="hidden" name="form_id" :value="form.id">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label>Filter By</label>
                                    <select @change="onChangeFilter" class="form-control custom-select" name="filter_by" required>
                                        <option value="0">Entire Lifetime</option>
                                        <option value="6">Last 6 months</option>
                                        <option value="3">Last 3 months</option>
                                        <option value="1">Last Month</option>
                                        <option value="-1">Custom Date</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12" v-if="customDate">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label>From</label>
                                            <date-picker v-model="start_date" :config="this.dateOptions"></date-picker>
                                            <input type="hidden" v-model="start_date" name="start_date" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label>To</label>
                                            <date-picker v-model="end_date" :config="this.dateOptions"></date-picker>
                                            <input type="hidden" v-model="end_date" name="end_date" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label>Format</label>
                                    <select class="form-control custom-select" name="format" required>
                                        <option value="" selected disabled>Select Format</option>
                                        <option value="csv">CSV</option>
                                        <option value="xls">Excel</option>
                                        <!-- <option value="pdf">PDF</option> -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center mt-3">
                            <button type="submit" class="unicef-btn unicef-primary">
                                EXPORT
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</template>

<script>

import datePicker from "vue-bootstrap-datetimepicker"
import HorizontalBarGraph from "./../graph/HorizontalBarGraph.vue"

export default {
    name: "CollectedFormData",
    components: {HorizontalBarGraph, datePicker},
    props: ["user", "form", "stats", "users"],
    data() {
        return {
            session: null,
            dataStats: [],
            customDate: false,
            dateOptions: {
                format: 'YYYY-MM-DD',
                useCurrent: false,
                maxDate: new Date(),
                icons: {
                    time: "far fa-clock",
                    date: "far fa-calendar-alt",
                    up: "fas fa-chevron-up",
                    down: "fas fa-chevron-down",
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right',
                    today: 'fas fa-calendar-check',
                    clear: 'far fa-trash-alt',
                    close: 'far fa-times-circle'
                }
            },
            start_date: '',
            end_date: '',
        }
    },
    mounted() {
        let app = this;
        app.session = app.$props.user;
        app.getQuestionStats(0, 0);
        let today = new Date();
        app.end_date = today.getFullYear() + '-' + ("0" + (today.getMonth() + 1)).slice(-2) + '-' + today.getDate();
    },
    methods: {
        onFormUserUpdate(e) {
            let app = this;
            let user = $(e.target).val();
            let time = $("#form-date-select").val();
            app.getQuestionStats(user, time);
        },
        onFormTimeUpdate(e) {
            let app = this;
            let user = $("#form-users-select").val();
            let time = $(e.target).val()
            app.getQuestionStats(user, time);
        },
        getQuestionStats(user, month) {
            let app = this;
            $.ajax({
                url: '/api/form/data-form/stats/' + app.form.id,
                data: {month: month, user_id: user},
                success: function(response) {
                    app.dataStats = response.results;
                }
            })
        },
        exportData() {
            $("#modal-export-data").modal("show");
        },
        onChangeFilter(e) {
            let app = this;
            let value = $(e.target).val();
            app.customDate = parseInt(value) == -1;
        },
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