<template>
    <div>
        <div v-if="!hasFile" id="drop-area" class="drag-drop-area px-2 py-3" style="margin-left:0; margin-right:0;">
            <div class="text-center drop-zone">
                <img  class="icon-img mb-2" src="/images/icons/icon.upload.png">
                <h6 style="color: #BBBBBB; margin-bottom:0.2rem;">DRAG &amp; DROP </h6>
            </div>
            <div class="text-center">
                <p style="color: #BBBBBB; margin-bottom:0; padding-bottom:0; font-size: 12px;">Form Icon, or if you prefer</p>
                <div class="position-relative">
                    <button type="button" class="btn btn-primary position-relative" style="font-size: 12px; margin-top: 5px;">Choose files
                        <input @change="onBrowseFile"  type="file" style="position: absolute; left: 0; top: 0; opacity: 0; cursor: pointer;">
                    </button>
                </div>
            </div>
        </div>

        <div v-else class="border p-5">
            <h6 class="text-center te xt-black-50">{{file.name}}</h6>
            <div class="mx-6 mt-3 mb-2">
                <div v-if="isProgressing" class="progress" style="height: 8px;">
                    <div class="progress-bar" role="progressbar" :style="{'width': progressValue + '%'}" :aria-valuenow="progressValue" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="text-center">
                <button @click.prevent="removeFile()" style="font-size: 24px; color: #666666; background: #FFFFFF; outline: none; border: none; cursor: pointer;"><i class="far fa-trash-alt"></i></button>
            </div>
        </div>
    </div>

</template>

<script>
    import Izitoast from "../mixin/IziToast";
    import dragAndDropHelper from "../mixin/dragAndDropHelper";
    export default {
        name: "IconUpload",
        mixins: [
            dragAndDropHelper, Izitoast
        ],
        props: {
            progress: {
                required: true,
                type: Number
            },
            progressing: {
                required: true,
                type: Boolean
            }
        },
        data() {
            return {
                hasFile: false,
                file: null,
                progressValue: 0,
                isProgressing: false
            }
        },
        mounted() {
            let app = this;

            app.progressValue = app.progress;
            app.isProgressing = app.progressing;

            app.dragAndDrop((e) => {
                let fileData = app.fileData(e);
                app.hasFile = true;
                app.file = fileData.file;
                app.$parent.$emit("icon-file-uploaded", fileData)
            });
        },
        methods: {

            removeFile() {
                let app = this;
                app.hasFile = false;
                app.file = null;
                
                $("#file").val()
                app.$parent.$emit("icon-file-removed")
            },
            onBrowseFile(e) {
                let app = this;
                let fileData = app.fileData(e, 'browse');

                app.hasFile = true;
                app.file = fileData.file;
                app.$parent.$emit("icon-file-uploaded", fileData)
            },
        },
        watch: {
            progress: function(newVal, oldVal) {
                this.progressValue = newVal;
            },
            progressing: function(newVal, oldVal) {
                this.isProgressing = newVal;
            }
        }
    }
</script>

<style scoped>

</style>
