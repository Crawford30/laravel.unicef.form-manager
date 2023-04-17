<template>
<div>
    <div class="create-form mb-4">
        <div class="mt-4 col-md-12">
            <div class="row">
                <div class="col-md-8 m-0 p-0 rounded-sm  box  create-forms-div form-background">
                    <div class="inner-left-div">
                        <div class="col-md-12 p-5">
                            <div class="form-group">
                                <label :for="'form_input_label_' + inputId">Field Label</label>
                                <input v-model="fieldName" @keyup="updateFieldName" :data-input-id="inputId" type="text" placeholder="Label" :id="'form_input_label_' + inputId" class="form-control field-label-input-value" :name="'fields['+inputId+'][label]'" required>
                            </div>
                            <div class="form-group">
                                <label :for="'form_input_desc_' + inputId">Field Description</label>
                                <input v-model="fieldDescription" type="text" placeholder="Description" class="form-control" :id="'form_input_desc_' + inputId" :name="'fields['+inputId+'][description]'">
                            </div>

                            <div class="form-group">
                                <input v-model="fieldPosition" type="hidden" placeholder="Position" class="form-control" :id="'form_input_desc_' + inputId" :name="'fields['+inputId+'][position]'">
                            </div>

                            <div class="col-md-7 m-0 p-0">
                                <div class="form-group">
                                    <label>Field Type</label><br>
                                    <div>
                                        <div style="width: 100% !important" class="dropdown" v-if="useDropDown">
                                            <button style="color: #333; width: 100% !important; text-align:left !important;" class="btn btn-secondary dropdown-toggle bg-white btn-select-field-type" type="button" :id="'show-fields-type-' + inputId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span v-if="selectedType != null">{{selectedType.name}}</span>
                                                <span v-else>Select</span>
                                            </button>
                                            <div class="dropdown-menu" style="min-width: 100% !important;" :aria-labelledby="'show-fields-type-' + inputId">
                                                <div v-for="(group, x) in groupedItems" v-bind:key="'group_fields_' + x">
                                                    <a style="cursor: pointer;" v-for="(item, i) in group.items" v-bind:key="'group_fields_item_' + x + '_' + i" class="dropdown-item py-2" @click="onSelectFieldType(item)">
                                                        <span style="margin-right: 12px;">
                                                            <img :src="item.iconUrl" style="height: 16px !important">
                                                        </span>
                                                        {{ item.text }}
                                                    </a>
                                                    <div v-if="x != groupedItems.length - 1" class="dropdown-divider"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="width: 100%;" class="custom-select" v-else>
                                            <v-super-select iconClassField="super-select-icon" placeholder="Select" :items="groupedItems" :showValue="false" inputWidth="100%" inputHeight="100%" @change="onSelectFieldType">
                                            </v-super-select>
                                        </div>
                                    </div>
                                    <input type="hidden" :id="'field_input_type_' + inputId" :name="'fields['+inputId+'][field_type]'" :value="JSON.stringify(selectedType)" required>
                                    <input type="hidden" :id="'field_input_options_' + inputId" :name="'fields['+inputId+'][field_options]'" :value="JSON.stringify(inputs)" required>
                                    <input type="hidden" :name="'fields['+inputId+'][field_input_name]'" :value="fieldInputName" required>
                                </div>
                            </div>
                             <div class="col-md-7 m-0 p-0">
                                <div class="form-group">
                                    <label>Category</label><br>
                                    <select v-model="fieldCategory" :name="'fields['+inputId+'][category]'" class="form-control custom-select" :id="'form_input_category_' + inputId">
                                        <option value="" selected disabled>Select Category</option>
                                        <option v-for="(c, x) in categories" :key="'form_category_' + inputId + '_' + x" :selected="categories.includes(fieldCategory)" :value="c">{{c}}</option>
                                    </select>
                                </div>
                             </div>

                            <div v-if="selectedType != null && inputs != null" class="col-md-7 p-0 m-0" :class="{'col-md-12': selectedType.name.toLowerCase() == 'table'}">
                                <div v-if="Array.isArray(inputs) && selectedType.name.toLowerCase() != 'location'">
                                    <div v-if="selectedType.name.toLowerCase() != 'table'">
                                        <draggable :list="selectedType.default_inputs" :disabled="!selectedType.orderble" @start="dragging = selectedType.orderble" @end="dragging = !selectedType.orderble">
                                            <div v-for="field in inputsCount" :key="'field_no_' + field" @mouseover="selectIndex(field);" @mouseout="optionIndex = null;">
                                                <div class="row mb-2" v-if="selectedType.type === 'select'" style="width: 100%">
                                                    <div class="col-md-9">
                                                        <label disabled="disabled" class="input-none mb-0 pb-0" :type="selectedType.type" :value="inputs[field - 1].value" :placeholder="inputs[field - 1].name">{{inputs[field - 1].value}}</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="text-right">
                                                            <span style="cursor:move;" v-show="optionIndex == field && selectedType.orderble">
                                                                <i title="Drag and move to reorder" class="fas fa-grip-vertical" style="font-size: 15px; color: #999;"></i>
                                                            </span>
                                                            <span class="ml-2" v-if="selectedType.is_dynamic" style="cursor: pointer;" @click="onDeleteOption(field)">
                                                                <i class="fas fa-times" style="font-size: 15px; color: #999;"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else-if="selectedType.type === 'text' || selectedType.type === 'number'" class="row mb-2" style="width: 100%">
                                                    <div class="col-md-7">
                                                        <input class="input-border" style="width: 100% !important;" type="text" :placeholder="inputs[field - 1].name" disabled>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="text-left pt-2">
                                                            <span class="ml-2" style="cursor: pointer;" @click="onDeleteOption(field)">
                                                                <i class="fas fa-times" style="font-size: 15px; color: #999;"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else class="row mb-2" style="width: 100%">
                                                    <div class="col-md-9">
                                                        <div class="custom-control" :class="{'custom-checkbox': selectedType.type == 'checkbox', 'custom-radio': selectedType.type == 'radio'}">
                                                            <input class="custom-control-input" :id="'field_' + inputId + '_' + '_' + field" :type="selectedType.type" :value="inputs[field - 1].value" :placeholder="inputs[field - 1].name">
                                                            <label class="custom-control-label" :for="'field_' + inputId + '_' + '_' + field"><span style="cursor: pointer;" v-if="inputs[field - 1].label">{{inputs[field - 1].name}}</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="text-right">
                                                            <span style="cursor:move;" v-show="optionIndex == field && selectedType.orderble">
                                                                <i title="Drag and move to reorder" class="fas fa-grip-vertical" style="font-size: 15px; color: #999;"></i>
                                                            </span>
                                                            <span class="ml-2" v-if="selectedType.is_dynamic" style="cursor: pointer;" @click="onDeleteOption(field);">
                                                                <i class="fas fa-times" style="font-size: 15px; color: #999;"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </draggable>

                                        <div style="width: 100%" v-if="selectedType.is_dynamic">
                                            <input class="input-border" style="width: 100%" @keydown.enter.prevent="onAddOption" type="text" :placeholder="isMultiple ? 'Add Field' : 'Add Option'">
                                        </div>
                                    </div>
                                    <div v-else>
                                        <p>Add table's columns</p>
                                        <div v-for="field in inputsCount" :key="'table-row-' + inputId + '-' + field" :id="'table-row-' + inputId + '-' + field" class="form-row mb-2">
                                            <div class="col-md-3">
                                                <input type="hidden" :id="'table-row-input-' + inputId + '-' + field" :name="'fields['+inputId+'][rows]['+field+'][type]'">
                                                <div style="width: 100% !important" class="dropdown">
                                                    <button style="color: #333; width: 100% !important; text-align:left !important;" class="btn btn-secondary dropdown-toggle bg-white btn-select-field-type cp-btn-input" type="button" :id="'show-fields-type-' + inputId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span v-if="inputs != null && inputs[field - 1]">{{inputs[field - 1].name.split(' ')[0]}}</span>
                                                        <span v-else>Select</span>
                                                    </button>
                                                    <div class="dropdown-menu" style="min-width: 100% !important;" :aria-labelledby="'show-fields-type-' + inputId">
                                                        <a style="cursor: pointer;" v-for="(item, i) in formTypes.filter(v => tableRowFilters.includes(v.type))" v-bind:key="'table_field_item_' + inputId + '_' + i" class="dropdown-item py-2" @click.prevent="onSelectTableRowType(item, field)">
                                                            <span style="margin-right: 12px;">
                                                                <img :src="item.iconUrl" style="height: 16px !important">
                                                            </span>
                                                            {{ item.name }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <input v-if="inputs != null && inputs[field - 1]" :value="inputs[field - 1].text" type="text" :name="'fields['+inputId+'][rows]['+field+'][name]'" class="form-control" placeholder="Field name" @keyup="onUpdateRowTitle($event, field)">
                                                <input v-else type="text" :name="'fields['+inputId+'][rows]['+field+'][name]'" class="form-control" placeholder="Field name" @keyup="onUpdateRowTitle($event, field)">
                                            </div>
                                            <div v-if="inputs[field - 1] && inputs[field - 1].name == 'Dropdown'" class="col-md-4">
                                                <input v-if="inputs != null && inputs[field - 1]" :value="inputs[field - 1].values" type="text" :name="'fields['+inputId+'][rows]['+field+'][values]'" class="form-control" placeholder="Field values (separated with commas)" @keyup="onUpdateRowValues($event, field)">
                                                <input v-else type="text" :name="'fields['+inputId+'][rows]['+field+'][values]'" class="form-control" placeholder="Field values (separated with commas)" @keyup="onUpdateRowValues($event, field)">
                                            </div>
                                            <div class="col-md-1 pt-2">
                                                <span @click="onDeleteRow(field)" class="fa fa-trash-alt" style="font-size: 18px; cursor: pointer; color: #999;"></span>
                                            </div>
                                        </div>
                                        <div>
                                            <button @click.prevent="addMoreRow()" type="button" class="btn btn-success add-more-btn py-2 m-0">
                                                <span class="fa fa-plus"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div style="width: 100%" v-else>
                                    <input @keydown.enter.prevent class="input-border" style="width: 100%" :type="selectedType.type" :placeholder="selectedType.placeholder" :value="inputs.value"> <span v-if="inputs.label">{{inputs.name}}</span>
                                </div>
                            </div>
                            <hr />
                            <div class="col-md-12 p-0 m-0">
                                <div class="row p-0 m-0">
                                    <div class="col-lg-6 p-0 m-0">
                                        <div v-if="showRequired" class="custom-control custom-checkbox mt-2" style="z-index: 0 !important;">
                                            <input :name="'fields['+inputId+'][is_required]'" type="checkbox" class="custom-control-input" :id="'input-is-required' + inputId" :checked="isRequired">
                                            <label class="custom-control-label" :for="'input-is-required' + inputId">Required</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 p-0 m-0">
                                        <div class="float-right">
                                            <button :id="'field_display_if_' + inputId" class="btn btn-success add-more-btn py-2" @click.stop.prevent="openConditionsModal">
                                                <span v-if="showRequired" class="fas fa-cog"></span>
                                                <span v-else style="color: green;" class="fas fa-cog"></span>
                                            </button>
                                            <button class="btn btn-success add-more-btn py-2" @click.stop.prevent="onClickFormCopy">
                                                <span class="far fa-clone" style="transform: rotate(90deg);"></span>
                                            </button>
                                            <button @click="deleteField" type="button" class="btn btn-success add-more-btn py-2">
                                                <span class="fa fa-trash"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 box">
                    <div class="inner-right-div rounded-sm ml-2">
                        <div class="py-3">
                            <div class="row">
                                <div class="col-md-12" style="padding-bottom: 10px;">
                                    <h6 style="text-align: center;">
                                        Proposed Dashboard Visual
                                    </h6>
                                    <div class="img-view">
                                        <div v-if="selectedType != null && inputs != null">
                                            <div v-if="selectedType.is_dynamic">
                                                <div v-if="inputsCount <= 4">
                                                    <img style="height: 200px; width:200px;" :src="selectedType.proposed_dashbord_visual" />
                                                </div>
                                                <div v-else>
                                                    <img style="height: 200px; width:200px;" :src="selectedType.proposed_dashbord_visual_bar" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" :id="'modal-display-if-' + inputId">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal body -->
                <div class="modal-body py-4">
                    <h5 style="text-align: center; font-weight: bold; font-size: 15px;">
                        <span style="color: #333">Display the Question</span>
                    </h5>
                    <h5 style="text-align: center; font-weight: bold; font-size: 15px;">
                        <span style="color: #999">{{fieldName}}</span>
                    </h5>
                    <h5 style="text-align: center; font-weight: bold; font-size: 15px;">
                        <span style="color: #333">only if the following condition(s) is/are met</span>
                    </h5>
                    <br>
                    <div class="col-12" :id="'condition_question_container_' + inputId">
                        <div v-for="(item, key) in questionConditionCount" :key="key" :id="'condition_question_' + inputId + '_' + key" class="form-row mb-2">
                            <div class="col-md-6">
                                <select v-if="previousQuestions.length > 0"  @change="selectQuestionCondition" :data-key="key" class="form-control custom-select condition-question-field" :name="'fields['+inputId+'][conditions]['+key+'][field]'">
                                    <option value="" selected disabled>Select Question</option>
                                    <option v-for="(question, x) in previousQuestions" :selected="conditions[key] != null && conditions[key] != undefined && question.label == conditions[key].field" :data-key="question.key" :value="question.label" :key="'question_for_' + x + key + inputId">{{question.label}}</option>
                                </select>
                                <select v-if="previousQuestions.length == 0 && conditions[key] != null && conditions[key] != undefined" :data-key="key" class="form-control custom-select condition-question-field" :name="'fields['+inputId+'][conditions]['+key+'][field]'">
                                    <option value="" disabled>Select Question</option>
                                    <option :data-key="key" :value="conditions[key].field" :key="'question_for_' + x + key + inputId" selected>{{conditions[key].field}}</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select :id="'field_conditions_' + inputId + '_' + key" class="form-control custom-select" :name="'fields['+inputId+'][conditions]['+key+'][response]'">
                                    <option value="" selected disabled>Select Response</option>
                                    <option v-if="conditions[key] != null && conditions[key] != undefined" :value="conditions[key].response" selected>{{conditions[key].response}}</option>
                                </select>
                            </div>

                            <div class="col-md-3 form-row">
                                <div class="col-md-10">
                                    <select class="form-control custom-select" :name="'fields['+inputId+'][conditions]['+key+'][logic]'">
                                        <option :selected="conditions[key] != null && conditions[key] != undefined && conditions[key].logic == 'selected'" value="selected">Is Selected</option>
                                        <option :selected="conditions[key] != null && conditions[key] != undefined && conditions[key].logic == 'not_selected'" value="not_selected">Is Not Selected</option>
                                    </select>
                                </div>

                                <span v-if="key != 0" @click="removeInput(key)" class="col-md-2 pt-2" style="cursor: pointer;">
                                    <i class="far fa-trash-alt" style="font-size: 20px; color: #999;"></i>
                                </span>
                            </div>
                        </div>
                        <button @click="addMore"  type="button" class="btn btn-success text-white add-more-btn addMore">
                            <span class="fa fa-plus text-blue"></span>
                        </button>
                    </div>
                    <div class="col-12 text-center mt-3">
                        <button type="button" @click="saveConditions" data-dismiss="modal" class="unicef-btn unicef-primary">
                            SAVE
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import draggable from 'vuedraggable';
import Izitoast from "../mixin/IziToast";
import VSuperSelect from "v-super-select";

export default {
    name: "FormInput",
    components: {VSuperSelect, draggable},
    mixins: [Izitoast],
    props: {
        inputId: {
            type: Number,
            required: true
        },
        defaultType: {
            type: Object,
            required: false
        },
        formCategories: {
            type: Array,
            required: false,
            default: []
        },
        initialInput: {
            type: Object,
            required: false
        },
        position:{
            type: Number,
            required: false
        }
    },
    data() {
        return {
            dragging: false,
            groupedItems: [
                {
                    groupName: "A",
                    items: [
                        {
                            type: 'radio',
                            text: 'Yes/No',
                            value: 'YES/NO',
                            icon: 'far fa-dot-circle',
                            is_dynamic: true,
                            orderble: false,
                            return_type: 'string', //int
                            proposed_dashbord_visual: '/images/icon_pie_chart.png',
                            iconUrl: "/images/icons/iconradiobutton.png",
                            placeholder: 'Yes/No',
                            default_inputs: [
                                {
                                    label: true,
                                    name: 'Yes',
                                    choice:'choice',
                                    value: 'Yes', //1
                                },
                                {
                                    label: true,
                                    name: 'No',
                                    choice:'choice',
                                    value: 'No' //0
                                }
                            ]
                        },
                        {
                            type: 'radio',
                            text: 'Male/Female',
                            value: 'MALE/FEMALE',
                            icon: 'far fa-dot-circle',
                            is_dynamic: true,
                            orderble: false,
                            return_type: 'string', //int
                            proposed_dashbord_visual: '/images/icon_pie_chart.png',
                            iconUrl: "/images/icons/iconradiobutton.png",
                            placeholder: 'Gender',
                            default_inputs: [
                                {
                                    label: true,
                                    name: 'Male',
                                    choice:'gender',
                                    value: 'Male' //M
                                },
                                {
                                    label: true,
                                    name: 'Female',
                                    choice:'gender',
                                    value: 'Female' //F
                                }
                            ]
                        },
                        {
                            type: 'radio',
                            text: 'Multiple Choice',
                            value: 'MULTIPLE CHOICE',
                            icon: 'far fa-dot-circle',
                            is_dynamic: true,
                            orderble: true,
                            return_type: 'string',
                            proposed_dashbord_visual: '/images/icon_bar_graph.png',
                            iconUrl: "/images/icons/iconradiobutton.png",
                            placeholder: 'Check only one',
                            default_inputs: [],
                        },
                    ],
                },
                {
                    groupName: "B",
                    items: [
                        {
                            type: 'checkbox',
                            text: 'Checkboxes',
                            value: 'CHECKBOXES',
                            icon: 'fas fa-check-square',
                            is_dynamic: true,
                            orderble: true,
                            return_type: 'array',
                            proposed_dashbord_visual: '/images/icon_bar_graph.png',
                            iconUrl: "/images/icons/iconcheckbox.png",
                            placeholder: 'Check onne or many',
                            default_inputs: [],
                        },
                        {
                            type: 'select',
                            text: 'Dropdown',
                            value: 'DROPDOWN',
                            icon: 'fas fa-chevron-circle-down',
                            is_dynamic: true,
                            orderble: true,
                            return_type: 'array',
                            proposed_dashbord_visual: '/images/icon_bar_graph.png',
                            iconUrl: "/images/icons/icondropdown.png",
                            default_inputs: [],
                        },
                    ],
                },
                {
                    groupName: "C",
                    items: [
                        {
                            type: 'number',
                            text: 'Numeric Responses',
                            value: 'NUMERIC RESPONSES',
                            icon: 'fas fa-sort-numeric-up',
                            iconUrl: "/images/icons/iconnumeric.png",
                            is_dynamic: false,
                            orderble: false,
                            return_type: 'int',
                            placeholder: '123445680',
                            default_inputs: {
                                label: false,
                                name: '',
                                value: '',
                                type: 'text'
                            }
                        },
                        {
                            type: 'text',
                            text: 'Alphanumeric Responses',
                            value: 'ALPHANUMERIC RESPONSES',
                            iconUrl: "/images/icons/iconalphanumeric.png",
                            icon: 'fas fa-text-width',
                            is_dynamic: false,
                            orderble: false,
                            return_type: 'string',
                            placeholder: 'Text 1234',
                            default_inputs: {
                                label: false,
                                name: '',
                                value: '',
                                type: 'number'
                            }
                        },
                    ],
                },
                {
                    groupName: "D",
                    items: [
                        {
                            type: 'table',
                            text: 'Table',
                            name: 'Table',
                            value: 'LIST RESPONSES',
                            icon: 'fas fa-th',
                            iconUrl: "/images/icons/icons.tables.png",
                            is_dynamic: false,
                            orderble: false,
                            return_type: 'array',
                            placeholder: '',
                            default_inputs: []
                        }
                    ],
                },
                {
                    groupName: "E",
                    items: [
                        {
                            type: 'date',
                            text: 'Date',
                            value: 'DATE',
                            icon: 'fas fa-sort-numeric-up',
                            iconUrl: "/images/icons/icondate.png",
                            is_dynamic: false,
                            orderble: false,
                            return_type: 'string',
                            placeholder: 'YYY-MM-DD',
                            default_inputs: {
                                label: false,
                                name: '',
                                value: '',
                                type: 'string'
                            }
                        },
                        {
                            type: 'time',
                            text: 'Time',
                            value: 'TIME',
                            iconUrl: "/images/icons/icontime.png",
                            icon: 'fas fa-text-width',
                            is_dynamic: false,
                            orderble: false,
                            return_type: 'string',
                            placeholder: 'HH:MM',
                            default_inputs: {
                                label: false,
                                name: '',
                                value: '',
                                type: 'string'
                            }
                        },
                    ],
                },
                {
                    groupName: "F",
                    items: [
                        {
                            type: 'location',
                            iconUrl: "/images/icons/iconlocation.png",
                            text: 'Location',
                            value: 'LOCATION',
                            icon: 'fas fa-map-marker-alt',
                            is_dynamic: false,
                            orderble: false,
                            return_type: 'object',
                            placeholder: 'Location / Address',
                            default_inputs: [
                                {
                                    label: true,
                                    name: 'Location / Address',
                                    value: '',
                                    type: 'text'
                                },
                                {
                                    label: false,
                                    name: 'Latitude',
                                    value: '',
                                    type: 'hidden'
                                },
                                {
                                    label: false,
                                    name: 'Longitude',
                                    value: '',
                                    type: 'hidden'
                                }
                            ]
                        },
                    ],
                },
                {
                    groupName: "G",
                    items: [
                        {
                            type: 'file',
                            iconUrl: "/images/icons/icon.images.png",
                            text: 'Picture',
                            value: 'IMAGE',
                            icon: 'fas fa-image',
                            is_dynamic: false,
                            orderble: false,
                            return_type: 'file',
                            placeholder: 'Upload Image',
                            default_inputs: {
                                label: false,
                                name: '',
                                value: '',
                                type: 'file'
                            }
                        }
                    ],
                },
            ],
            formTypes: [
                {
                    type: 'radio',
                    name: 'Yes/No',
                    icon: 'far fa-dot-circle',
                    is_dynamic: true,
                    orderble: false,
                    return_type: 'string', //int
                    proposed_dashbord_visual: '/images/icon_pie_chart.png',
                    proposed_dashbord_visual_bar: '/images/icon_bar_graph.png',
                    placeholder: 'Yes/No',
                    default_inputs: [
                        {
                            label: true,
                            name: 'Yes',
                            choice:'choice',
                            value: 'Yes', //1
                        },
                        {
                            label: true,
                            name: 'No',
                            choice:'choice',
                            value: 'No' //0
                        }
                    ]
                },
                {
                    type: 'radio',
                    name: 'Male/Female',
                    icon: 'far fa-dot-circle',
                    is_dynamic: true,
                    orderble: false,
                    return_type: 'string',
                    proposed_dashbord_visual: '/images/icon_pie_chart.png',
                    proposed_dashbord_visual_bar: '/images/icon_bar_graph.png',
                    placeholder: 'Gender',
                    default_inputs: [{
                            label: true,
                            name: 'Male',
                            choice:'gender',
                            value: 'Male' //M
                        },
                        {
                            label: true,
                            name: 'Female',
                            choice:'gender',
                            value: 'Female' //F
                        }
                    ]
                },
                {
                    type: 'radio',
                    name: 'Multiple Choice',
                    icon: 'far fa-dot-circle',
                    is_dynamic: true,
                    orderble: true,
                    return_type: 'string',
                    proposed_dashbord_visual: '/images/icon_bar_graph.png',
                    proposed_dashbord_visual_bar: '/images/icon_bar_graph.png',
                    placeholder: 'Check only one',
                    default_inputs: [],
                },
                {
                    type: 'checkbox',
                    name: 'Checkboxes',
                    icon: 'fas fa-check-square',
                    is_dynamic: true,
                    orderble: true,
                    proposed_dashbord_visual: '/images/icon_bar_graph.png',
                    proposed_dashbord_visual_bar: '/images/icon_bar_graph.png',
                    return_type: 'array',
                    placeholder: 'Check one or many',
                    default_inputs: []
                },
                {
                    type: 'select',
                    name: 'Dropdown',
                    icon: 'fas fa-chevron-circle-down',
                    is_dynamic: true,
                    orderble: true,
                    proposed_dashbord_visual: '/images/icon_bar_graph.png',
                    proposed_dashbord_visual_bar: '/images/icon_bar_graph.png',
                    return_type: 'string',
                    placeholder: 'Select only one',
                    iconUrl: "/images/icons/icondropdown.png",
                    default_inputs: []
                },
                {
                    type: 'number',
                    name: 'Numeric Responses',
                    icon: 'fas fa-sort-numeric-up',
                    iconUrl: "/images/icons/iconnumeric.png",
                    is_dynamic: false,
                    orderble: false,
                    return_type: 'int',
                    placeholder: '123445560',
                    default_inputs: {
                        label: false,
                        name: '',
                        value: '',
                        type: 'number'
                    }
                },
                {
                    type: 'text',
                    name: 'Alphanumeric Responses',
                    icon: 'fas fa-text-width',
                    iconUrl: "/images/icons/iconalphanumeric.png",
                    is_dynamic: false,
                    orderble: false,
                    return_type: 'string',
                    placeholder: 'Text @ 1234 #',
                    default_inputs: {
                        label: false,
                        name: '',
                        value: '',
                        type: 'text'
                    }
                },
                {
                    type: 'table',
                    text: 'Table',
                    name: 'Table',
                    value: 'LIST RESPONSES',
                    icon: 'fas fa-th',
                    iconUrl: "/images/icons/icons.tables.png",
                    is_dynamic: false,
                    orderble: false,
                    return_type: 'array',
                    placeholder: '',
                    default_inputs: []
                },
                {
                    type: 'date',
                    name: 'Date',
                    icon: 'fas fa-sort-numeric-up',
                    is_dynamic: false,
                    orderble: false,
                    iconUrl: "/images/icons/icondate.png",
                    return_type: 'string',
                    placeholder: 'YYYY-MM-DD',
                    default_inputs: {
                        label: false,
                        name: 'DD MMM YY',
                        value: '',
                        type: 'date'
                    }
                },
                {
                    type: 'time',
                    name: 'Time',
                    icon: 'fas fa-text-width',
                    is_dynamic: false,
                    orderble: false,
                    iconUrl: "/images/icons/icontime.png",
                    return_type: 'string',
                    placeholder: 'HH:MM',
                    default_inputs: {
                        label: false,
                        name: 'Time',
                        value: '',
                        type: 'string'
                    }
                },
                {
                    type: 'location',
                    name: 'Location',
                    icon: 'fas fa-map-marker-alt',
                    is_dynamic: false,
                    orderble: false,
                    return_type: 'string',
                    placeholder: 'Location/Address',
                    default_inputs: {
                        label: false,
                        name: 'Location',
                        value: '',
                        type: 'string'
                    },
                },
                {
                    type: 'file',
                    name: 'Picture',
                    icon: 'fas fa-image',
                    is_dynamic: false,
                    orderble: false,
                    return_type: 'file',
                    placeholder: 'Upload Image',
                    default_inputs: {
                        label: false,
                        name: 'Picture',
                        value: '',
                        type: 'file'
                    }
                }
            ],
            optionIndex: null,
            inputsCount: 0,
            inputs: null,
            selectedType: null,
            useDropDown: true,
            categories: [],
            fieldName: '',
            fieldDescription: '',
            fieldPosition:null,
            fieldCategory: '',
            previousQuestions: [],
            questionConditionCount: 1,
            fieldInputName: '',
            conditions: [],
            isRequired: false,
            showRequired: true,
            tableRowFilters: ['number', 'text', 'date', 'time', 'select']
        }
    },
    mounted() {
        let app = this;

        app.fieldPosition = app.position; //set position number for every question that's created

        if(app.initialInput != null && app.initialInput != undefined) {
            app.selectedType = JSON.parse(app.initialInput.field_type);
            app.inputs = JSON.parse(app.initialInput.field_options);
            app.fieldName = app.initialInput.label;
            app.fieldPosition = app.initialInput.position;
            app.fieldDescription = app.initialInput.description;
            app.fieldCategory = app.initialInput.category;
            app.isRequired = Object.keys(app.initialInput).includes('is_required');
            if(Array.isArray(app.inputs)) {
                app.inputsCount = app.inputs.length;
            }
            app.conditions = app.initialInput.conditions.filter(x => Object.keys(x).includes('field'));
            app.questionConditionCount = app.conditions.length > 0 ? app.conditions.length : 1;
            app.showRequired = app.conditions.length == 0;
            app.onUpdateInputName();
        }

        if(app.defaultType != null && app.defaultType != undefined && app.selectedType == null) {
            app.selectedType = app.defaultType.type;
            app.inputs = app.defaultType.inputs;
            app.fieldName = app.defaultType.name;
            app.fieldPosition = app.defaultType.position;
            app.fieldDescription = app.defaultType.description;
            app.fieldCategory = app.defaultType.category;
            if(Array.isArray(app.defaultType.inputs)) {
                app.inputsCount = app.defaultType.inputs.length;
            }
            app.onUpdateInputName();
        }

        if(app.formCategories != null && app.formCategories != undefined) {
            app.categories = app.formCategories;
        }

        $('#field_display_if_' + app.inputId).popover({
            html: true,
            title:'',
            trigger: 'hover',
            placement: 'top',
            content: function(){return "<p><i class='far fa-play-circle'></i> Display if</p>";}
        });

        $("#form_input_category_" + app.inputId).change(function() {
            app.onUpdateInputName();
        });
    },
    methods: {
        onSelectFieldType(e) {
            let app = this;
            var val = null;
            if (e.target != null) {
                val = $(e.target).val();
            } else {
                val = e.type + '_' + e.text;
            }
            if (val != null && val != '' && val != undefined) {
                let t = val.split('_')[0]
                let n = val.split('_')[1]
                let type = app.formTypes.find(x => x.type == t && x.name == n);
                if (type != null) {
                    app.selectedType = type;
                    app.inputsCount = app.selectedType.name == 'Table' ? 1 : Array.isArray(app.selectedType.default_inputs) ? app.selectedType.default_inputs.length : 0;
                    app.inputs = app.selectedType.name == 'Table' ? [] : app.selectedType.default_inputs;
                }
            }
        },
        onSelectTableRowType(item, index) {
            let app = this;
            $('#table-row-input-' + app.inputId + '-' + index).val(item.type);
            let value = app.inputs[index - 1];
            app.inputs.splice(index - 1, 1, {
                'type': item.type,
                'name': item.name,
                'text': value != null && value != undefined ? value.text : ''
            })
        },
        onUpdateRowTitle(e, index) {
            let app = this;
            let value = $(e.target).val();
            let input = app.inputs[index - 1];
            app.inputs[index - 1] = {
                'type': input.type,
                'name': input.name,
                'text': value
            }
        },
        onUpdateRowValues(e, index) {
            let app = this;
            let value = $(e.target).val();
            let input = app.inputs[index - 1];
            app.inputs[index - 1] = {
                'type': input.type,
                'name': input.name,
                'text': input.text,
                'values': value
            }
        },
        onAddOption(e) {
            let app = this;
            var val = null;
            if (e.target != null) {
                val = $(e.target).val();
            } else {
                val = e.type + '_' + e.text;
            }

            if (e.code === "Enter") {
                if (val != '') {
                    if(['other', 'Other', 'others', 'Others'].includes(val)) {
                        let otherInput = app.inputs.find(i => i.name.toLowerCase() == 'Others'.toLowerCase() || i.name == 'Other'.toLowerCase())
                        if(otherInput == null || otherInput == undefined) {
                            app.inputs.push({
                                label: ['radio', 'checkbox', 'select'].includes(app.selectedType.type),
                                name: 'Others',
                                value: 'Others',
                            });
                            app.inputsCount++;
                        }
                    } else {
                        app.inputs.push({
                            label: ['radio', 'checkbox', 'select'].includes(app.selectedType.type),
                            name: val,
                            value: val,
                        });
                        app.inputsCount++;
                    }

                    let otherInput = app.inputs.find(i => i.name.toLowerCase() == 'Others'.toLowerCase() || i.name == 'Other'.toLowerCase())

                    if(otherInput != null && otherInput != undefined) {
                        app.inputs.push(app.inputs.splice(app.inputs.indexOf(otherInput), 1)[0])
                    }

                    $(e.target).val('');
                }
            }
        },
        onDeleteOption(field) {
            let app = this;
            app.inputsCount--;
            app.inputs = app.inputs.filter((v, x) => x != field - 1);
        },
        addMoreRow() {
            this.inputsCount++;
        },
        onDeleteRow(index) {
            this.inputsCount--;
            this.inputs.splice(index - 1, 1);
            $('#table-row-' + this.inputId + '-' + index).remove();
            if(this.inputsCount == 0) {
                this.inputsCount = 1;
            }
        },
        onClickFormCopy() {
            let app = this;
            if(app.selectedType != null && $("#form_input_label_" + app.inputId + "").val() != "") {
                var formInput = {
                    key: app.inputId,
                    name: $("#form_input_label_" + app.inputId).val(),
                    description: $("#form_input_desc_" + app.inputId).val(),
                    inputs: app.inputs,
                    type: app.selectedType,
                    category: $("#form_input_category_" + app.inputId).val()
                }
                // app.$parent.$emit('form_copy', formInput);

                app.$emit('copy-field', formInput);
            } else {
                app.showErrorMessage('Cannot copy a empty field');
            }
        },
        selectIndex(index) {
            this.optionIndex = index;
        },
        openConditionsModal() {
            let app = this;
            let inputs = $(".field-label-input-value");

            let questions = [];

            for(let i = 0; i < inputs.length; i++) {
                var input = $(inputs[i]);
                var inputId = parseInt(input.attr('data-input-id'));

                if(inputId == app.inputId) break;

                var inputType = JSON.parse($("#field_input_type_" + inputId).val())
                var inputOptions = JSON.parse($("#field_input_options_" + inputId).val())

                if(Array.isArray(inputOptions) && inputType != null) {
                    var inputQuestion = {
                        key: inputId,
                        label: input.val(),
                        type: inputType,
                        inputs: inputOptions
                    }
                    questions.push(inputQuestion);
                }
            }

            app.previousQuestions = questions;

            if(app.fieldName != '' && app.fieldName != null && app.fieldName != undefined) {
                if(app.previousQuestions.length > 0) {
                    $("#modal-display-if-" + app.inputId).modal("show");
                } else {
                    app.showErrorMessage('There is no field to apply conditions to');
                }
            } else {
                app.showErrorMessage('Please fill the Field Label first');
            }
        },
        addMore() {
            this.questionConditionCount++;
        },
        removeInput(key) {
            $("#condition_question_" + this.inputId + "_" + key).remove();
        },
        selectQuestionCondition(e) {
            let app = this;
            let input = $(e.target);
            let key = input.attr("data-key");
            let inputKey = input.find(":selected").attr("data-key");

            let responsesInput = $("#field_conditions_" + app.inputId + "_" + key);
            let selectedField = app.previousQuestions.find(x => x.key == parseInt(inputKey));

            if(selectedField != null) {
                let responses = selectedField.inputs;

                if(responses.length > 0) {
                    responsesInput.empty();
                    for(let i = 0; i < responses.length; i++) {
                        responsesInput.append($('<option>', {
                            value: responses[i].value, text: responses[i].name
                        }));
                    }
                }
            }
        },
        updateFieldName() {
            let app = this;
            app.onUpdateInputName();
        },
        onUpdateInputName() {
            let app = this;
            let category = $("#form_input_category_" + app.inputId).val();
            let c = category != null && category != undefined ? category : app.fieldCategory;
            app.fieldInputName = (c + ' ' + app.fieldName)
                                                .replace(/[^\w ]/, "")
                                                .split(' ')
                                                .join('_')
                                                .toLowerCase();
        },
        saveConditions() {
            let app = this;
            let container = $("#condition_question_container_" + app.inputId);
            let fields = container.find(".condition-question-field");
            let values = [];
            for(let i = 0; i < fields.length; i++) {
                values.push($(fields[i]).val());
            }
            app.showRequired = values.filter(v => v != "" && v != undefined && v != null).length == 0;
        },
        deleteField() {
            // this.$parent.$emit("delete-field", this.inputId);
            this.$emit("delete-field", this.position);
        }
    },

    watch: {
        formCategories: function(newVal, oldVal) {
            this.categories = newVal;
        }
    }
}
</script>

<style scoped>

.form-background {
    border: 1px solid #fff;
    width: 100%;
    background-color: #fff;
}

.box {
    padding: 0 0px 0 10px;
}

.box .inner-right-div {
    height: 100%;
    background-color: #b3d7f5;
}

.img-view {
    position: relative;
    text-align: center;
    top: 50px;
}

.input-border {
    border: none;
    border-bottom: 1px solid #999;
    padding: 3px 0px;
    background-color: transparent;
    resize: none;
    outline: none;
}

.input-none {
    border: none;
    padding: 3px 0px;
    background-color: transparent;
    resize: none;
    outline: none;
}

.input-border-all {
    border: 1px solid #999;
    padding: 5px 8px;
    background-color: transparent;
    resize: none;
    outline: none;
}

.super-select-icon {
    width: 20px !important;
    height: auto !important;
}

.btn-select-field-type {
    border-color: #ced4da !important;
}

.btn-select-field-type::after {
    float: right !important;
    margin-top: 0.5rem !important;
}
</style>
