import Helper from '../Helper';

export default Helper.extend({
    data() {
        return {
            urls: {
                exercises: '/api/exercises',
                bodyparts: '/api/bodyparts'
            },
        }
    },

    methods: {
        cacheWorkout() {
            console.log('edit caching');
            this.postRequest(this.urls.bodyparts, {})
                .then( ({data}) => {
                    //from api/bodyparts, put data into bodyparts
                    this.form.workouts[0].bodyparts = data;
                    this.form.workouts[0].selectedPart = data[0].id;
                    
                    //needs to be returned to have another request
                    return this.postRequest(this.urls.exercises, {selectedPart: this.form.workouts[0].selectedPart});
                })
                .then( ({data}) => {
                    //from api/exercises, put data into exercises
                    this.form.workouts[0].exercises = data;
                    this.form.workouts[0].selectedExercise = data[0].id;
                    this.oCacheWorkout = Object.assign( {}, this.form.workouts[0] );
                    // [this.oCacheWorkout] = [...this.form.workouts]; //destructure //cache the workout 
                });
        },

        fetchExercise(index){
            console.log(index);
            this.form.workouts[index].isLoading = true;

            this.postRequest(this.urls.exercises, {selectedPart: this.form.workouts[index].selectedPart})
                .then( ({data}) => {
                    //put data into this.workout's "index"
                    this.form.workouts[index].exercises = data;
                    this.form.workouts[index].selectedExercise = data[0].id;

                    this.form.workouts[index].isLoading = false;
                });
        },

        deleteWorkout(index){
            this.form.workouts.splice(index, 1);
        },

        addNewWorkouts(){
            let oTempObj = Object.assign( {}, this.oCacheWorkout );
            //everytime this.oCacheWorkout is added, the newly added is pointing to where it was copied. so, when i type 15, this newly added obj gets 15 too. so we add code ABOVE.
            this.form.workouts = [ ...this.form.workouts, oTempObj ];
        },

        resetWorkout(){
            for (let field in this.form.oOriginalData) {
                if( field === 'workouts' ){
                    // this.form.workouts = this.oCacheWorkout;
                    let oTempObj = Object.assign( {}, this.oCacheWorkout );
                    this.form.workouts = [oTempObj];
                    // console.log(this.form.workouts);
                    continue;
                }
                this.form[field] = '';
            }
        },
    }
});