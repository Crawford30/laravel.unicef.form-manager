<template>
<div class="w-100 py-3">
    <div class="row">
        <div class="col-md-9">
            <h3 style="font-weight: 500; color: #333; font-size: 1.575rem;">Forms</h3>
        </div>
        <div class="col-md-3" v-if="session != null && session.permissions.includes('forms')">
            <button type="button" style="width: 100%;" class="btn btn-primary" @click="createNewForm()">New Form</button>
        </div>
    </div>
    <div class="form-view">
        <div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="form-card shadow-sm table-padding">
                        <div class="row justify-content-center">
                            <table class="table table-sm unicef-forms-list">
                                <thead>
                                    <tr>
                                        <th>FORM NAME</th>
                                        <th>CREATED</th>
                                        <th class="text-center">OWNERS</th>
                                        <th class="text-center">USERS</th>
                                        <th class="text-center">FIELDS</th>
                                        <th class="text-center">DATA</th>
                                        <th class="text-right">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in forms" :key="'form_a_' + index">
                                        <td>
                                            <h6 style="cursor: pointer;" @click="collectData(item)">
                                                <span v-bind:style="{color: item.form_color}" class="mr-2">
                                                    <i class="far fa-file" v-bind:style="{color: item.form_color}"></i>
                                                </span>
                                                {{item.form_name}} <span v-if="!item.is_completed" style="color: red;">(draft)</span>
                                            </h6>
                                        </td>
                                        <td>{{ formatDate(item.created_at) }}</td>
                                        <td class="text-center">{{item.owners.length}}</td>
                                        <td class="text-center">{{item.users.length}}</td>
                                        <td class="text-center">{{item.fields_count}}</td>
                                        <td class="text-center">{{item.data_count}}</td>
                                        <td class="text-right">
                                            <span v-if="item.owner_ids.includes(session.id) || item.user_id == session.id">
                                                <!-- UNICEF Request: Enable editing form if data was collected on the form --> 
                                                <a href="#" @click.prevent="editForm(item.id)">
                                                    <i class="fas fa-pencil-alt" style="color: #999; font-size: 18px;"></i>
                                                </a>
                                                <a @click.prevent="deleteForm(item.id)" href="#" style="margin-left: 8px;">
                                                    <i class="far fa-trash-alt" style="color: #999; font-size: 18px;"></i>
                                                </a>
                                            </span>
                                        </td>
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

import moment from 'moment';
import Swal from 'sweetalert2';
import Izitoast from "../mixin/IziToast";

export default {
    name: "FormList",
    mixins: [
        Izitoast,
    ],
    props: ['user'],
    data() {
        return {
            session: null,
            forms: [],
        }
    },
    mounted() {
        let app = this;
        app.session = app.$props.user;
        app.getForms();
    },
    methods: {
        createNewForm() {
            window.location.href = '/forms/create';
        },
        getForms() {
            let app = this;
            $.ajax({
                url: '/api/form/list/?d=web',
                success: function(response) {
                    app.forms = response;
                },
            });
        },
        formatDate(date) {
            return moment(date).fromNow();
        },
        collectData(form) {
            if(form.is_completed) {
                window.location =  "/forms/collect-data/" + form.id;
            } else {
                this.showErrorMessage('Cannot collect data in a draft form');
            }
        },
        editForm(formId) {
            window.location = "/forms/edit/" + formId
        },
        deleteForm(id) {
            let app = this;
            Swal.fire({
                title: 'Are you sure?',
                html: "<p style='font-size: 14px;'>You won't be able to revert this!</p>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/api/form/delete-form",
                        type: "post",
                        data: {form_id: id},
                        success(data) {
                            app.showSuccessMessage("Form Deleted Successfully")
                            app.getForms();
                        },
                        error(e) {
                            app.showAjaxError(e)
                        }
                    })
                }
            })
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
.unicef-forms-list tr th,
.unicef-forms-list tr td {
    font-size: 13px;
}
</style>
