<feed inline-template v-cloak @create-success="showSuccess">
    <div>
        <div class="modal" :class="{ 'is-active' : showDelete }">
            <div class="modal-background"></div>
            <div class="modal-card">
                
                <header class="modal-card-head">
                    <p class="modal-card-title">Are you sure you want to delete?</p>
                </header>

                <footer class="modal-card-foot" style="justify-content: flex-end;">
                    <button class="button is-danger" @click="deleteJournal">Delete</button>
                    <button class="button" @click="showDelete = false">Cancel</button>
                </footer>

            </div>
        </div>
        <div class="columns is-centered is-mobile" v-for="(journal, index) in journals">
            <div class="column is-7 m-b-30">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            @{{ journal.title }} @{{ index }}
                        </p>
                        <p class="card-header-icon user-and-time">
                            <strong>{{ ucfirst( auth()->user()->name ) }}</strong>&nbsp;<small> @{{ journal.created_at | ago }} </small>
                        </p>
                        <div class="dropdown is-right" v-bind:class="{ 'is-active' : journal.isActive }" >

                            <div class="dropdown-trigger">
                                <a @click.prevent=" showActive(index) "
                                    class="card-header-icon" 
                                    aria-controls="dropdown-menu" 
                                    aria-haspopup="true">
                                    <span class="icon">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </span>
                                </a>
                            </div>

                            <div class="dropdown-menu" id="dropdown-menu" role="menu">
                                <div class="dropdown-content">
                                    <a @click.prevent="editJournal(index)" class="dropdown-item">
                                        Edit
                                    </a>
                                    <a @click.prevent="showDeleteModal(index), journal.isActive = false" class="dropdown-item">
                                        Delete
                                    </a>
                                </div>
                            </div>

                        </div>
                    </header>
                    <div class="card-content">
                        <div class="content">
                            @{{ journal.notes }}
                            <br>
                        </div>

                        <table class="table is-fullwidth">
                            <thead>
                                <tr>
                                    <th>Exercise</th>
                                    <th>Body Part</th>
                                    <th>Weight (lbs)</th>
                                    <th>Sets</th>
                                    <th>Reps</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="exercise in journal.exercises">
                                    <td> @{{ exercise.name }} </td>
                                    <td> @{{ exercise.bodypart.name | ucfirst }} </td>
                                    <td> @{{ exercise.pivot.weight }} </td>
                                    <td> @{{ exercise.pivot.sets }} </td>
                                    <td> @{{ exercise.pivot.reps }} </td>
                                <tr>
                            </tbody>
                        </table>
                        
                    </div>
                    {{--  <footer class="card-footer">
                        <a href="#" class="card-footer-item">Save</a>
                        <a href="#" class="card-footer-item">Edit</a>
                        <a href="#" class="card-footer-item">Delete</a>
                    </footer>  --}}
                </div>

            </div>
        </div>
    </div>
</feed>