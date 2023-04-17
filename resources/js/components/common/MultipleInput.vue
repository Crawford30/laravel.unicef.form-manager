<template>
    <div>
        <div v-for="(item, key) in inputsCount" :key="key" :id="'multi_input_' + key" class="row">
            <input v-model="values[key]" type="text" @keyup="updateValues" :class="{'col-md-12': !deleteButton}" class="form-control mb-2 col-md-10" :name="inputName + '[]'" :placeholder="placeholder" autocomplete="off">
            <span v-if="deleteButton && key != 0" @click="removeInput(key)" class="col-md-2 pt-2" style="cursor: pointer;">
                <i class="far fa-trash-alt" style="font-size: 20px; color: #999;"></i>
            </span>
        </div>
        <button @click="addMore" style="margin-left: -15px;"  type="button" class="btn btn-success text-white add-more-btn addMore">
            <span class="fa fa-plus text-blue"></span>
        </button>
    </div>
</template>
<script>

    export default {
        name: "multiple-input",
        components:{},
        props:{
            inputName:{
                type: String,
                required:true,
            },
            placeholder:{
                type: String,
                required:false
            },
            inputsValues:{
                type: Array,
                required: false
            },
            deleteButton: {
                type: Boolean,
                required: false,
                default: false
            }
        },
        data() {
            return {
                inputsCount: 1,
                values: [],
            }
        },
        mounted() {
            let app = this;
            if (app.inputsValues != null) {
                app.inputsCount = app.inputsValues.length;
                if (app.inputsCount != 0 ) {
                    app.values = app.inputsValues;
                } else {
                    app.inputsCount = 1;
                }
            }
        },
        methods: {
            addMore(){
                this.inputsCount += 1;
            },
            removeInput(key) {
                let app = this;
                $("#multi_input_" + key).remove();
                var values = $("input[name='" + app.inputName + "[]']")
                                    .map(function(){
                                        return $(this).val();
                                    }).get();
                app.$parent.$emit(app.inputName, values);
            },
            updateValues() {
                let app = this;
                var values = $("input[name='" + app.inputName + "[]']")
                                    .map(function(){
                                        return $(this).val();
                                    }).get();
                app.$parent.$emit(app.inputName, values);
            }
        },
        watch: {
            inputsValues: function(newVal, oldVal) {
                if (newVal != null) {
                    this.inputsCount = newVal.length;
                    if (this.inputsCount != 0 ) {
                        this.values = newVal;
                    } else {
                        this.inputsCount = 1;
                    }
                }
            }
        }
    }
</script>

