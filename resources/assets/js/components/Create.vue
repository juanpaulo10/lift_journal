<script>
    import FormWorkout from '../models/FormWorkout';

    export default FormWorkout.extend({
        data() {
            return {
                form: new Form({
                    title: '',
                    notes: '',
                    workouts: [
                        {
                            bodyparts: [],
                            exercises: [],
                            selectedPart: '',
                            selectedExercise: '',
                            isLoading: false,
                            sets: '',
                            reps: '',
                            weight: ''
                        }
                    ]
                }),

                oCacheWorkout: {}
            }
        },

        methods: {
            createJournal(){
                //submit ajax to create journal with its workouts
                this.form.submit('post', this.urls.create)
                        .then( (response) => {

                            this.form.reset( this.resetWorkout );
                            console.log('create journal success');
                            console.log(response);
                            
                            this.$store.commit('showMessage', response.data.message);
                            //io event emit to other connections to update
                        })
                        .catch( (error) => {
                            console.log('fail journal');
                            console.log( error.response );
                        });
            }
        },

        created(){
            this.cacheWorkout(); //from ../models/FormWorkout.js
        }
    });
</script>