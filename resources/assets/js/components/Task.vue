<template>
    <div data-page="true" data-nocache="true" :data-alias="$options.name">
        <header class="header-bar">
            <div class="left">
                <button class="btn pull-left icon icon-arrow-back" @click="$router.go(-1)"></button>
                <button class="btn pull-right icon icon-sync" @click="$router.go()"></button>
                <h1 class="title">{{task.task_nar}}</h1>

            </div>
        </header>
        <div class="content padded-full">
            <div>
                <h1>{{task.task_nar}}</h1>

                <div style="border-bottom: 1px solid #dee2e6!important; padding-bottom: 10px; margin-bottom: 10px;">
                    <div class="input-wrapper">
                        <input class="with-label" placeholder="Start Time Format 23:59" type="text" v-model="startTime"
                               id="startTime">

                    </div>
                    <div class="input-wrapper">
                        <input class="with-label" placeholder="End Time Format 23:59" v-model="endTime" type="text"
                               id="endTime">

                    </div>
                    <div class="input-wrapper">
                        <textarea class="with-label" type="text" v-model="remarks" id="remarks"></textarea>
                        <label class="floating-label" for="remarks">Remarks</label>
                    </div>
                    <br/>
                    <br/>
                </div>
                <button class="btn positive" v-on:click="startTiming"><i class="icon icon-check"></i> Start Activity
                </button>

                <button style="float: right !important;" class="btn negative" v-on:click="endTiming"><i
                        class="icon icon-close"></i> Stop
                    Activity
                </button>
                <div v-if="loading" class="circle-progress active" style="visibility: visible; padding: 10px;">
                    <div class="spinner"></div>
                </div>
            </div>

        </div>

    </div>
</template>

<style scoped>
    h1 {
        text-align: center !important;
        padding: 5px;
        padding-bottom: 10px;
        border-bottom: 1px solid #dee2e6 !important;
    }
</style>
<script>
    import * as moment from 'moment';
    import _ from 'lodash'

    export default {
        name: 'task',
        props: ['id', 'flt'],
        data() {
            return {
                task: '',
                taskName: '',
                history_id: '',
                action: null,
                loading: false,
                'rq': axios.create(),
                startTime: null,
                endTime: null,
                remarks: ''
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
            this.rq.get('/api/task' + '/' + this.id, {
                params: {
                    flt: this.flt
                }
            })
                .then(function (response) {
                    console.log(response.data)
                    vm.task = response.data;
                    vm.taskName = response.data.task_nar;
                    vm.startTime = response.data.startTime;
                    vm.endTime = response.data.endTime;
                    vm.remarks = response.data.remarks;
                    vm.history_id = response.data.id;
                })
                .catch(function (error) {
                    console.log(error);
                });

        },
        methods: {
            startTiming() {
                this.startTime = moment().format('HH:mm');
                this.saveData();
            },
            endTiming() {
                this.endTime = moment().format('HH:mm');
                this.saveData();
            },
            saveData: _.debounce(function () {
                var vm = this;
                this.rq.patch('/api/task' + '/' + this.history_id, {
                    startTime: this.startTime,
                    endTime: this.endTime,
                    remarks: this.remarks
                })
                    .then(function (response) {
                        console.log(response.data);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }, 1000)
        },
        watch: {
            startTime: function (val, oldVal) {
                if (val != oldVal) {
                    this.saveData();
                }
            },
            endTime: function (val, oldVal) {
                if (val != oldVal) {
                    this.saveData();
                }
            },
            remarks: function (val, oldVal) {
                if (val != oldVal) {
                    this.saveData();
                }
            },

        }

    }
</script>
