import Helper from '../Helper';

export default Helper.extend({
    data() {
        return {
            urls: {
                feed: '/api/feed',
            },

            iJournalLimit: 5,
        }
    },

    methods: {
        ajaxFeed(obj = {}) {
            //a copy of Form.js "submit()"" method
            return new Promise( (resolve, reject) => {
    
                this.postRequest( this.urls.feed, obj )
                    .then( (response) => {
                        this.$store.commit('loadJournalFeed', response.data);
                        // this.$store.commit('addActive');
    
                        resolve(response); //use form.submit(...).then( yourcallback )
                    }).catch( (error) => {
                        reject(error);
                    });
                    
            });
        },
    }
});