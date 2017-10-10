<script>
    import moment from 'moment';
    import Helper from '../Helper';
    import Modal from './Modal';

    export default Helper.extend({
        components: {
            Modal
        },

        data() {
            return {
                urls: {
                    feed: '/api/feed',
                },
                showDelete: false,
                deleteIndex: -1
            }
        },

        computed: {
            journals() {
                return this.$store.state.journalFeed;
            }
        },

        filters : {
            ago(date) {
                return moment(date).fromNow();
            }
        },

        methods: {
            ajaxFeed() {
                this.postRequest(this.urls.feed, {})
                    .then( (response) => {
                        this.$store.commit('assignJournalFeed', response.data);
                        this.$store.commit('addActive');
                    });
            },

            editJournal(index) {
                console.log(`editing ${index}`);
            },

            showDeleteModal(index) {
                this.showDelete = true;
                this.deleteIndex = index;
            },

            resetFeed() {
                this.showDelete = false;
                this.deleteIndex = -1;
            },

            showActive(index) {
                //this.$store.commit('name of mutation');
                this.$store.commit('journalFeedActive', index);
            }
        },
        
        created() {
            this.ajaxFeed();
        }
    });
</script>