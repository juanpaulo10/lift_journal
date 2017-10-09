<template>
<div>
    <div class="columns is-clearfix is-grouped" v-for="(oWorkout, index) in aWorkouts">
        <div class="column exercise-item">
            <div class="select" 
                :class="{ 'is-loading' : oWorkout.isLoading }" >
                
                <select :name="'workouts.' + index + '.bodyparts'" v-model="oWorkout.selectedPart" @change="fetchExercise(index)">
                    
                    <option v-for="oPart in oWorkout.bodyparts" :value="oPart.id"> 
                        {{ oPart.name | ucfirst }}
                    </option>

                </select>
            </div>
        </div>

        <div class="column exercise-item">
            <div class="select" :class="{ 'is-danger' : logs.has('workouts.' + index + '.exercises') }">
                
                <select :name="'workouts.' + index + '.exercises'" v-model="oWorkout.selectedExercise">

                    <option v-for="oExercise in oWorkout.exercises" :value="oExercise.id"> 
                        {{ oExercise.name | ucfirst }} 
                    </option>

                </select>
            </div>
        </div>

        <div class="column is-narrow exercise-item field is-grouped">
            <input class="input control" 
                    :class="{ 'is-danger' : logs.has('workouts.' + index + '.weight') }" 
                    type="text" 
                    :name="'workouts.' + index + '.weight'" 
                    v-model="oWorkout.weight" 
                    placeholder="lbs">


            <input class="input control" 
                    :class="{ 'is-danger' : logs.has('workouts.' + index + '.sets') }" 
                    type="text" 
                    :name="'workouts.' + index + '.sets'" 
                    v-model="oWorkout.sets" 
                    placeholder="Sets">

            <input class="input control" 
                    :class="{ 'is-danger' : logs.has('workouts.' + index + '.reps') }" 
                    type="text" 
                    :name="'workouts.' + index + '.reps'" 
                    v-model="oWorkout.reps"
                    placeholder="Reps">
        </div>

        <div class="column exercise-item is-narrow field is-grouped">
            <p class="control">
                <a @click="addNewWorkouts" class="button is-success">
                    <span class="icon is-small">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span>More</span>
                </a>
            </p>
            
            <p v-if="aWorkouts.length > 1" class="control">
                <a @click="deleteWorkout(index)" class="button is-danger is-outlined">
                    <span class="icon is-small">
                    <i class="fa fa-times"></i>
                    </span>
                </a>
            </p>
        </div>
    </div>
</div>
</template>

<script>
    import Helper from '../Helper';
    
    export default Helper.extend({
        props: [ 'workouts', 'cache', "formLogs" ],

        data() {
            return {
                aWorkouts : this.workouts,

                oCacheWorkout: this.cacheWorkout,

                logs: this.formLogs,

                urls: {
                    exercises: '/api/exercises',
                },
            }
        },

        methods: {

            deleteWorkout(index){
                this.aWorkouts.splice(index, 1);
            },

            addNewWorkouts(){
                let oTempObj = Object.assign( {}, this.oCacheWorkout );
                //everytime this.oCacheWorkout is added, the newly added is pointing to where it was copied. so, when i type 15, this newly added obj gets 15 too. so we add code ABOVE.
                this.aWorkouts = [ ...this.aWorkouts, oTempObj ];
            },

            fetchExercise(index){
                console.log(index);
                this.aWorkouts[index].isLoading = true;

                this.postRequest(this.urls.exercises, {selectedPart: this.aWorkouts[index].selectedPart})
                    .then( ({data}) => {
                        //put data into this.workout's "index"
                        this.aWorkouts[index].exercises = data;
                        this.aWorkouts[index].selectedExercise = data[0].id;

                        this.aWorkouts[index].isLoading = false;
                    });
            },
            
        },

        
    });
</script>