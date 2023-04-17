<template>
    <div>
        <div class="modal fade" id="modal-export-data-global">
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
                                        <select name="form_id" class="form-control custom-select" required>
                                            <option value="" selected disabled>Select form</option>
                                            <option v-for="form in forms" :key="'form_list_item_' + form.id" :value="form.id">{{form.form_name}}</option>
                                        </select>
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
export default {
    name: 'export-data',
    components: {datePicker},
    mounted() {
        this.getForms();
        let today = new Date();
        this.end_date = today.getFullYear() + '-' + ("0" + (today.getMonth() + 1)).slice(-2) + '-' + today.getDate();
    },
    data() {
        return {
            forms: [],
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
    methods: {
        onChangeFilter(e) {
            let app = this;
            let value = $(e.target).val();
            app.customDate = parseInt(value) == -1;
        },
        getForms() {
            let app = this;
            $.ajax({
                url: '/api/form/list',
                success: function(response) {
                    app.forms = response;
                },
            });
        },
    },
}
</script>