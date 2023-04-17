<template>
<div>
    <div class="container">
        <div class="row my-3">
            <div class="col-md-3">
                <h4>Assigned Forms</h4>
            </div>
        </div>
    </div>

    <div class="form-view">
        <div class="container">
            <div class="row mt-3">
                <div class="col-12 ml-0 pl-0">
                    <div class="form-card shadow-sm table-padding">
                        <div class="row justify-content-center">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>FORM NAME</th>
                                        <th>CREATED</th>
                                        <th>FIELDS</th>
                                        <th>DATA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in currentUserFormsAssigned" :key="'a_'  +index">
                                        <td>
                                            <div>
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <img src="/images/icons/asset.forms.png" alt="" style="width: 20px; height:20px;">
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <a :href="formUrl(item)">{{item.formdetails.form_name}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ item.formdetails.warrantyDateHumanReadable }}
                                        </td>
                                        <div v-if="item.formdetails.field_type.length === 0">
                                            <td>0</td>
                                        </div>
                                        <div v-else>
                                            <td>{{item.formdetails.field_type.length}}</td>
                                        </div>
                                        <td>5 (to do)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {
    bus
} from '../../app.js'
import dayjs from 'dayjs';
import Izitoast from "../mixin/IziToast";
import relativeTime from 'dayjs/plugin/relativeTime';
import axios from 'axios';

export default {
    name: "FormListAssigned",

    mixins: [
        Izitoast,
    ],
    props: ['assignedformtouser'],

    data() {
        return {
            currentUserFormsAssigned: [],

        }
    },

    mounted() {
        let app = this;
        app.currentUserFormsAssigned = app.$props.assignedformtouser;
        //console.log("FORMS ASSIGNED", app.currentUserFormsAssigned);

    },

    created() {
        dayjs.extend(relativeTime);
    },

    filters: {
        diffForHumans: (date) => {
            if (!date) {
                return null;
            }
            return dayjs(date).fromNow();
        }
    },

    methods: {
        formUrl(form) {
            return "use-form/" + form.form_id;
        },
    },
}
</script>

<style scoped>
.form-view,
.form-card {
    background: #fff;
}

.form-view .table-padding {
    padding: 25px 35px;
}

.shadow-sm {
    box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
}
</style>
