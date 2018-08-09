<template>
<div>
    <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-white rounded box-shadow">
            <a href="/tasks/create" class="btn btn-success pull-right">Add New Task</a>
    </div>
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <h6 class="border-bottom border-gray pb-2 mb-0">Tasks Listing</h6>
    
        <table class="table table-striped">
            <thead>
                <th>ID</th>
                <th>Найменование</th>
                <th>Cause</th>
                <th>Status</th>
                <th>Action</th>
            </thead>
            <tbody>
                <tr v-for="(task, index) in tasks" :key=task.id>
                    <td>{{ task.id }}</td>
                    <td>{{ task.ServiceObject_Name }}</td>
                    <td>{{ task.causes.name }}</td>
                    <td>{{ task.status.name }}</td>
                    <td><a :href="'/tasks/'+task.id+'/edit'" class="btn btn-primary btn-sm">Edit</a> || <a href="javascript:;" class="btn btn-danger btn-sm" v-on:click="deleteTask(task.id,index)">Delete</a></td>
                </tr>
            </tbody>
        </table>
 
        <div class="pagination">
            <button class="btn btn-default" v-on:click="fetchPaginateTasks(pagination.prev_page_url)" :disabled="!pagination.prev_page_url">
                Previos
            </button>
                <span>Page {{ pagination.current_page }} of {{ pagination.last_page }} </span>
            <button class="btn btn-default" v-on:click="fetchPaginateTasks(pagination.next_page_url)" :disabled="!pagination.next_page_url">
                Next
            </button>
        </div>
    </div>  
</div>  
</template>

<script>

export default {
    data(){
        return {
            tasks: [],
            task: {
                id: 0,
                Substation_ID: '',
                Cause_ID: '',
                Status_ID: ''
            },
            url: '/api/tasks',
            pagination: []
        }
    },
    mounted(){
        this.getTasks()
    },
    methods: {
        getTasks(){
            let $this = this
            axios.get(this.url).then(response => {
                this.tasks = response.data.data
                console.log(response.data)
                $this.makePagination(response.data)
            })
        },
        deleteTask(id,index){
            axios.delete(this.url+'/'+id).then(response => {
                console.log(response)

                this.tasks.splice(index, 1)
            }).catch(error => {
                console.log(error)
            })
        },
        makePagination(data) {
            let pagination = {
                current_page: data.current_page,
                last_page: data.last_page,
                next_page_url: data.next_page_url,
                prev_page_url: data.prev_page_url,
            }

            this.pagination = pagination
        },
        fetchPaginateTasks(url) {
            this.url = url
            this.getTasks()
        }
    }
}
</script>

<style>

</style>