<template>
    <div class="custom-actions">
        <a :href="rowData.view" class="btn btn-secondary btn-sm">{{rowData.button}}</a>

        <a class="icon" :href="rowData.edit">
            <i class="fe fe-edit"></i>
        </a>
    </div>
</template>

<script>
    export default {
        props: {
            rowData: {
                type: Object,
                required: true
            },
            rowIndex: {
                type: Number
            },
            show: {
                type: Boolean,
                default: true
            }
        },
        methods: {
            itemAction (action, data, index) {
                console.log(data.id);
                this.$events.fire('delete-show', data.delete)
            }
        }
    }
</script>

<style>
    .custom-actions button.ui.button {
        padding: 8px 8px;
    }

    .custom-actions button.ui.button > i.icon {
        margin: auto !important;
    }
</style>