<template>
<div class="w-100 py-3">
    <div class="row">
        <div class="col-md-9">
            <h3 style="font-weight: 500; color: #333; font-size: 1.575rem;">Users</h3>
        </div>
        <div class="col-md-3" v-if="session != null && session.permissions.includes('forms')">
            <button type="button" style="width: 100%;" class="btn btn-primary" @click="createNewForm()">New Form</button>
        </div>
    </div>
    <div>
        <div class="row mt-3">
            <div class="col-md-8">
                <div class="form-card shadow-sm table-padding pt-0">
                    <div class="row">
                        <div class="col-md-12 border-bottom" style="padding: 0 !important;">
                            <nav class="nav nav-tab" id="unicef-tabs-form-users">
                                <a data-tab="0" @click.prevent="updateTab" href="#" style="color: #333; padding-left: 2.5rem !important; padding-right: 2.5rem !important; font-size: 16px;" class="nav-item nav-link active">Users</a>
                                <a data-tab="1" @click.prevent="updateTab" href="#" style="color: #333; padding-left: 2.5rem !important; padding-right: 2.5rem !important; font-size: 16px;" class="nav-item nav-link">Forms</a>
                                <a data-tab="2" @click.prevent="updateTab" href="#" style="color: #333; padding-left: 2.5rem !important; padding-right: 2.5rem !important; font-size: 16px;" class="nav-item nav-link">Sections/Units</a>
                            </nav>
                        </div>
                    </div>
                    <div class="mt-4 mx-3" v-if="tab == 0">
                        <div v-for="(record, x) in records" :key="'user_record_' + x">
                            <div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <img src="/images/unicef_avatar.png" alt="" style="width: 40px; height:40px; border-radius:50%;">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="row mb-1">
                                            <div class="col-md-7">
                                                <p class="mb-0" style="font-size: 11px;">{{record.name}}</p>
                                            </div>
                                            <div class="col-md-5 text-right">
                                                <p class="mb-0" style="font-size: 11px;">{{record.data}} <span v-if="record.data > 1">Records</span><span v-else>Record</span></p>
                                            </div>
                                        </div>
                                        <progress style="width: 100%;" :value="record.percent" max="100">70 %</progress>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-2">
                        </div>
                    </div>
                    <div class="mt-4 mx-3" v-if="tab == 1">
                        <div v-for="(record, x) in assignments" :key="'user_record_' + x">
                            <div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <img src="/images/unicef_avatar.png" alt="" style="width: 40px; height:40px; border-radius:50%;">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="row mb-1">
                                            <div class="col-md-7">
                                                <p class="mb-0" style="font-size: 11px;">{{record.name}}</p>
                                            </div>
                                            <div class="col-md-5 text-right">
                                                <p class="mb-0" style="font-size: 11px;">{{record.data}} <span v-if="record.data > 1">Forms</span><span v-else>Form</span></p>
                                            </div>
                                        </div>
                                        <progress style="width: 100%;" :value="record.percent" max="100">70 %</progress>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-2">
                        </div>
                    </div>
                    <div class="mt-4 mx-3" v-if="tab == 2">
                        <div v-for="(record, x) in section" :key="'section_record_' + x">
                            <div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <img src="/images/unicef_avatar.png" alt="" style="width: 40px; height:40px; border-radius:50%;">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="row mb-1">
                                            <div class="col-md-7">
                                                <p class="mb-0" style="font-size: 11px;">{{record.section}}</p>
                                            </div>
                                            <div class="col-md-5 text-right">
                                                <p class="mb-0" style="font-size: 11px;">{{record.data}} <span v-if="record.data > 1">Records</span><span v-else>Record</span>, {{record.forms}} <span v-if="record.forms > 1">Forms</span><span v-else>Form</span></p>
                                            </div>
                                        </div>
                                        <progress style="width: 100%;" :value="record.percent" max="100">70 %</progress>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-card shadow-sm table-padding">
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
                <div class="form-card shadow-sm table-padding mt-3">
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

export default {
    name: "FormUsers",
    props: ["user", "forms", "users", "data", "records", "assignments", "viewers", "section"],
    data() {
        return {
            session: null,
            tab: 0
        }
    },
    mounted() {
        let app = this;
        app.session = app.$props.user;
    },
    methods: {
        createNewForm() {
            window.location.href = '/forms/create';
        },
        updateTab(e) {
            let app = this;
            let el = $(e.target);
            var t = el.attr("data-tab");
            app.tab = parseInt(t);
            el.addClass("active").siblings().removeClass("active");
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
