<script>
    export default {
        data() {
            return {
                form: new Form({
                    email: '',
                    password: ''
                }),
                hasErrCredentials: false,
                msgCredentials: ''
            }
        },

        methods: {
            login() {
                this.form.submit('post', '/login')
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
                    this.hasErrCredentials = true;
                    this.msgCredentials = data.message;
                }
            }
        }
    }
</script>