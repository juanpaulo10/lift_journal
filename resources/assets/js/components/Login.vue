<script>
    export default {
        data() {
            return {
                form: new Form({
                    email: '',
                    password: ''
                }),
                msgCredentials: '',
                url: {
                    login: '/login'
                }
            }
        },

        methods: {
            login() {
                this.form.submit('post', this.url.login)
                    .then( response => {
                        if(response.data.hasOwnProperty('url'))
                            window.location.href = response.data.url;
                    }).catch( error => {
                        console.log( '.catch' );
                        console.log( error.response );
                        this.isErrCredentials(error.response.status, error.response.data);
                    });
            },
            isErrCredentials(code, data){
                if ( code === 401 ){
                    this.msgCredentials = data.message;
                }
            }
        }
    }
</script>