<edit inline-template v-cloak>
    <div class="modal" :class="{ 'is-active' : showEdit }">
        <div class="modal-background"></div>

        <div class="modal-card" v-on-clickaway="closeEditModal">
            <header class="modal-card-head">
                <p class="modal-card-title"> Edit Journal </p>
                <button class="delete" @click="closeEditModal" aria-label="close"></button>
            </header>

            <form class="container-fluid" @submit.prevent="editJournal" @keydown="form.logs.clear($event.target.name)">
                <section class="modal-card-body">
                

                    {{ csrf_field() }}

                    <div class="field">
                        <div class="control">
                            <input class="input" type="text" name="title" v-model="form.title" placeholder="What's your lift today?">
                        </div>

                        <p class="help is-danger" v-if="form.logs.has('title')" v-text="form.logs.getError('title')"></p>
                    </div>

                    <div class="field">
                        <div class="control">
                            <textarea class="textarea" name="notes" rows='3' v-model="form.notes" placeholder="How did it go?"></textarea>
                        </div>

                        <p class="help is-danger" v-if="form.logs.has('notes')" v-text="form.logs.getError('notes')"></p>
                    </div>

                    <hr class="navbar-divider">

                    <p> Add an exercise </p>
                    
                    <div class="columns is-clearfix is-grouped" v-for="(oWorkout, index) in form.workouts">
                        @{{ index }}
                        <div class="column exercise-item">
                            <div class="select" 
                                :class="{ 'is-loading' : oWorkout.isLoading }" >
                                
                                <select :name="'workouts.' + index + '.bodyparts'" v-model="oWorkout.selectedPart" @change="fetchExercise(index)">
                                    
                                    <option v-for="oPart in oWorkout.bodyparts" :value="oPart.id"> 
                                        @{{ oPart.name | ucfirst }}
                                    </option>

                                </select>
                            </div>
                        </div>

                        <div class="column exercise-item">
                            <div class="select" :class="{ 'is-danger' : form.logs.has('workouts.' + index + '.exercises') }">
                                
                                <select :name="'workouts.' + index + '.exercises'" v-model="oWorkout.selectedExercise">

                                    <option v-for="oExercise in oWorkout.exercises" :value="oExercise.id"> 
                                        @{{ oExercise.name | ucfirst }} 
                                    </option>

                                </select>
                            </div>
                        </div>

                        <div class="column is-narrow exercise-item field is-grouped">
                            <input class="input control" 
                                    :class="{ 'is-danger' : form.logs.has('workouts.' + index + '.weight') }" 
                                    type="text" 
                                    :name="'workouts.' + index + '.weight'" 
                                    v-model="oWorkout.weight" 
                                    placeholder="lbs">


                            <input class="input control" 
                                    :class="{ 'is-danger' : form.logs.has('workouts.' + index + '.sets') }" 
                                    type="text" 
                                    :name="'workouts.' + index + '.sets'" 
                                    v-model="oWorkout.sets" 
                                    placeholder="Sets">

                            <input class="input control" 
                                    :class="{ 'is-danger' : form.logs.has('workouts.' + index + '.reps') }" 
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
                            
                            <p v-if="form.workouts.length > 1" class="control">
                                <a @click="deleteWorkout(index)" class="button is-danger is-outlined">
                                    <span class="icon is-small">
                                    <i class="fa fa-times"></i>
                                    </span>
                                </a>
                            </p>
                        </div>
                    </div>

                </section>

                <footer class="modal-card-foot" style="justify-content: flex-end;">
                    <button class="button is-primary" v-bind:class="{ 'is-loading' : form.isLoading }" :disabled="form.logs.any()" >
                        Update
                    </button>

                    <button class="button" @click="closeEditModal">Cancel</button>
                </footer>
            </form>
        </div>

    </div>
</edit>