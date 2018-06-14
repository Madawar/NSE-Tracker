<template>
    <select id="selectInput" class="options" v-bind:placeholder="placeholder"></select>
</template>
<style>
    .selectize-control{
        width: 90% !important;
    }
</style>
<script>
    export default {
        props: {
            'value': {

                default: 0
            },
            'include':{
              type:Boolean,
              default: false
            },
            'url': {
                type: String,
                default: ''
            },
            'placeholder': {
                type: String,
                default: ''
            },
            'id': {
                type: String,
            },
            'refresh': {
                type: Boolean,
                default: false
            },
            opts: {
                type: Array,
                default: function () {
                    return []
                }
            }

        },
        mounted() {
            var vm = this;
            this.selector = $(this.$el).selectize({
                persist: false,
                maxItems: null,
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                maxItems: 1,
                options: this.options,
                render: {
                    item: function (item, escape) {
                        if(this.include == true){
                            return '<div>' +
                                (item.name ? '<span class="name">' + escape(item.name) + '</span>' : '') +
                                (item.id ? '<span class="email">' + escape(item.id) + '</span>' : '') +
                                '</div>';
                        }else{
                            return '<div>' +
                                (item.name ? '<span class="name">' + escape(item.name) + '</span>' : '') + '</div>';
                        }

                    },
                    option: function (item, escape) {
                        var label = item.name || item.name;
                        var caption = item.name ? item.name : null;
                        if(this.include == true){
                            return '<div>' +
                                '<span class="label">' + escape(label) + '</span><br/>' +
                                (caption ? '<span class="caption">' + escape(caption) + '</span>' : '') +
                                '</div>';
                        }else{
                            return '<div>' +
                                '<span class="label">' + escape(label) + '</span>'+
                                '</div>';
                        }

                    }
                },
                onChange: function (value) {
                    vm.$emit('input', value)
                },
                onInitialize: function () {
                    if (vm.value > 0) {
                        this.setValue(vm.value);
                    }
                }
            });
            if(this.value > 0){
                var selectize = this.selector[0].selectize;
                selectize.disable();
            }
            if (this.opts.length > 0) {
                this.options = this.opts;
            }

            if (this.url != "") {
                this.getData();
            }

        },
        data() {
            return {
                options: []
            }
        },
        methods: {
            getData: function () {
                var vm = this;
                if (this.url === null) {
                    return;
                }
                axios.get(this.url)
                    .then(function (response) {
                        vm.options = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        },
        watch: {
            url: function () {
                if (this.url != "") {
                    this.getData()
                }
            },
            options: function () {
                console.log('options changed');
                var selectize = this.selector[0].selectize;
                selectize.clearOptions();
                selectize.addOption(this.options);
                if (this.refresh == true && this.value == 0) {
                    selectize.refreshOptions();
                }

                if (this.value > 0) {
                    console.log(this.value);
                    selectize.setValue(this.value);
                    selectize.enable();
                }

            },
            opts: function () {
               // this.options = this.opts;
            }
        }
    }
</script>
