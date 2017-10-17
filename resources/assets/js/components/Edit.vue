<script>
    import FormWorkout from '../models/FormWorkout';
    import { mixin as clickaway } from 'vue-clickaway';
    import { mapGetters, mapMutations } from 'vuex';

    export default FormWorkout.extend({
        mixins: [ clickaway ],

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

        computed: {
            ...mapGetters([
                'showEdit' //this.showEdit() === return this.$store.getters.showEdit
            ])
        },

        methods: {
            ...mapMutations([
                'closeEditModal' //this.closeEditModal() = this.$store.commit('closeEditModal');
            ]),

            //submit the form (Form.submit() from Form Class)
            editJournal(){
                // means the edit modal was closed.
                if( this.$store.getters.toEditIndex === -1 ) {
                    return;
                }
                
                this.form.submit('patch', `/api/journal/${this.$store.getters.journal.id}`)
                        .then( (response) => {
                            this.form.reset( this.resetWorkout );
                            console.log('update journal success');
                            console.log(response);
                            
                            this.$store.commit('showMessage', response.data.message);
                            this.closeEditModal();
                        })
                        .catch( (error) => {
                            console.log('fail updating journal');
                            console.log( error );
                        });
            },

            fillEditForm() {
                this.form.reset( this.resetWorkout );
                let journal = this.$store.getters.journal;
                this.$set(this.form, 'title', journal.title);
                this.$set(this.form, 'notes', journal.notes);
                
                journal.exercises.forEach( (currExercise, index) => {
                    //Asynchronous calls inside loop using Immediately Invoked Anonymous Function
                    (function(){
                        this.postRequest(this.urls.exercises, {selectedPart: currExercise.body_part_id})
                            .then( ({data}) => {
                                this.$set(this.form.workouts[index], 'exercises', data);
                            });
                    }.bind(this))(index);

                    this.$set(this.form.workouts[index], 'selectedPart', currExercise.bodypart.id);
                    this.$set(this.form.workouts[index], 'selectedExercise', currExercise.pivot.exercise_id);
                    this.$set(this.form.workouts[index], 'sets', currExercise.pivot.sets);
                    this.$set(this.form.workouts[index], 'reps', currExercise.pivot.reps);
                    this.$set(this.form.workouts[index], 'weight', currExercise.pivot.weight);

                    if(journal.exercises.length > this.form.workouts.length){
                        this.addNewWorkouts();
                    }
                });
            },
        },

        created() {
            //listens from $store that a journal is to be edited.
            //store.js : showEdit(state, iToEdit)
            Event.$on('edit', () => {
                this.fillEditForm();
            });

            this.cacheWorkout();//from ../models/FormWorkout.js
        }
        
    });
</script>