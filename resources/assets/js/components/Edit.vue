<template>
    <div>
        <form class="form-horizontal" action="/tasks" methods="post">
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="description" placeholder="Enter Name" name="description" v-model="description">
                    <span v-if="errors.description" class="error">{{ errors.description[0] }}</span>
                </div>
            
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">ТП:</label>
                <select-subs></select-subs>
            </div>
            
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-success" v-on:click="UpdateTask()">Update</button>
                </div>
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
