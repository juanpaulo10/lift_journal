import Vue from 'vue';

export default {
    state: {
        journalFeed : [],
        newJournals: [],
    },

    getters: {
        journalFeedLen(state) {
            return state.journalFeed.length;
        },
        journal(state, getters , rootState) {
            return state.journalFeed[rootState.toEditIndex];
        },
        journals(state) {
            return [ ...state.journalFeed ];
        },
        newJournalsLen(state) {
            return state.newJournals.length;
        }
    },
    
    mutations: {
        loadJournalFeed(state, journals) {
            journals.forEach( (journal, index) => {
                Vue.set(journal, 'isActive', false);
                state.journalFeed.push(journal);
            });
        },
        addActive(state) {
            state.journalFeed.forEach( (currentJournal, index) => {
                Vue.set(state.journalFeed[index], 'isActive', false);
            });
        },
        journalFeedActive(state, index) {
            let isActive = state.journalFeed[index].isActive;
            Vue.set(state.journalFeed[index], 'isActive', !isActive);
        },
        journalFeedInactive(state) {
            state.journalFeed.forEach( (current, index) => {
                Vue.set(state.journalFeed[index], 'isActive', false);
            });
        },
        deleteJournal(state, journal) {
            let iIndex = state.journalFeed.findIndex( (currentJournal) => journal.id === currentJournal.id );
            state.journalFeed.splice(iIndex, 1);
        },
        updateJournal(state, journal) {
            let iIndex = state.journalFeed.findIndex( (currentJournal) => journal.id === currentJournal.id );
            Vue.set(state.journalFeed, iIndex, journal);
        },
        addNewJournal(state){
            state.newJournals.forEach( (journal, index) => {
                Vue.set(journal, 'isActive', false);
                state.journalFeed.unshift(journal);
            });
            Vue.set(state, 'newJournals', []); //empty the newJournals
        },
        newArrivalJournal(state, journal) {
            state.newJournals.push(journal);
        },
    }
}