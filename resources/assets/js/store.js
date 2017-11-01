import Vue from 'vue';
import Vuex from 'vuex';
import Journals from './vxmodules/journals';

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        Journals,
    },

    state: {
        showMsg: '',
        showEdit: false,
        toEditIndex: -1,
    },

    getters: {
        showEdit(state) {
            return state.showEdit;
        },
        toEditIndex(state) {
            return state.toEditIndex;
        }
    },

    mutations: {
        //computed property message() in app.js
        showMessage(state, msg) {
            state.showMsg = '';
            //Dom not yet updated
            Vue.nextTick(() => {
                // DOM updated
                state.showMsg = msg;
            });
        },

        showEdit(state, iToEdit){
            state.showEdit = true;
            state.toEditIndex = iToEdit;
            //emits event to let listeners know a journal is to be edited.
            //Edit.vue created()
            Event.$emit('edit');
        },

        closeEditModal(state) {
            state.showEdit = false;
            state.toEditIndex = -1;
        },
    }
});