<template>
<div class="w-100 py-3">
    <div class="row">
        <div class="col-md-12">
            <h3 style="font-weight: 500; color: #333; font-size: 1.575rem;">Form Manager</h3>
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
                        <h5>Avg Data Per Form</h5>
                        <div class="unicef-menu-values">
                            <div class="row">
                                <div class="col-md-7">
                                    <h2>{{average}}</h2>
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

        <div class="col-md-12 m-0">
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
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h3 style="font-size: 17px;">Timeline</h3>
                            </div>
                        </div>

                        <div class="unicef-timeline" v-for="time in logs" v-bind:key="'timeline__' + time.id">
                            <div class="timeline-icon" :style="{'border-color': time.color}">
                                <i :class="time.icon" :style="{color: time.color}"></i>
                            </div>
                            <div class="timeline-text">
                                <p class="text mb-0 mt-0">{{time.title}}</p>
                                <p class="date mb-0 mt-0">{{formatDate(time.created_at)}}</p>
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
    name: "DashboardNoPermission",
    props: ['forms', 'users', 'data', 'timeline', 'stats'],
    components: {
        SmallGraph,
        HorizontalBarGraph
    },

    data() {
        return {
            average: 0,
            dataStats: [],
            logs: []
        }
    },

    mounted() {
        let app = this;
        if(parseInt(app.forms) != 0) {
            app.average = parseInt(app.data) / parseInt(app.forms);
        }
        app.logs = JSON.parse(app.$props.timeline);
        app.dataStats = JSON.parse(app.$props.stats);
    },
    methods: {
        formatDate(date) {
            return moment(date).fromNow()
        }
    }
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
