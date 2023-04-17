<template>
<div>
    <div class="form-group">
        <div class="row">
            <div class="col-12">
                <div class="input-group">
                    <input type="text" :name="inputId + '[address]'" class="form-control" placeholder="Location Address" id="workshop-venue-name" v-model="locationData.addr" :required="required">
                    <div class="input-group-prepend" @click="onShowMap">
                        <div class="input-group-text" style="cursor: pointer; border-top-right-radius: 0.25rem; border-bottom-right-radius: 0.25rem;"><i class="fas fa-map-marker-alt" style="color: #4362ad;"></i></div>
                    </div>
                </div>
                <template v-if="Object.keys(locationData).length > 0">
                    <input hidden :name="inputId + '[latitude]'" :value="locationData.lat">
                    <input hidden :name="inputId + '[longitude]'" :value="locationData.lng">
                </template>
            </div>
        </div>
    </div>

    <map-location title="Select  Location" @clicked="onLocationSelected" :show="openMap" v-cloak />
</div>
</template>

<script>
import MapLocation from './common/MapLocation';

export default {
    name: 'map-view',
    props: {
        inputId: {
            type: String,
            required: true
        },
        required: {
            type: Boolean,
            required: false,
            default: false
        }
    },
    components: {MapLocation},
    mounted() {},
    data() {
        return {
            locationData: {},
            openMap: false,
        }
    },
    methods: {
        onShowMap() {
            this.openMap = this.openMap ? false : true;
        },
        onLocationSelected(value) {
            this.locationData = value;
        },
    },
}
</script>
