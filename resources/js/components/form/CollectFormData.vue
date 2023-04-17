<template>
    <div :key="componentKey" class="w-100">
        <div class="position-relative container">
            <button @click.prevent="goBack" type="button" style="position: absolute; left:1.5rem; top:0.5rem;"
                    class="close">
                <i class="fas fa-arrow-left"></i>
            </button>
            <div class="text-right">
                <div class="text-right">
                    <img src="/images/unicef.logo.blue.png" class="text-center" alt="" style="height: 50px;">
                </div>

                <div class="mt-3 text-right">
                    <div class="col-md-12 text-right">
                        <h6 v-if="session != null">You are submitting this entry as <span
                            style="color: blue;">{{ session.name }}</span></h6>
                    </div>
                </div>
            </div>
            <form id="collected-form-data">
                <div v-if="formPreview != null" class="mt-5">
                    <div class="col-md-12 rounded-sm p-5 bg-white">
                        <div class="text-left">
                            <h4 style="font-size: 22px; font-weight: 600;">{{ formPreview.form_name }}</h4>
                        </div>
                        <div class="text-left">
                            <h6 style="font-size: 14px;">{{ formPreview.form_description }}</h6>
                        </div>
                    </div>
                    <div class="my-4">
                        <div v-for="(key, index) in Object.keys(formPreview.grouped_fields)"
                             :key="'form_field_' + index" class="mb-3">
                            <h3 class="text-center mb-3" style="font-size: 18px;">{{ key }}</h3>
                            <div class="rounded-sm p-5 bg-white">
                                <div v-for="(inputField, i) in formPreview.grouped_fields[key]"
                                     :key="'form_field_' + i + index">
                                    <div class="form-group">
                                        <label v-show="showField(inputField.field_input_name)" style="font-size: 17px;" class="mb-0 pb-0">{{ inputField.label }} <span v-if="!Object.keys(inputField).includes('is_required')">(Optional)</span></label>
                                        <p v-show="showField(inputField.field_input_name)">
                                            {{ inputField.description }}</p>

                                        <div
                                            v-if="JSON.parse(inputField.field_type) != null && JSON.parse(inputField.field_options) != null"
                                            class="col-md-7 p-0 m-0">
                                            <div
                                                v-if="Array.isArray(JSON.parse(inputField.field_options)) && JSON.parse(inputField.field_type).name.toLowerCase() != 'location'">

                                                <div v-if="JSON.parse(inputField.field_type).name.toLowerCase() != 'table'">
                                                    <div v-show="showField(inputField.field_input_name)" v-if="JSON.parse(inputField.field_type).type === 'select'">
                                                        <div>
                                                            <div class="col-md-12 p-0">
                                                                <select @change="onSelectChange($event, inputField)" :name="inputField.field_input_name"
                                                                        class="form-control custom-select">
                                                                    <option
                                                                        v-for="field in JSON.parse(inputField.field_options).length"
                                                                        :key="'field_prev_no_' + field"
                                                                        :value="JSON.parse(inputField.field_options)[field - 1].value">
                                                                        {{ JSON.parse(inputField.field_options)[field - 1].name }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div v-else>
                                                        <div v-for="field in JSON.parse(inputField.field_options).length"
                                                            :key="'field_no_' + field">
                                                            <div class="row mb-2" style="width: 100%">
                                                                <div class="col-md-9">
                                                                    <div v-show="showField(inputField.field_input_name)"  @change="onRadioChange($event, inputField)"
                                                                        v-if="JSON.parse(inputField.field_type).type === 'radio'"
                                                                        class="custom-control custom-radio">
                                                                        <input
                                                                            class="custom-control-input"
                                                                            :id="'field_prev_' + i + '_' + field + '_' + index"
                                                                            :name="JSON.parse(inputField.field_type).type == 'checkbox' ? inputField.field_input_name + '[]' : inputField.field_input_name"
                                                                            :type="JSON.parse(inputField.field_type).type"
                                                                            :value="JSON.parse(inputField.field_options)[field - 1].value"
                                                                            :placeholder="JSON.parse(inputField.field_options)[field - 1].name"
                                                                            :required="Object.keys(inputField).includes('is_required')"
                                                                        />
                                                                        <label class="custom-control-label"
                                                                            :for="'field_prev_' + i + '_' + field + '_' + index"><span
                                                                            style="cursor: pointer;"
                                                                            v-if="JSON.parse(inputField.field_options)[field - 1].label">{{ JSON.parse(inputField.field_options)[field - 1].name }}</span></label>
                                                                    </div>
                                                                    <div
                                                                        @change="onCheckBoxChange($event, inputField)"
                                                                        v-show="showField(inputField.field_input_name)" v-if="JSON.parse(inputField.field_type).type === 'checkbox'"
                                                                        class="custom-control custom-checkbox">
                                                                        <input
                                                                            class="custom-control-input"
                                                                            :id="'field_prev_' + i + '_' + field + '_' + index"
                                                                            :name="JSON.parse(inputField.field_type).type == 'checkbox' ? inputField.field_input_name + '[]' : inputField.field_input_name"
                                                                            :type="JSON.parse(inputField.field_type).type"
                                                                            :value="JSON.parse(inputField.field_options)[field - 1].value"
                                                                            :placeholder="JSON.parse(inputField.field_options)[field - 1].name"
                                                                            :required="Object.keys(inputField).includes('is_required') || true"
                                                                        />
                                                                        <label class="custom-control-label"
                                                                            :for="'field_prev_' + i + '_' + field + '_' + index"><span
                                                                            style="cursor: pointer;"
                                                                            v-if="JSON.parse(inputField.field_options)[field - 1].label">{{ JSON.parse(inputField.field_options)[field - 1].name }}</span></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <table-input-collect :inputField="inputField" :index="index + '_' + i" />
                                                </div>
                                            </div>
                                            <div style="width: 100%" v-else>
                                                <div v-show="showField(inputField.field_input_name)" v-if="JSON.parse(inputField.field_type).type == 'location'">
                                                    <map-view :inputId="inputField.field_input_name"
                                                              :required="Object.keys(inputField).includes('is_required')"></map-view>
                                                </div>
                                                <div v-show="showField(inputField.field_input_name)" v-else-if="JSON.parse(inputField.field_type).type == 'file'">
                                                    <file-upload :input-name="inputField.field_input_name"
                                                                 :required="Object.keys(inputField).includes('is_required')"/>
                                                </div>
                                                <input v-else v-show="showField(inputField.field_input_name)"
                                                       :name="inputField.field_input_name"
                                                       :required="Object.keys(inputField).includes('is_required')"
                                                       class="form-control" style="width: 100%"
                                                       :type="JSON.parse(inputField.field_type).type"
                                                       :placeholder="inputField.label">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center" style="padding-top: 10px; padding-bottom: 10px;">
                    <button @click.prevent="submitFormData" :disabled="isProcessing" type="submit"
                            class="unicef-btn unicef-primary">
                        <span><i v-if="isProcessing" class="fa fa-spinner fa-spin"> </i> SUBMIT</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Izitoast from "../mixin/IziToast";
import Swal from "sweetalert2";
import location from "../mixin/location";
import Tooltip from '../common/Tooltip.vue';
import MapView from "../MapView.vue"
import FileUpload from './FileUpload.vue';
import TableInputCollect from './TableInputCollect.vue';

export default {
    name: "collect-form-data",
    props: {
        formid: {
            type: String,
            required: true
        },
        user: {
            type: String,
            required: true
        }
    },
    mixins: [Izitoast, location],
    components: {Tooltip, MapView, FileUpload, TableInputCollect},
    data() {
        return {
            isProcessing: false,
            proceeded: false,
            isLoadingFormData: false,
            session: null,
            formPreview: null,
            availableQnz: [],
            componentKey: 0,
            selectedCheckedAnswers: []
        }
    },
    mounted() {
        let app = this;
        app.session = JSON.parse(app.user);
        app.getFormDetails(app.formid);
    },
    methods: {
        onRadioChange(event, item) {
            let app = this
            let selectedVal = event.target.value;
            console.log("Selected", selectedVal)
            console.log("Selected", item.label)
            for (let i = 0; i < Object.keys(app.formPreview.grouped_fields).length; i++) {
                let objKey = Object.keys(app.formPreview.grouped_fields)[i];
                let questions = app.formPreview.grouped_fields[objKey];
                console.log("Selected", questions)
                for (let j = 0; j < questions.length; j++) {
                    let qn = questions[j]
                    if(qn.field_input_name !== item.field_input_name) {
                        for(let k =0; k < qn.conditions.length; k++) {
                            let condition = qn.conditions[k];
                            console.log("Conditions", condition)
                            if(condition.logic === "selected" && condition.response === selectedVal && condition.field === item.label) {
                                app.updateShowField(qn.field_input_name, true)
                                break;
                            }else if(condition.logic === "selected" && condition.response !== selectedVal && condition.field === item.label) {
                                app.updateShowField(qn.field_input_name, false)
                                break;
                            }
                        }
                    }
                }
            }
        },
        onCheckBoxChange(event, item) {
            let app = this
            let selectedVal = event.target.value;

            console.log("Selected", selectedVal)
            for (let i = 0; i < Object.keys(app.formPreview.grouped_fields).length; i++) {
                let objKey = Object.keys(app.formPreview.grouped_fields)[i];
                let questions = app.formPreview.grouped_fields[objKey];
                console.log("Selected", questions)
                for (let j = 0; j < questions.length; j++) {
                    let qn = questions[j]
                    if(qn.field_input_name !== item.field_input_name) {
                        for(let k =0; k < qn.conditions.length; k++) {
                            let condition = qn.conditions[k];

                            if(condition.logic === "selected" && condition.response === selectedVal && condition.field === item.label) {
                                if(event.target.checked) {
                                    app.updateShowField(qn.field_input_name, true )
                                }else if(!event.target.checked) {
                                    app.updateShowField(qn.field_input_name, false )
                                }
                                break;
                            }
                        }
                    }
                }
            }
        },
        onSelectChange(event, item) {
            let app = this
            let selectedVal = event.target.value;

            console.log("Selected", selectedVal)
            for (let i = 0; i < Object.keys(app.formPreview.grouped_fields).length; i++) {
                let objKey = Object.keys(app.formPreview.grouped_fields)[i];
                let questions = app.formPreview.grouped_fields[objKey];
                console.log("Selected", questions)
                for (let j = 0; j < questions.length; j++) {
                    let qn = questions[j]
                    if(qn.field_input_name !== item.field_input_name) {
                        for(let k =0; k < qn.conditions.length; k++) {
                            let condition = qn.conditions[k];

                            if(condition.logic === "selected" && condition.response === selectedVal && condition.field === item.label) {
                                app.updateShowField(qn.field_input_name, true)
                                break;
                            }else if(condition.logic === "selected" && condition.response !== selectedVal && condition.field === item.label) {
                                app.updateShowField(qn.field_input_name, false)
                                break;
                            }
                        }
                    }
                }
            }
        },
        updateShowField( key, value ) {
            let app = this
            for (let i in app.availableQnz) {
                if (app.availableQnz[i].key === key) {
                    app.availableQnz[i].value = value;
                    break; //Stop this loop, we found it!
                }
            }
        },
        showField(field_input_name) {
            let app = this
            let obj = app.availableQnz.find(o => o.key === field_input_name);
            return obj.value;

        },
        showViewOnInit(response) {
            let app = this
            for (let i = 0; i < Object.keys(response.grouped_fields).length; i++) {
                let objKey = Object.keys(response.grouped_fields)[i];
                let questions = response.grouped_fields[objKey];
                for (let j = 0; j < questions.length; j++) {
                    let qn = questions[j]
                    let con = qn.conditions.filter(function (e) {
                        return e.field != null
                    })
                    let key = qn.field_input_name
                    let val = con.length === 0
                    app.availableQnz.push({"key": key, "value": val})
                }

            }

        },
        submitFormData() {

            let app = this;
            let form = $("#collected-form-data");

            if (form.valid()) {
                app.isProcessing = true;

                let formData = new FormData(form[0]);

                $.ajax({
                    type: 'post',
                    url: '/api/form/serialized-data',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $.ajax({
                            url: "/api/form/save-form-data",
                            type: "post",
                            data: {
                                form_id: app.formPreview.id,
                                data: JSON.stringify(response)
                            },
                            success(data) {
                                app.isProcessing = false;
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    html: "<p style='font-size: 13px'>Data Successfully Submitted</p>",
                                    showConfirmButton: true,
                                    allowOutsideClick: false,
                                    showCloseButton: true,
                                    confirmButtonText: 'Ok',
                                    confirmButtonColor: '#32CD32',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "/list-forms";
                                    }
                                })
                            },
                            error(xhr, t, e) {
                                app.isProcessing = false;
                                app.showErrorMessage(e);
                            }
                        })
                    },
                    error: function (xhr, t, e) {
                        app.isProcessing = false;
                    }
                })
            }
        },
        goBack() {
            window.history.back();
        },
        getFormDetails(id) {
            let app = this;
            app.isLoadingFormData = true;
            $.ajax({
                url: "/api/form/details/" + id,
                success: function (response) {

                    app.showViewOnInit(response);
                    setTimeout(function () {
                        app.formPreview = response;
                        console.log("formPreview: "+JSON.stringify(app.formPreview));
                        app.isLoadingFormData = false;
                        app.componentKey++;
                    }, 200)

                }
            });
        },
    },
}
</script>

<style scoped>
select {
    display: block;
    /* padding: px 6px; */
    width: 50%;
    box-sizing: border-box;
    border: none;
    border: 1px solid #ddd;
    color: #555;
}

.mainFormContent {
    border: 1px solid #fff;
    width: 100%;
    height: 100%;
    background-color: #fff;
}

.mainFieldContent {
    border: 1px solid #fff;
    width: 100%;
    height: 100%;
    background-color: #fff;
}
</style>
