<template>
    <div>
        <header class="header-bar">
            <div class="center">
                <h1 class="title">TurnAround Tool</h1>
            </div>
        </header>
        <div class="content">
            <div v-if="loading" class="circle-progress active" style="visibility: visible; padding: 10px;">
                <div class="spinner"></div>
            </div>
            <ul class="list" v-if="flights.length > 0">
                <li class="divider">Select a Flight</li>
                <li v-for="flight in flights"><router-link class="padded-list" :to="{ name:'services', params: {id: flight.id,flt:flight.flt } }">{{flight.flt}} ({{flight.flightDate}} <b>{{flight.narration}}</b>)</router-link></li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'flight',
        props: {

        },
        data() {
            return {
                flights: [],
                loading:false,
                'rq': axios.create(),
            }
        },
        mounted() {
            var vm = this;
            this.rq.interceptors.request.use(function (config) {
                // Do something before request is sent
                vm.loading = true;
                return config;
            }, function (error) {
                // Do something with request error
                return Promise.reject(error);
            });
            this.rq.interceptors.response.use(function (response) {
                // Do something with response data
                vm.loading = false;
                return response;
            }, function (error) {
                // Do something with response error
                return Promise.reject(error);
            });
            var vm = this;
            this.rq.get('/api/flight')
                .then(function (response) {
                    console.log(response.data)
                    vm.flights = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        methods: {
            onReady() {

            }
        }
    }
</script>
