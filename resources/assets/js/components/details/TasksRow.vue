<template>
    <div @click="onClick">
        <table v-if="rowData!=''" class="table card-table table-vcenter text-nowrap table-sm">
            <tr>
                <th>Task Name</th>
                <th>Timed</th>


            </tr>
            <tr v-for="row in rowData.tasks">
                <td>{{row.task}}</td>
                <td>{{row.timed}}</td>


            </tr>
        </table>
        <div v-if="rowData==''" class="text-center"><b>No Data Yet</b></div>
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
            }
        },
        methods: {
            onClick(event) {
                console.log('my-detail-row: on-click', event.target)
            }
        },
    }
</script>