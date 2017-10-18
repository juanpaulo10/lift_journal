<script>
    import moment from 'moment';
    import Helper from '../Helper';
    import Modal from './Modal';
    import { mixin as clickaway } from 'vue-clickaway';
    import LoadFeed from './LoadFeed';
    import { mapGetters, mapMutations } from 'vuex';

    export default Helper.extend({
        //put sockets here to only execute once throughout the whole app.
        //functions here are from redis channels of ../server.js
        sockets: {
            createdjournal(oJournal) {
                let oParseJournal = JSON.parse(oJournal);
                console.log('journal is created: ', oParseJournal );
                this.$store.commit('newArrivalJournal', oParseJournal);
            },

            updatedjournal(oJournal) {
                let oParseJournal = JSON.parse(oJournal);
                console.log('journal is updated: ', oParseJournal );
                this.$store.commit('updateJournal', oParseJournal);
            },

            deletedjournal(aJournalId) { //only contains id.
                let aParseJournalId = JSON.parse(aJournalId);
                console.log('journal is deleted: ', aParseJournalId);

                this.$store.commit('deleteJournal', aParseJournalId);
            }
        },

        mixins: [ clickaway ],

        components: {
            Modal,
            LoadFeed
        },

        data() {
            return {
                showDelete: false,
                deleteIndex: -1,
            }
        },

        computed: {
            ...mapGetters([
                'journals', // this.journals() === this.$store.getters.journals
                'newJournalsLen' //this.newJournalsLen() === this.$store.getters.newJournalsLen
            ]),
        },

        filters : {
            ago(date) {
                return moment(date).fromNow();
            }
        },

        methods: {
            ...mapMutations([
                //show dropdown of the currently selected journal
                'journalFeedActive', // this.journalFeedActive(index) === this.$store.commit('journalFeedActive', index)
                'journalFeedInactive', // this.journalFeedInactive === this.$store.commit('journalFeedInactive')
            ]),
            ...mapMutations({
                showEditModal: 'showEdit' //map this.showEditModal(index) with this.$store.commit('showEdit', index)
            }),

            showDeleteModal(index) {
                this.showDelete = true;
                this.deleteIndex = index;
            },

            resetFeed() {
                this.showDelete = false;
                this.deleteIndex = -1;
            },

            addNewJournal() {
                this.$store.commit('addNewJournal');
            }
        },

    });
</script>