<template>
    <div>
        <form role="form" action="/tasks" methods="post">
            <div class="box-body">
                <div class="form-group">
                    <label for="description">Name:</label>
                    <input class="form-control" id="description" placeholder="Enter Name" name="description" v-model="description">
                    <span v-if="errors.description" class="error">{{ errors.description[0] }}</span>
                </div>
                                    
                <select-subs></select-subs>
                
            </div>
            <div class="box-footer">
                <button type="button" class="btn btn-success" v-on:click="UpdateTask()">Update</button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: ['id'],
    data() {
            return {
                description: '',
                errors: ''
            }
        },
        mounted() {
            axios.get('/api/tasks/'+this.id).then(response => {
                let task = response.data
                this.Substation_ID = task.Substation_ID
                this.$store.commit('loadSelected', {
                    ServiceObject_Name: task.ServiceObject_Name,
                    Substation_ID: task.Substation_ID
                });
                
                //Готовим массив для выбранных ячеек
                let cells = [];
                task.task_list.forEach(function(item, i, arr) {
                    cells.push(arr[i].Conductor_ID);
                });

                this.$store.commit('loadCells', cells);

            }).catch(error => {
                console.log(error)
            })
        },
        methods: {
            UpdateTask() {
                axios.put('/api/tasks/'+this.id, {
                    Substation_ID: this.$store.state.selected.Substation_ID,
                    ServiceObject_Name: this.$store.state.selected.ServiceObject_Name,
                    selectedCells: this.$store.state.selectedCells
                }).then(response => {
                    console.log(response)
                }).catch(error => {
                    console.log(error)
                })
            }
        }
}
</script>

<style>

</style>
