<template>
<div>
    <div class="form-group">
        <label for="name">ТП:</label>
        <v-select label="name" :filterable="false" :options="options" @search="onSearch" v-model="selected">
            <div slot="no-options">
            type to search GitHub repositories..
            </div>
            <div slot="option" slot-scope="option">
                <div class="d-center">
                    {{ option.ServiceObject_Name }}
                </div>
            </div>
            <div slot="selected-option" slot-scope="option">
            <div class="selected d-center">
                {{ option.ServiceObject_Name }}
            </div>
            </div>
        </v-select> 
    </div>
    <div class="box-body" v-if="selected">    
        <div class="row">
            <div class="col-sm-offset-1 col-xs-5 checkbox">
                <label>1 секция</label>
                <div v-for="cell in cells" :key="cell.Conductor_ID" v-if="cell.Cell == 'Секция 1'" class="form-check" id="section1">
                    <input class="form-check-input" type="checkbox" v-bind:id="cell.Conductor_ID" v-bind:value="cell.Conductor_ID" v-model="selectedCells">
                    <label class="form-check-label" for="defaultCheck1">{{cell.ServiceObject_Name}}</label>
                </div>
            </div>
            <div class="col-xs-6 checkbox">
                <label for="inputCity">2 секция</label>
                <div v-for="cell in cells" :key="cell.Conductor_ID" v-if="cell.Cell == 'Секция 2'" class="form-check">
                    <input class="form-check-input" type="checkbox" v-bind:id="cell.Conductor_ID" v-bind:value="cell.Conductor_ID" v-model="selectedCells">
                    <label class="form-check-label" for="defaultCheck1">{{cell.ServiceObject_Name}}</label>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
        data() {
            return {
                //selected: null,
               //selectedCells: [],
                options: [],
                cells: []
            }
        },
        computed: {
            selectedCells: {
                get () {
                return this.$store.state.selectedCells
                },
                set (value) {
                this.$store.commit('loadCells', value)
                }
            },
            selected: {
                get () {
                return this.$store.state.selected
                },
                set (value) {
                this.$store.commit('loadSelected', value)
                }
            },
        },
        methods: {
            onSearch(search, loading) {
            loading(true);
            this.search(loading, search, this);
            },
            search: _.debounce((loading, search, vm) => {
                axios.post('/api/tasks/searchSub', {
                search: escape(search)
                }).then(response => {
                    vm.options = response.data.items;
                    loading(false);
                    
                });
            }, 350)
        },
        watch: {
            selected: function () {
            //this.cells = [];
            axios.get('/api/tasks/getServiceObjects/'+this.selected.Substation_ID)
            .then(response => {
                this.cells = response.data
                //this.$store.commit('loadCells',response.data)
            }).catch(error => {
                console.log(error)
            })
            
            }
        }
    }
</script>

<style>

</style>
