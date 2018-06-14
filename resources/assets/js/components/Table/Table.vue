<template>

    <div class="vtable">
        <div class="row no-gutters filterbar p-1">
            <div class="col">
                <div class="btn-list pt-1">
                    <div href="#" class="btn btn-secondary"><i class="fe fe-arrow-down-circle"></i> Download View</div>
                    <div v-on:click="resetFilter" href="#" class="btn btn-secondary"><i class="fa fa-eraser"></i> Reset Filter</div>
                </div>
            </div>
            <div class="col">
                <div class="float-right pt-1">
                    <div class="input-icon mb-3">
                        <input type="text" class="form-control" v-model="filterText" @keyup.enter="doFilter"
                               placeholder="Search for...">
                        <span class="input-icon-addon">
                              <i class="fe fe-search"></i>
                            </span>
                    </div>
                </div>
            </div>
        </div>


        <div class="table-responsive">
            <vuetable
                    ref="vuetable"
                    :api-url="url"
                    :fields="fields"
                    pagination-path=""
                    :row-class="rowColor"
                    :css="css.table"
                    :append-params="moreParams"
                    :multi-sort="true"
                    @vuetable:loading="showLoader"
                    @vuetable:loaded="hideLoader"
                    @vuetable:pagination-data="onPaginationData"
                    :detail-row-component="detail_row"
                    @vuetable:cell-clicked="onCellClicked"
            ></vuetable>
            <div class="vuetable-pagination">

                <div class="col">
                    <vuetable-pagination-info ref="paginationInfo"
                                              info-class="pagination-info"
                    ></vuetable-pagination-info>
                </div>
                <div class="col">
                    <vuetable-pagination ref="pagination"
                                         :css="css"
                                         @vuetable-pagination:change-page="onChangePage"
                    ></vuetable-pagination>
                </div>

            </div>
        </div>

    </div>
</template>

<script>
    // import accounting from 'accounting'
    //import moment from 'moment'
    import Vuetable from 'vuetable-2/src/components/Vuetable'
    import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
    import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
    import Vue from 'vue'
    import VueEvents from 'vue-events'
    import FilterBar from './FilterBar'
    import CustomActions from './CustomActions'
    import DetailRow from '../details/DetailRow'
    import TasksRow from '../details/TasksRow'
    import GraphRow from '../details/GraphRow'

    Vue.use(VueEvents)
    Vue.component('filter-bar', FilterBar)
    Vue.component('custom-actions', CustomActions)
    Vue.component('my_detail_row', DetailRow)
    Vue.component('tasks_row', TasksRow)
    Vue.component('graph_row', GraphRow)

    export default {
        components: {
            Vuetable,
            VuetablePagination,
            VuetablePaginationInfo
        },
        props: ['columns', 'url', 'filters', 'threshold','detail_row'],
        mounted: function () {

        },
        data: function () {
            return {
                show: false,
                delete_id: null,
                delete_url: null,
                loading: false,
                filterText: '',
                css: {
                    table: {
                        tableClass: 'table card-table table-vcenter text-nowrap',
                        ascendingIcon: 'glyphicon glyphicon-chevron-up',
                        descendingIcon: 'glyphicon glyphicon-chevron-down'
                    },

                    wrapperClass: 'pagination',
                    activeClass: 'active',
                    disabledClass: 'disabled',
                    pageClass: 'page-link',
                    linkClass: 'page-link',

                    icons: {
                        first: 'fe fe-chevrons-left',
                        prev: 'fe fe-chevron-left',
                        next: 'fe fe-chevron-right',
                        last: 'fe fe-chevrons-right',
                    }
                },
                moreParams: {
                    paginate: 1
                }
            }
        },
        methods: {
            showLoader() {
                this.loading = true
            },
            hideLoader() {
                this.loading = false
            },
            rowColor: function (item) {
                return item.color;
            },
            destroyItem: function (item) {

            },
            onCellClicked: function (data, field, event) {
                console.log('cellClicked: ', field.name)
                this.$refs.vuetable.toggleDetailRow(data.id)
            },
            onChangePage(page) {
                this.$refs.vuetable.changePage(page)
            },
            onPaginationData(paginationData) {
                this.$refs.pagination.setPaginationData(paginationData)
                this.$refs.paginationInfo.setPaginationData(paginationData)
            },
            doFilter() {
                this.moreParams = {
                    filter: this.filterText,
                    paginate: 1
                }
                Vue.nextTick(() => this.$refs.vuetable.refresh())
            },
            resetFilter(){
                this.moreParams = {
                    paginate: 1
                }
                Vue.nextTick(() => this.$refs.vuetable.refresh())
            }
        },
        watch: {},
        computed: {
            fields: function () {
                return this.columns;
            }
        },
        events: {

            'delete-show'(data) {
                this.delete_url = data;
                this.show = true;
            },
            'delete-hide'(data) {
                this.show = false;
            },
            'delete-finished'(data) {
                this.show = false;
                var params = this.$refs.vuetable.getAllQueryParams()
                this.moreParams = {
                    filter: params.filter,
                    paginate: 1
                }
                Vue.nextTick(() => this.$refs.vuetable.refresh())
            },
            'report_type'(report) {
                // GET /someUrl
                var params = this.$refs.vuetable.getAllQueryParams()
                var x = this.columns.filter(function (el) {
                    return el.visible == true;
                });
                params.paginate = 0;
                params.filetype = report;
                params.columns = x;
                var queryString = $.param(params);
                var uri = this.url + '?' + queryString;
                window.open(uri)

            },
            'filter-scope'(filterText) {
                this.moreParams = {
                    scope: filterText,
                    paginate: 1
                }
                Vue.nextTick(() => this.$refs.vuetable.refresh())
            },

            'field-toggle'(field) {
                field.visible = !field.visible
                Vue.nextTick(() => this.$refs.vuetable.normalizeFields());
                console.log(this.$refs.vuetable.getAllQueryParams());
                //Emit column Collapse
                var x = this.columns.filter(function (el) {
                    return el.visible == true;
                });
                if (parseInt(x.length) > parseInt(this.threshold)) {
                    this.$emit('collapse');
                } else {
                    this.$emit('expand');
                }
            }
        }
    }


</script>
<style scoped>
    .vtable {
        padding-bottom: 20px;
    }

    .vuetable {
        border-bottom: 1px solid rgba(0, 40, 100, 0.12);
        margin-bottom: 10px;
    }

    .pagination {
        margin: 0;
        float: right;
    }

    .pagination a {
        text-decoration: none;
        cursor: pointer;
    }

    .pagination a.page-link {
        border: 1px solid lightgray;
        border-radius: 3px;
        padding: 5px 10px;
        margin-right: 2px;
    }

    .pagination a.page-link.active {
        color: white;
        background-color: #337ab7;
        border: 1px solid lightgray;
        border-radius: 3px;
        padding: 5px 10px;
        margin-right: 2px;
    }

    .pagination a.btn-nav {
        border: 1px solid lightgray;
        border-radius: 3px;
        padding: 5px 7px;
        margin-right: 2px;
    }

    .pagination a.btn-nav.disabled {
        color: lightgray;
        border: 1px solid lightgray;
        border-radius: 3px;
        padding: 5px 7px;
        margin-right: 2px;
        cursor: not-allowed;
    }

    .pagination-info {
        float: left;
    }

    th.sortable:hover {
        text-decoration: none !important;
    }

    .filterbar {
        background: #f8f9fa;
    }
</style>


