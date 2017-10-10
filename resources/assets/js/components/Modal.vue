<template>
    <div class="modal" :class="{ 'is-active' : showDelete }">
        <div class="modal-background"></div>
        <div class="modal-card">
            
            <header class="modal-card-head">
                <p class="modal-card-title">Are you sure you want to delete?</p>
            </header>

            <footer class="modal-card-foot" style="justify-content: flex-end;">
                <button class="button is-danger" @click="deleteJournal">Delete</button>
                <button class="button" @click="cancelOrDelete">Cancel</button>
            </footer>

        </div>
    </div>
</template>
<script>
    export default {
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
                axios.delete(this.urls.journal + this.$store.state.journalFeed[this.deleteIndex].id,{
                    _method: "DELETE"
                }).then( (response) => {
                    this.$store.commit('deleteJournal', this.deleteIndex);
                    this.cancelOrDelete();
                    this.$store.commit('showMessage', response.data.message);
                }).catch( (response) => {
                    console.log('error feed vue');
                    console.log(response);
                });
            },

            cancelOrDelete() {
                this.$emit('cancel-or-delete');
            }
        }
    }
</script>