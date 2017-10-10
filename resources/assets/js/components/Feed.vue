<script>
    import moment from 'moment';
    import Helper from '../Helper';

    export default Helper.extend({
        data() {
            return {
                urls: {
                    feed: '/api/feed',
                    journal: '/api/journal/'
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

            deleteJournal() {                
                axios.delete(this.urls.journal + this.$store.state.journalFeed[this.deleteIndex].id,{
                    _method: "DELETE"
                }).then( (response) => {
                    this.$store.commit('deleteJournal', this.deleteIndex);
                    this.resetFeed();
                    this.$emit('create-success', response.data.message);
                }).catch( (response) => {
                    console.log('error feed vue');
                    console.log(response);
                });
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
                console.log(index);
                // console.log(this.$store.state.journalFeed[index].isActive);
                // this.$store.state.journalFeed[index].isActive = !this.$store.state.journalFeed[index].isActive;
                // console.log(this.$store.state.journalFeed[index].isActive);
                //this.$store.commit('name of mutation');
                this.$store.commit('journalFeedActive', index);
            }
        },
        
        created() {
            this.ajaxFeed();
        }
    });
</script>