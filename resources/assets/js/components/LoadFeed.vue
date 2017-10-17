<template>
    <div class="columns is-centered is-mobile">
        <div class="column is-7 m-b-30"
            v-infinite-scroll="loadMore" 
            infinite-scroll-disabled="busy"
            infinite-scroll-throttle-delay="1000"
            >

            <a class="button is-primary is-outlined is-loading is-medium is-fullwidth"
                v-if="showLoadMore">
                Loading Journals
            </a>
            <p v-else class="nothing-more">
                No more journals to load.
            </p>
            
        </div>
    </div>
</template>

<script>
    import Feed from '../models/Feed';
    import infiniteScroll from 'vue-infinite-scroll';

    export default Feed.extend({
        
        name: 'load-feed',

        directives: {infiniteScroll},

        data () {
            return {
                showLoadMore: true,
                iTimesLoaded: 0,
                busy: false,
                scrollY: 0
            }
        },

        methods: {
            //loads more journals in the feed
            loadMore() {
                if( this.showLoadMore !== true ) {
                    return;
                }

                this.busy = true;
                this.scrollY = this.scrollYDefine();
                //load the initial set of journals
                this.ajaxFeed( { iTimesLoaded : this.iTimesLoaded } )
                    .then( (response) => {
                        this.iTimesLoaded++;
                        this.busy = false;
                        this.checkShowLoadMore();
                        // set scroll y position accordingly after fetch
                        window.scrollTo(0, this.scrollY);
                    });
            },

            //determines if it shows the "load more" hint or "No more journals to load"
            checkShowLoadMore(){
                let iFetchedLen = this.$store.getters.journalFeedLen % this.iJournalLimit;
                if( iFetchedLen !== 0 ) {
                    this.showLoadMore = false;
                }
            },

            //cross browser support for scroll Y
            scrollYDefine() {
                let supportPageOffset = window.pageXOffset !== undefined;
                let isCSS1Compat = ((document.compatMode || "") === "CSS1Compat");

                return supportPageOffset ? window.pageYOffset : isCSS1Compat ? document.documentElement.scrollTop : document.body.scrollTop;
            }
        }
    });
</script>