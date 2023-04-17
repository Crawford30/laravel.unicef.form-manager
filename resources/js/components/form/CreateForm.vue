<template>
<div class="w-100 py-3">
    <div class="position-relative container">
        <button @click.prevent="goBack" type="button" style="position: absolute; left:1.5rem; top:0.5rem;" class="close">
            <i class="fas fa-arrow-left"></i>
        </button>
        <div id="workshop-stepper" class="bs-stepper">
            <div class="justify-content-center text-center">
                <h4 style="margin-bottom: 15px;" class="mt-2">
                    <span v-if="formId != null && formId != undefined">Edit Form</span>
                    <span v-else>New Form</span>
                </h4>
                <div class="bs-stepper-header" style="margin: auto; width: 65%;">
                    <div class="step" data-target="#step1-view">
                        <button type="button" class="btn step-trigger" :class="{'active': step >= 1}">
                            <span class="bs-stepper-circle"><i class="fa fa-check"></i></span>
                            <br>
                            <span class="bs-stepper-label">
                                <span v-if="formId != null && formId != undefined">Edit Form</span>
                                <span v-else>New Form</span>
                            </span>
                        </button>
                    </div>
                    <div class="line" :class="{'active': step > 1}"></div>
                    <div class="step" data-target="#step2-view">
                        <button type="button" class="btn step-trigger" :class="{'active': step >= 2}">
                            <span v-if="step >= 2" class="bs-stepper-circle"><i class="fa fa-check"></i></span>
                            <span v-else class="bs-stepper-circle">2</span>
                            <br>
                            <span class="bs-stepper-label">Assign Users</span>
                        </button>
                    </div>
                    <div class="line" :class="{'active': step > 2}"></div>
                    <div class="step" data-target="#step2-view">
                        <button type="button" class="btn step-trigger" :class="{'active': step >= 3}">
                            <span v-if="step >= 3" class="bs-stepper-circle"><i class="fa fa-check"></i></span>
                            <span v-else class="bs-stepper-circle">3</span>
                            <br>
                            <span class="bs-stepper-label">Assign Owners</span>
                        </button>
                    </div>
                    <div class="line" :class="{'active': step > 3}"></div>
                    <div class="step" data-target="#step2-view">
                        <button type="button" class="btn step-trigger" :class="{'active': step >= 4}">
                            <span v-if="step >= 4" class="bs-stepper-circle"><i class="fa fa-check"></i></span>
                            <span v-else class="bs-stepper-circle">4</span>
                            <br>
                            <span class="bs-stepper-label">Publish</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <form id="create-form-form" class="mt-5">
            <div>
                <div class="col-md-12 rounded-sm p-5 bg-white">
                    <div class="form-group">
                        <label for="form_name">Form Name</label>
                        <input v-model="formName" name="form_name" type="text" placeholder="Name" id="form_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="form_description">Form Description</label>
                        <input v-model="formDescription" name="form_description" type="text" id="form_description" placeholder="Description" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="form_categories">Categories</label>
                        <div class="col-md-6">
                            <multiple-input v-if="draftForm != null" input-name="form_categories" :inputs-values="draftForm.categories" placeholder="Form Sub Category" :delete-button="true"/>
                            <multiple-input v-else input-name="form_categories" placeholder="Form Sub Category" :delete-button="true"/>
                        </div>
                    </div>
                </div>

                <draggable
                    v-model="questionsOrder"
                    @start="drag=true"
                    @end="drag=false;">
                    <div class="grabbable" v-for="(i, k) in questionsOrder" :key="'input_' + i" :id="'form_input_' + i">
                        <div v-if="draftForm != null && draftForm.fields != null && draftForm.fields[k] != null">
                            <FormInput @delete-field ="deleteFields($event,i)" @copy-field="copyField($event)" :position="position" :initial-input="draftForm.fields[k]" :input-id="k" class="mb-4" :form-categories="categories" :default-type="fieldCopy" />
                        </div>
                        <div v-else>
                            <FormInput @delete-field ="deleteFields($event,i)" @copy-field="copyField($event)" :position="position" :input-id="k" class="mb-4" :form-categories="categories" :default-type="fieldCopy" />
                        </div>
                    </div>
                </draggable>

                <!-- <div class="mt-2" v-if="draftForm == null || (draftForm != null && draftForm.data_count == 0)">
                    <button @click="addMoreField()" type="button" class="btn btn-success add-more-btn py-2 m-0">
                        <span class="fa fa-plus"></span>
                    </button> -->
                    <!-- <button v-show="inputs > 1" @click="deleteFields" type="button" class="btn btn-success add-more-btn py-2 ml-2">
                        <span class="fa fa-trash"></span>
                    </button> -->
                <!-- </div> -->
                <div class="mt-2">
                    <button @click="addMoreField()" type="button" class="btn btn-success add-more-btn py-2 m-0">
                        <span class="fa fa-plus"></span>
                    </button>
                </div>
            </div>

            <div class="col-12 mt-3 text-center">
                <button v-if="draftForm == null || (draftForm != null && !draftForm.is_completed)" :disabled="isProcessing" type="submit" class="unicef-btn unicef-secondary" @click="saveAndCompleteLater">
                    <span><i v-if="isProcessing" class="fa fa-spinner fa-spin"> </i> SAVE &amp; COMPLETE LATER</span>
                </button>
                <button type="button" class="btn unicef-btn unicef-primary" @click="showAssignUserModal">
                    PROCEED
                </button>
            </div>

            <!-- Assign User Modal Start -->
            <div class="modal fade" id="modal-assign-user">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal body -->
                        <div class="modal-body py-4">
                            <button type="button" style="position: absolute; right: 1.5rem; top: 1.5rem;" class="close" @click="closeDialog">&times;</button>
                            <h5 style="text-align: center; font-weight: bold;">Who can use this form?</h5>
                            <br>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <select class="form-control select-staff custom-select" name="form_users[]" multiple="multiple" id="select-staff-form-users">
                                            <option v-for="item in staff" :selected="draftForm != null && draftForm.user_profile_ids.includes(item.id)" v-bind:key="item.personal_id" :value="item.id">{{item.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="mx-3">
                                            <div v-for="user in selectedFormUsers" v-bind:key="'form_user_' + user.id" class="row border-bottom py-2">
                                                <div class="col-md-2 text-center p-0">
                                                    <img src="/images/unicef_avatar.png" alt="" class="text-center" style="width: 35px; height:35px;  border-radius:50%;">
                                                </div>
                                                <div class="col-md-10 p-0">
                                                    <p class="pb-0 mb-0 pt-2">{{ user.name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-3">
                                <button type="button" @click="proceedToAssignOwners" class="unicef-btn unicef-primary">
                                    PROCEED TO ASSIGN OWNERS
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Assign User Modal End -->

            <!-- Who Else Owns This Form Modal Start -->
            <div class="modal fade" id="who-else-owns-this-form">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal body -->
                        <div class="modal-body py-4">
                            <button type="button" style="position: absolute; right: 1.5rem; top: 1.5rem;" class="close" @click="closeDialog">&times;</button>
                            <h5 style="text-align: center; font-weight: bold;">Besides yourself, who else owns this form?</h5>
                            <br>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <select class="form-control select-staff custom-select" name="form_owners[]" multiple="multiple" id="select-staff-form-owners">
                                            <option v-for="item in staff" v-bind:key="item.personal_id" :selected="item.email == session.email || (draftForm != null && draftForm.owner_profile_ids.includes(item.id))" :value="item.id">{{item.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="mx-3">
                                            <div v-for="user in selectedFormOwners" v-bind:key="'form_owner_' + user.id" class="row border-bottom py-2">
                                                <div class="col-md-2 text-center p-0">
                                                    <img src="/images/unicef_avatar.png" alt="" class="text-center" style="width: 35px; height:35px;  border-radius:50%;">
                                                </div>
                                                <div class="col-md-10 p-0">
                                                    <p class="pb-0 mb-0 pt-2">{{ user.name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-3">
                                <button type="button" @click="showColorAndViewFormModal" class="unicef-btn unicef-primary">
                                    PROCEED TO PUBLISH FORM
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Who Else Owns This Form Modal End -->

            <!-- View Form, Select Color  Modal Start -->
            <div class="modal fade" id="view-form-select-color">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <!-- Modal body -->
                        <div class="modal-body py-5">
                            <button type="button" style="position: absolute; right: 1.5rem; top: 1.5rem;" class="close" @click="closeDialog">&times;</button>
                            <div class="mx-auto">
                                <h3 style="text-align: center; font-weight: 400;">Great, now let's make your form usable</h3>
                                <div class="d-block text-center mt-2">
                                    <h6 style="font-size: 14px;">Before publishing, check to ensure all the details below are right</h6>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12 mb-1">
                                <div class="d-block text-center">
                                    <h4 style="font-size: 14px;">Form Name</h4>
                                </div>
                                <div class="d-block text-center">
                                    <h6 style="font-size: 18px;">{{formName}}</h6>
                                </div>
                            </div>
                            <div class="my-4 px-4">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="d-block text-center">
                                            <div class="box">
                                                <span class="image-rounded-corner form-file-icon">
                                                    <i class="far fa-file"></i>
                                                </span>
                                                <div class="text">
                                                    <div v-if="selectedFormUsers.length === 1">
                                                        <h4 class="pb-0 mb-0 mt-2" style="color: #666; font-weight: bold;">{{selectedFormUsers.length}}</h4>
                                                        <h6 style="color: #666;">User</h6>
                                                    </div>
                                                    <div v-else>
                                                        <h4 class="pb-0 mb-0 mt-2" style="color: #666; font-weight: bold;">{{selectedFormUsers.length}}</h4>
                                                        <h6 style="color: #666;">Users</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="d-block text-center">
                                            <div class="box">
                                                <span class="image-rounded-corner form-file-icon">
                                                    <i class="far fa-file"></i>
                                                </span>
                                                <div class="text">
                                                    <div v-if="fieldCount === 1">
                                                        <h4 class="pb-0 mb-0 mt-2" style="color: #666; font-weight: bold;">{{fieldCount}}</h4>
                                                        <h6 style="color: #666;">Field</h6>
                                                    </div>
                                                    <div v-else>
                                                        <h4 class="pb-0 mb-0 mt-2" style="color: #666; font-weight: bold;">{{fieldCount}}</h4>
                                                        <h6 style="color: #666;">Fields</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-block text-center" v-on:click="isColorSwatchHidden = !isColorSwatchHidden" style="cursor: pointer;">
                                            <div class="box">
                                                <span class="image-rounded-corner form-file-icon" v-bind:style="{color: selectedColor}">
                                                    <i class="far fa-file" v-bind:style="{color: selectedColor}"></i>
                                                </span>
                                                <div class="text">
                                                    <h6 class="pt-2 mt-2" style="color: #666;">Change Color</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <h6 class="text-center" style="margin-top: 6.5rem;">OR</h6>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="text-center mt-4 pt-1">
                                            <IconUpload />
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="color_row_container mb-4" v-if="!isColorSwatchHidden">
                                        <div v-for="(colorname,index) in swatches" :key="index">
                                            <div @click="onSelectColorsTapped(colorname)" class="color_row_block" v-bind:style="{ background: colorname.color }"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-block text-center my-4">
                                    <h6 style="font-size: 16px;"><a href="#" @click.prevent="seeWhatYourFormWillLook">See what your form will look like</a></h6>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button @click.prevent="processCreateForm" :disabled="isProcessing" type="submit" class="unicef-btn unicef-primary">
                                    <span><i v-if="isProcessing" class="fa fa-spinner fa-spin"> </i> PUBLISH AND FINISH</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- View Form, Select Color  Modal End -->

            <!-- See What your Form Look Will Like Modal Start -->
            <div class="modal fade" id="see-what-your-form-will-look-like">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <!-- Modal body -->
                        <div class="modal-body py-4">
                            <button type="button" style="position: absolute; right: 1.5rem; top: 1.5rem;" class="close" @click="closeSeeWhatYourFormWillLookLike">&times;</button>

                            <div class="mx-auto text-center">
                                <img src="/images/unicef.logo.blue.png" class="text-center" alt="" style="height: 50px;">
                            </div>

                            <div class="py-4">
                                <div class="col-md-12 text-center">
                                    <h6 v-if="session != null">You are submitting this entry as <span style="color: blue;">{{session.name}}</span></h6>
                                </div>
                            </div>
                            <br>
                            <div v-if="formPreview != null" class="px-5">
                                <div class="col-md-12 px-0">
                                    <div class="text-left">
                                        <h4 style="font-size: 22px; font-weight: 600;">{{formPreview.form_name}}</h4>
                                    </div>
                                    <div class="text-left">
                                        <h6 style="font-size: 12px;">{{formPreview.form_description}}</h6>
                                    </div>
                                </div>
                                <hr>
                                <div class="my-4">
                                    <div v-for="(key, index) in Object.keys(formPreview.fields)" :key="'form_field_' + index" class="mb-3">
                                        <h3 class="text-center mb-3" style="font-size: 18px;">{{ key }}</h3>
                                        <div class="card p-4">
                                            <div v-for="(inputField, i) in formPreview.fields[key]" :key="'form_field_' + i + index">
                                                <div class="form-group">
                                                    <label style="font-size: 17px;" class="mb-0 pb-0">{{inputField.label}} <span v-if="!Object.keys(inputField).includes('is_required')">(Optional)</span></label>
                                                    <p>{{inputField.description}}</p>
                                                    <div v-if="JSON.parse(inputField.field_type) != null && JSON.parse(inputField.field_options) != null" class="col-md-7 p-0 m-0">
                                                        <div v-if="Array.isArray(JSON.parse(inputField.field_options)) && JSON.parse(inputField.field_type).name.toLowerCase() != 'location'">

                                                            <div v-if="JSON.parse(inputField.field_type).type === 'select'">
                                                                <div>
                                                                    <div class="col-md-12 p-0">
                                                                        <select class="form-control custom-select">
                                                                            <option v-for="field in JSON.parse(inputField.field_options).length" :key="'field_prev_no_' + field" :value="JSON.parse(inputField.field_options)[field - 1].value">{{JSON.parse(inputField.field_options)[field - 1].name}}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div v-else>
                                                                <div v-for="field in JSON.parse(inputField.field_options).length" :key="'field_no_' + field">
                                                                    <div class="row mb-2" style="width: 100%">
                                                                        <div class="col-md-9">
                                                                            <div class="custom-control" :class="{'custom-checkbox': JSON.parse(inputField.field_type).type == 'checkbox', 'custom-radio': JSON.parse(inputField.field_type).type == 'radio'}">
                                                                                <input class="custom-control-input" :id="'field_prev_' + index + '_' + '_' + field" :type="JSON.parse(inputField.field_type).type" :value="JSON.parse(inputField.field_options)[field - 1].value" :placeholder="JSON.parse(inputField.field_options)[field - 1].name">
                                                                                <label class="custom-control-label" :for="'field_prev_' + index + '_' + '_' + field"><span style="cursor: pointer;" v-if="JSON.parse(inputField.field_options)[field - 1].label">{{JSON.parse(inputField.field_options)[field - 1].name}}</span></label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div style="width: 100%" v-else>
                                                            <input class="form-control" style="width: 100%" :type="JSON.parse(inputField.field_type).type" :placeholder="inputField.label">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center" style="padding-top: 10px; padding-bottom: 10px;">

                                <button @click="closeSeeWhatYourFormWillLookLike" type="button" class="unicef-btn unicef-primary">
                                    <span>CLOSE</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- See What your Form Look Like Modal End -->

        </form>
    </div>
</div>
</template>

<script>
import Swal from "sweetalert2";
import FormInput from "./FormInput.vue";
import Izitoast from "../mixin/IziToast";
import IconUpload from "./IconUpload.vue";
import MultipleInput from '../common/MultipleInput.vue';
import draggable from "vuedraggable";
export default {
    name: "create-form",
    mixins: [
        Izitoast,
    ],
    props: ['formId'],
    components: {
        FormInput,
        IconUpload,
        MultipleInput,
        draggable
    },
    data() {
        return {
            questionsOrder:[],
            position:0,
            form: null,
            session: null,
            staff: [],
            isProcessing: false,
            step: 1,
            stepper: null,
            isColorSwatchHidden: true,
            selectedFormUsers: [],
            selectedFormOwners: [],
            swatches: [
                {
                    id: 1,
                    color: "#999999"
                },{
                    id: 2,
                    color: "#00aeac"
                },
                {
                    id: 3,
                    color: "#1f419a"
                },
                {
                    id: 4,
                    color: "#a2238e"
                },
                {
                    id: 5,
                    color: "#ec403c"
                },
                {
                    id: 6,
                    color: "#f8a71a"
                },
                {
                    id: 7,
                    color: "#fdf003"
                }
            ],
            formIconImage: null,
            inputs: 1,
            fieldCount: 1,
            selectedColor: "#999999",
            formName: '',
            formDescription: '',
            formPreview: null,
            categories: [],
            fieldCopy: null,
            draftForm: null,
        }
    },
    mounted() {
        let app = this;

        app.getUser();
        app.getStaffUsers();

        if(app.$props.formId != null && app.$props.formId != undefined) {
            app.fieldCount = 0;
            app.inputs = 0;
            app.getFormDetails();
        }

        // setTimeout(function() {
        //     app.form = JSON.parse(app.category);
        //     if(app.form.fields_count > 0) {
        //         app.fieldCount = app.form.fields.length;
        //         app.inputs = app.form.fields.length;
        //         app.form.fields.forEach((field,index)=>{
        //             app.questionsOrder.push(parseInt(field.position));
        //         });
        //         app.position = app.questionsOrder.length > 0 ? Math.max(...app.questionsOrder) : app.position;
        //     }
        //     console.log(app.position);
        // }, 2000);

        $(".select-staff").select2({
            width: '100%',
            theme: "bootstrap",
            placeholder: "Select & Search Staff"
        });

        $('.select2-search__field').css('width', '100%');

        $("#select-staff-form-users").change(function() {
            app.selectedFormUsers = app.staff.filter(x => $(this).val().map(i => parseInt(i)).includes(x.id))
        });

        $("#select-staff-form-owners").change(function() {
            app.selectedFormOwners = app.staff.filter(x => $(this).val().map(i => parseInt(i)).includes(x.id))
        });

        // app.$on('form_copy', (data) => {
        //     app.fieldCopy = data;
        //     app.inputs++;
        //     app.fieldCount++;
        //     setTimeout(() => {
        //         app.fieldCopy = null;
        //     }, 1000);
        // });

        app.$on("icon-file-uploaded", (data) => {
            app.formIconImage = data.file;
        })

        app.$on("icon-file-removed", () => {
            app.formIconImage = null;
        });

        app.$on('form_categories', (data) => {
            let dataCategories = data.length > 0
                                    ? data.filter(x => x != '')
                                    : []
            app.categories = dataCategories;
        });

        // app.$on("delete-field", (field) => {
        //     Swal.fire({
        //         title: "Are you sure?",
        //         html: "<p style='font-size: 14px;'>You won't be able to revert this !</p>",
        //         icon: "warning",
        //         showCancelButton: true,
        //         reverseButtons: true,
        //         confirmButtonColor: "#3085d6",
        //         cancelButtonColor: "#d33",
        //         confirmButtonText: "Yes, Remove it!"
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $("#form_input_" + field).remove();
        //             app.fieldCount--;
        //         } else if (result.isDismissed) {}
        //     })
        // });
    },
    methods: {
        goBack() {
            window.location = "/list-forms";
            // window.history.back();
        },
        getFormDetails() {
            let app = this;
            $.ajax({
                url: '/api/form/details/' + app.$props.formId,
                success: function(response) {
                    app.draftForm = response;
                    app.formName = app.draftForm.form_name;
                    app.formDescription = app.draftForm.form_description;
                    app.selectedColor = app.draftForm.form_color;
                    app.categories = app.draftForm.categories;
                    app.fieldCount = app.draftForm.fields.length;
                    app.inputs = app.draftForm.fields.length;

                    app.selectedFormUsers = app.staff.filter(x => app.draftForm.user_profile_ids.includes(x.id))
                    app.selectedFormOwners = app.staff.filter(x => app.draftForm.owner_profile_ids.includes(x.id))

                    app.draftForm.fields.forEach((field,index) => {
                        app.questionsOrder.push(parseInt(field.position));
                    });
                    // app.questionsOrder.push(parseInt(app.inputs));
                    // console.log("fields: ",app.draftForm.fields);

                    $("#select-staff-form-users").val(app.draftForm.user_profile_ids);
                    $("#select-staff-form-owners").val(app.draftForm.owner_profile_ids);
                }
            });
        },
        getUser() {
            let app = this;
            $.ajax({
                url: '/api/user',
                success: function(response) {
                    app.session = response;
                }
            })
        },
        getStaffUsers() {
            let app = this;
            $.ajax({
                url: '/api/form/list-staff',
                success(response) {
                    app.staff = response;
                    if(app.session != null && app.session != undefined) {
                        var defaultOwner = app.staff.find(x => x.email == app.session.email);
                        if(defaultOwner != null && defaultOwner != undefined) {
                            app.selectedFormOwners.push(defaultOwner);
                        }
                    }

                    if(app.draftForm != null) {
                        app.selectedFormUsers = app.staff.filter(x => app.draftForm.user_profile_ids.includes(x.id))
                        app.selectedFormOwners = app.staff.filter(x => app.draftForm.owner_profile_ids.includes(x.id))

                        $("#select-staff-form-users").val(app.draftForm.user_profile_ids);
                        $("#select-staff-form-owners").val(app.draftForm.owner_profile_ids);
                    }
                }
            })
        },
        seeWhatYourFormWillLook() {

            let app = this;
            let form  = $("#create-form-form");

            if(form.valid()) {

                app.isProcessing = true;
                let formData = new FormData(form[0]);

                $.ajax({
                    type: 'post',
                    url: '/api/form/serialized-form',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        app.isProcessing = false;
                        app.formPreview = JSON.parse(JSON.stringify(response));
                        $("#see-what-your-form-will-look-like").modal({
                            backdrop: 'static',
                            keyboard: false
                        }, "show");
                    },
                    error: function(xhr, t, e) {
                        app.isProcessing = false;
                    }
                });
            }
        },
        showAssignUserModal() {
            let app = this;
            let form = $("#create-form-form");

            if (!form.valid()) {
                app.showErrorMessage('Please, make sure all fields have been completed.');
                return;
            }

            $("#modal-assign-user").modal({
                backdrop: 'static',
                keyboard: false
            }, "show")
        },
        showColorAndViewFormModal() {
            $("#who-else-owns-this-form").modal("hide");
            $("#view-form-select-color").modal({
                backdrop: 'static',
                keyboard: false
            }, "show")
        },
        closeDialog() {
            $("#modal-assign-user").modal("hide");
            $("#who-else-owns-this-form").modal("hide");
            $("#view-form-select-color").modal("hide");
        },
        closeAllModels() {
            $("#modal-assign-user").modal("hide");
            $("#who-else-owns-this-form").modal("hide");
            $("#view-form-select-color").modal("hide");
            $("#see-what-your-form-will-look-like").modal("hide");
        },
        closeSeeWhatYourFormWillLookLike() {
            $("#see-what-your-form-will-look-like").modal("hide");
        },
        onSelectColorsTapped(item) {
            this.selectedColor = item.color;
        },
        proceedToAssignOwners() {
            if (!this.selectedFormUsers.length) {
                this.showErrorMessage('Select at least one form user');
            } else {
                $("#modal-assign-user").modal("hide");
                $("#who-else-owns-this-form").modal({
                    backdrop: 'static',
                    keyboard: false
                }, "show")
            }
        },
        addMoreField() {
            this.inputs++;
            this.fieldCount++;
            this.position++;
            this.questionsOrder.push(this.position);
        },
        copyField(data){
            // Duplicates a field
            let app = this;
            app.fieldCopy = data;
            app.inputs++;
            app.fieldCount++;
            this.position++;
            this.questionsOrder.push(this.position);
            setTimeout(() => {
                app.fieldCopy = null;
            }, 1000);
        },
        deleteFields(inputId,formId) {
            Swal.fire({
                title: "Are you sure?",
                html: "<p style='font-size: 14px;'>You won't be able to revert this !</p>",
                icon: "warning",
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Remove it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteAddedField(inputId,formId);
                } else if (result.isDismissed) {}
            })
        },
        deleteAddedField(inputId,formId) {
            if (formId >= 0) {
                this.inputs--;
                $("#form_input_" + formId).remove();
                console.log("input ",formId);
                this.fieldCount--;
            }
        },
        // deleteAddedField() {
        //     if (this.inputs > 1) {
        //         this.inputs--;
        //         this.fieldCount--;
        //     }
        // },
        processCreateForm() {

            let app = this;
            let form  = $("#create-form-form");

            if(form.valid()) {
                app.isProcessing = true;
                let formData = new FormData(form[0]);

                if(app.draftForm != null) {
                    formData.append('form_id', app.draftForm.id);
                }

                formData.append('form_icon', app.formIconImage);
                formData.append('form_color', app.selectedColor);
                formData.append('form_is_completed', true);

                $.ajax({
                    type: 'post',
                    url: '/api/form/create-form',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        app.isProcessing = false;
                        app.closeAllModels();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            html: "<p style='font-size: 13px'>Form Successfully published</p>",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                            confirmButtonText: 'Ok',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "/list-forms";
                            }
                        })
                    },
                    error: function(xhr, t, e) {
                        app.isProcessing = false;
                    }
                })
            }
        },
        saveAndCompleteLater() {
            let app = this;
            let form  = $("#create-form-form");

            if(app.formName != '' && app.formDescription != '') {
                app.isProcessing = true;
                let formData = new FormData(form[0]);

                if(app.draftForm != null) {
                    formData.append('form_id', app.draftForm.id);
                }

                formData.append('form_color', app.selectedColor);
                formData.append('form_is_completed', false);

                $.ajax({
                    type: 'post',
                    url: '/api/form/create-form',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        app.isProcessing = false;
                        app.closeAllModels();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            html: "<p style='font-size: 13px'>Form Successfully Saved as Draft</p>",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                            confirmButtonText: 'Ok',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "/list-forms";
                            }
                        });
                    },
                    error: function(xhr, t, e) {
                        app.isProcessing = false;
                    }
                })
            } else {
                app.showErrorMessage('Please fill the Form name and description');
            }
        }
    },
}
</script>

<style scoped>
.grabbable {
    cursor: move;
}
.input-border {
    border-bottom: 1px solid #999;
    padding: 3px 0px;
    background-color: transparent;
    resize: none;
    outline: none;
}

.color_row_container {
    display: inline-flex;
    flex-wrap: wrap;
    gap: 8px;
    width: 100%;
    flex-direction: row;
    justify-content: center;
}

.color_row_block {
    cursor: pointer;
    border-radius: 5px;
    height: 50px;
    width: 50px;
}

.color_row_block:hover {
    border: 2px solid grey;
}

.outer-parent {
    border-radius: 4px;
    border: 1px solid #bbccbb;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    /* display: inline-block; */
}

.who-can-use-parent {
    padding: 10px;
    /* border: 1px solid red; */
}

.left-child-who-can-use {
    padding-right: 10px;
}

.inline-block-child {
    display: inline-block;
}

.right-child-who-can-use h6:hover {
    cursor: pointer;
}

.box {
    position: relative;
    display: inline-block;
    border-radius: 2px;
    /* border: 1px solid grey; */
    /* Make the width of box same as image */
}

.text h6 {
    color: rgba(0, 0, 0, 0.8);
}

.box .text {
    position: absolute;
    z-index: 999;
    margin: 0 auto;
    left: 0;
    right: 0;
    text-align: center;
    top: 40%;
    /* Adjust this value to move the positioned div up and down */
    /* color: rgba(0, 0, 0, 0.8); */
    font-family: Arial, sans-serif;
    color: #fff;
    width: 80%;
    /* Set the width of the positioned div */
}

.box .image-rounded-corner {
    border-radius: 5px;
}

.form-file-icon,
.form-file-icon i {
    font-size: 140px;
    color: #999;
}

.box .text.or-text {
    top: 50%;
    margin: 0 auto;
    left: 0;
    right: 0;
    text-align: center;
    width: 20%;
}

.box .text.drag_and_drop {
    top: 20%;
}

.select2-search--inline {
    display: contents;
}

.select2-search__field:placeholder-shown {
    width: 100% !important;
}
</style>
