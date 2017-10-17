<template>
    <div class="modal" :class="{ 'is-active' : showDelete }"  >
        <div class="modal-background"></div>
        <div class="modal-card" v-on-clickaway="cancelOrDelete">
            
            <header class="modal-card-head">
                <p class="modal-card-title" >Are you sure you want to delete?</p>
            </header>

            <footer class="modal-card-foot" style="justify-content: flex-end;">
                <button class="button is-danger" @click="deleteJournal">Delete</button>
                <button class="button" @click="cancelOrDelete">Cancel</button>
            </footer>

        </div>
    </div>
</template>
<script>
    import { mixin as clickaway } from 'vue-clickaway';

    export default {
        mixins: [ clickaway ],

        props: [ 'showDelete', 'deleteIndex' ],

        data() {
            return {
                urls: {
                    journal: '/api/journal/'
                },
            }
        },

        methods: {
            deleteJournal() {
                axios.delete(this.urls.journal + this.$store.getters.journals[this.deleteIndex].id,{
                    _method: "DELETE"
                }).then( (response) => {
                    this.cancelOrDelete();
                    this.$store.commit('showMessage', response.data.message);
                }).catch( (response) => {
                    console.log('error feed vue');
                    console.log(response);
                });
            },

            cancelOrDelete() {
                this.$emit('cancel-or-delete'); //emit the resetFeed in Feed.vue
            },
        }
    }
</script>