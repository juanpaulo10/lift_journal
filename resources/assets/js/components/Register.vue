<script>
    export default {
        data() {
            return {
                form: new Form({
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                }),

                url: {
                    register: '/register'
                },
                
                errNotif: {
                    hasErr: false,
                    msgInfo: '',
                }
            }
        },

        methods: {
            register() {
                this.form.submit('post', this.url.register)
                    .then( response => {

                        if(response.data.hasOwnProperty('message'))
                            this.$store.commit('showMessage', response.data.message);

                        setTimeout( () => {
                            window.location.href = response.data.url;
                        }, 2000);

                    }).catch( error => {} );
            }
        }
    }
</script>
