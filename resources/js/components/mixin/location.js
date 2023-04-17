import Swal from "sweetalert2";
const location = {

    mounted(){

    },
    data(){
        return {
            markers: [],
            original_marker : null,
            marker_searched : null,
            dragged_marker : null,
            btn_loc: "Yes use this location",
            districts: [],
            selected_district: "",
            userLat: "",
            userLng: "",
            userAddress: "",
            userPlace: "",
            selectedBusinessName: "",
            anyAddress: "",
            anyLat: "",
            anyLng: "",
            nearByPlaces: [],
            companyData: {}
        }
    },
    methods:{

        showMap(){
            let app = this;
            let loader = Swal;
            loader.showLoading();
            $("#pac-input").val("");
            let lat = "0.3483964" , lng = "32.5780513";
            if (navigator.geolocation){

                navigator.geolocation.getCurrentPosition(function(position) {

                        lat = position.coords.latitude;
                        lng = position.coords.longitude;
                        app.drawMap(lat, lng, true);
                        loader.close();

                    },
                    function (error) {
                        if (error.code === error.PERMISSION_DENIED){
                           //location permission denied by user
                            app.drawMap(lat, lng);
                            loader.close();
                        }
                    });
            }
        },
        drawMap(lat, lng, autoloc){

            let app = this;
            var lat = parseFloat(lat);
            var lng = parseFloat(lng);
            let zoom = 13;
            let map = null;

            if(autoloc){
                zoom = 18
            }

            try {
                new Promise(resolve => {

                    app.$emit("location-modal-open");

                    setTimeout(() => {
                        $("#modal-location").modal('show');
                    }, 1000);
                    resolve("done")

                }).then((result) => {
                    map = new google.maps.Map(document.getElementById('map'), {
                        center: {lat: lat, lng: lng},
                        zoom: zoom
                    });

                    app.original_marker = new google.maps.Marker({
                        position: new google.maps.LatLng(lat, lng),
                        draggable: true,
                        animation: google.maps.Animation.DROP,
                        map: map
                    });

                    app.markers.push(app.original_marker);
                    app.onGeodecode(app.original_marker, map);

                    let input = (document.getElementById('pac-input'));
                    let autoComplete = new google.maps.places.Autocomplete((input));

                    autoComplete.setComponentRestrictions({
                        country: ["ug", "mw"],
                    });

                    autoComplete.addListener('place_changed', function() {
                        let place = autoComplete.getPlace();
                        if (!place.geometry) {
                            window.alert("No details available for input: '" + place.name + "'");
                            return;
                        }

                        app.userAddress = place.formatted_address;
                        app.userPlace = place.name;

                        app.clearMarkers(null, app.markers);

                        app.marker_search = new google.maps.Marker({
                            map: map,
                            position: place.geometry.location,
                            draggable: true,
                        });

                        app.dragged_marker = null;
                        app.original_marker = null;
                        app.markers.push(app.marker_search);

                        if (place.geometry.viewport) {
                            map.fitBounds(place.geometry.viewport);
                        } else {
                            map.setCenter(place.geometry.location);
                            map.setZoom(17);
                        }

                        app.onGeodecode(app.marker_search, map)

                        app.onMarkerDrag(app.marker_search,map);
                        map.panTo(app.marker_search.getPosition());

                    });

                    app.onMarkerDrag(app.original_marker,map);

                    google.maps.event.trigger(map, 'resize');
                    map.panTo(app.original_marker.getPosition());
                });
            } catch (e) {
                console.log(e);
            }

        },
        onMarkerDrag(marker, map){
            let app = this;
            app.dragged_marker = null

            google.maps.event.addListener(marker, 'dragend', function (event) {
                app.marker_search = null
                app.dragged_marker = marker
                app.onGeodecode(marker, map)
                app.btn_loc = "Yes use this location"
            });

            google.maps.event.addListener(marker, 'dragstart', function (event) {
                app.btn_loc = "Loading....."
            });

            map.panTo(marker.getPosition());
            map.setZoom(17);

            google.maps.event.trigger(map, 'resize');
        },
        clearMarkers(map, markers) {
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        },
        onGeodecode(mymarker, map){
            let app = this;
            let position = mymarker.getPosition();

            app.userLat = position.lat();
            app.userLng = position.lng();

            var latlng = {
                lat: parseFloat(position.lat()),
                lng: parseFloat(position.lat()),
            };

            var geocoder = new google.maps.Geocoder();

            geocoder.geocode({location: latlng },  (results, status) => {
                if (status === google.maps.GeocoderStatus.OK) {
                    app.userAddress = results[0].formatted_address;
                }
            });
        },
        dismissLocation(){
            this.userAddress = "";
            this.userLat = "";
            this.userLng = "";
        },
        getNearbyPlaces(position, map) {
            console.log(position);
            let app = this;
            let request = {
                location: position,
                rankBy: google.maps.places.RankBy.DISTANCE,
                keyword: 'business'
            };

            let service = new google.maps.places.PlacesService(map);
            service.nearbySearch(request, (results, status) => {
                if (status === google.maps.places.PlacesServiceStatus.OK) {
                    app.nearByPlaces = results;
                }
            });
        },
        onUseLocation() {
            let app = this;
            $("#modal-location").modal('hide');

            setTimeout(() => {
                app.$emit("location-modal-close");
            }, 1000);

            app.$emit("on-location-picked", {
                lat: app.userLat,
                lng: app.userLng,
                address: app.userAddress,
            })
        },
        closeModal() {
            let app = this;
            $("#modal-location").modal('hide');

            setTimeout(() => {
                app.$emit("location-modal-close");
            }, 1000);
        }
    }
};

export default location
