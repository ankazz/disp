<template>
    <div class="my-3 p-3 bg-white rounded box-shadow">
        <form class="form-horizontal" action="/tasks" methods="post">
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="description" placeholder="Enter Name" name="description" v-model="description">
                    <span v-if="errors.description" class="error">{{ errors.description[0] }}</span>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">ТП:</label>
                <select-subs></select-subs>
            </div>
            
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-success" v-on:click="addNewTask()">Save</button>
                </div>
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