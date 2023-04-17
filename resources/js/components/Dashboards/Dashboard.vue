<template>
<div class="w-100 py-3">

    <div class="row">
        <div class="col-md-9">
            <h3 style="font-weight: 500; color: #333; font-size: 1.575rem;">Form Manager</h3>
        </div>
        <div class="col-md-3">
            <button type="button" style="width: 100%;" class="btn btn-primary" @click="createNewForm()">New Form</button>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12 m-0">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="unicef-card unicef-dashboard-menu p-4">
                        <h5>Forms</h5>
                        <div class="unicef-menu-values">
                            <div class="row">
                                <div class="col-md-7">
                                    <h2>{{forms}}</h2>
                                    <p class="red"><i class="fas fa-long-arrow-alt-down"></i><span>0%</span></p>
                                </div>
                                <div class="col-md-5">
                                    <div class="unicef-menu-chart">
                                        <SmallGraph width="100%" id="bar1" color="#54d8ff" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="unicef-card unicef-dashboard-menu p-4">
                        <h5>Data</h5>
                        <div class="unicef-menu-values">
                            <div class="row">
                                <div class="col-md-7">
                                    <h2>{{data}}</h2>
                                    <p class="green"><i class="fas fa-long-arrow-alt-up"></i><span>0%</span></p>
                                </div>
                                <div class="col-md-5">
                                    <div class="unicef-menu-chart">
                                        <SmallGraph width="100%" id="bar2" color="#54d8ff" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="unicef-card unicef-dashboard-menu p-4">
                        <h5>Users</h5>
                        <div class="unicef-menu-values">
                            <div class="row">
                                <div class="col-md-7">
                                    <h2>{{users}}</h2>
                                    <p class="red"><i class="fas fa-long-arrow-alt-down"></i><span>0%</span></p>
                                </div>
                                <div class="col-md-5">
                                    <div class="unicef-menu-chart">
                                        <SmallGraph width="100%" id="bar3" color="#000" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="row mt-2">
                <div class="col-md-8">
                    <div style="min-height: 496px; height: 596px;" class="unicef-card unicef-dashboard-menu p-4">
                        <div class="row mt-2">
                            <div style="width: 272px !important; text-align: right;">
                                <h3 style="font-size: 16px; text-align: right;">Assigned Forms</h3>
                            </div>
                            <div class="col-md-4">
                                <h3 style="font-size: 16px; padding-left: 12px;">Collected Data</h3>
                            </div>
                        </div>
                        <HorizontalBarGraph :categoryHeight="55" :textSize="13" :data="dataStats" class="mt-3" width="100%" barId="unicef-collected-data-stats"></HorizontalBarGraph>
                    </div>
                </div>

                <div class="col-md-4">
                    <div style="min-height: 496px; height: 596px;" class="unicef-card unicef-dashboard-menu p-4">
                        <div class="row">
                            <div class="col-md-3">
                                <h5 @click.prevent="activateTab(0)" :class="{'selected-menu': tab == 0}" class="pb-3 mb-0" style="cursor: pointer;"><a style="font-size: 14px; color: #666; text-decoration: none;" href="#">Users</a> </h5>
                            </div>
                            <div class="col-md-3">
                                <h5 @click.prevent="activateTab(1)" :class="{'selected-menu': tab == 1}" class="pb-3 mb-0" style="cursor: pointer;"><a style="font-size: 14px; color: #666; text-decoration: none;" href="#">Forms</a></h5>
                            </div>
                        </div>
                        <hr class="m-0">
                        <div class="mt-3" v-if="tab == 0">
                            <div v-for="(record, x) in userRecords" :key="'user_record_' + x">
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
                        <div class="mt-3" v-if="tab == 1">
                            <div v-for="(record, x) in userForms" :key="'user_record_' + x">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import SmallGraph from "./../graph/SmallGraph";
import HorizontalBarGraph from "./../graph/HorizontalBarGraph";

export default {
    name: "Dashboard",
    props: ["forms", "users", "data", "stats", "records", "assignments"],
    components: {
        SmallGraph,
        HorizontalBarGraph
    },
    
    data() {
        return {
            tab: 0,
            dataStats: [],
            userRecords: [],
            userForms: []
        }
    },
    mounted() {
        let app = this;
        app.dataStats = JSON.parse(app.$props.stats);
        app.userRecords = JSON.parse(app.$props.records);
        app.userForms = JSON.parse(app.$props.assignments);
    },
    methods: {
        createNewForm() {
            window.location.href = '/forms/create';
        },
        activateTab(t) {
            this.tab = t;
        }
    }
}
</script>

<style scoped>
.flex-container {
    display: flex;
}

.flex-child {
    flex: 1;
}

.flex-child:first-child {
    margin-right: 2px;
}

.selected-menu {
    border-bottom: 2px solid #666;
}
</style>
