<template>
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <form role="form" action="/tasks" methods="post">
            <div class="box-body">
                <div class="form-group">
                    <label for="description">Name:</label>
                    <input class="form-control" id="description" placeholder="Enter Name" name="description" v-model="description">
                </div>              
                
                <select-subs></select-subs>

            </div>
            <div class="box-footer">
                <button type="button" class="btn btn-success" v-on:click="addNewTask()">Save</button>
            </div>
        </form> 
    </div>
</template>

<script>
    export default {
        data() {
            return {
                description: '',
                errors: []
            }
        },
        methods: {
            addNewTask(){
                this.errors = []

                axios.post('/api/tasks', {
                    Substation_ID: this.$store.state.selected.Substation_ID,
                    ServiceObject_Name: this.$store.state.selected.ServiceObject_Name,
                    selectedCells: this.$store.state.selectedCells,
                    ServiceObject_Name: this.$store.state.selected.ServiceObject_Name
                }).then(response => {
                    console.log(response)
                }).catch(error => {
                    if(error.response.status == 422) {
                        this.errors = error.response.data.errors
                    }
                })
            }
        }
    }
</script>