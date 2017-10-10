import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        journalFeed : [],
        showMsg: 'State Here'
    },
    getters: {
        journalFeedLen(state) {
            return state.journalFeed.length;
        }
    },
    mutations: {
        assignJournalFeed(state, data) {
            state.journalFeed = data;
        },
        addActive(state) {
            state.journalFeed.forEach( (currentJournal, index) => {
                Vue.set(state.journalFeed[index], 'isActive', false);
            });
        },
        journalFeedActive(state, index) {
            state.journalFeed[index].isActive = !state.journalFeed[index].isActive;
        },
        addNewJournal(state, journal){
            Vue.set(journal, 'isActive', false);
            state.journalFeed.unshift(journal);
        },
        deleteJournal(state, index) {
            state.journalFeed.splice(index, 1);
        },

        showMessage(state, msg) {
            state.showMsg = '';
            //Dom not yet updated
            Vue.nextTick(() => {
                // DOM updated
                state.showMsg = msg;
            });
        }
    }
});