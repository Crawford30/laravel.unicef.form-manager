<template>
    <div>
        <div v-for="c in count" :key="'table_data_' + index + '_' + c" class="form-row mb-2">
            <div class="col-md" v-for="field in Object.keys(inputField.rows)" :key="'field_prev_no_' + field">
                <label v-if="c == 1" style="font-size: 12px; color: #666;">{{inputField.rows[field].name}}</label>
                <div v-if="inputField.rows[field].type != 'select'">
                    <input :type="inputField.rows[field].type" class="form-control" :placeholder="inputField.rows[field].name" :name="inputField.field_input_name + '[' + inputField.rows[field].name + '][' + c + ']'">
                </div>
                <div v-else>
                    <select :name="inputField.field_input_name + '[' + inputField.rows[field].name + '][' + c + ']'" class="form-control custom-select" style="width:100%;">
                        <option value="" disabled selected>Select</option>
                        <option v-for="value in inputField.rows[field].values.split(',')" :value="value.trim()" :key="'field_table_drop_' + value + '_' + field">{{value.trim()}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="mt-2">
            <button @click="addMoreField()" type="button" class="btn btn-success add-more-btn py-2 m-0">
                <span class="fa fa-plus"></span>
            </button> 
        </div>
    </div>

</template>

<script>
    export default {
        name: "TableInputCollect",
        mixins: [],
        props: {
            inputField: {
                required: true,
                type: Object
            },
            index:{
                required: true,
                type: String
            }
        },
        data() {
            return {
                count: 1
            }
        },
        mounted() {
            
        },
        methods: {
            addMoreField() {
                this.count++;
            }
        },
    }
</script>

<style scoped>

</style>
