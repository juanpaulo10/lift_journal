<script>
    import moment from 'moment';
    import Helper from '../Helper';

    export default Helper.extend({
        data() {
            return {
                journals: {},
                urls: {
                    feed: '/api/feed'
                }
            }
        },

        filters : {
            ago(date) {
                return moment(date).fromNow();
            }
        },

        methods: {
            ajaxFeed() {
                axios.post(this.urls.feed, {})
                    .then( response => this.journals = response.data );
            }
        },
        
        created() {
            this.ajaxFeed();
        }
    });
</script>