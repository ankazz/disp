import Axios from "axios";

export default {
    state: {
        selectedCells: [],
        selected: '',
        legals: []
    },
    getters: {
        getMyState: state => state.selectedCells
    },
    actions: {
        //не работает
        loadLegals(state,payload){  
            axios.post('/api/tasks/getLegals', {
                selected_f: payload
            }).then((response) => {
                console.log(response.data, this)
                commit('legals', response.data)
            })
        }
    },
    mutations: {
        loadCells(state, payload) {
            state.selectedCells = payload
        },
        loadSelected(state, payload) {
            state.selected = payload
        },
        legals(state, payload) {
            state.legals = payload
        }
    }
};
