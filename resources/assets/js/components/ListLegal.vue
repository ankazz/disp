<template>
    <div>
        <ul id="example-1">
        <li v-for="legal in legals" :key="legal.ServiceObject_ID">
            {{ legal.Address_Name }}
        </li>
        </ul>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
    data() {
        return {
            legals: []
        }
    },

    computed: {
        ...mapGetters({
            myState: 'getMyState',
        }) 
    },
    watch: {
            myState: function () {
                if(this.myState){
                    axios.post('/api/tasks/getLegals', {
                    selected_f: this.myState
                    }).then((response) => {
                        this.legals = response.data
                        //this.$store.commit('legals', response.data)
                    })
                }else{
                    console.log('null State')
                }
                
            }
        }
}
</script>

<style>

</style>
