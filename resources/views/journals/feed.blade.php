<feed inline-template v-cloak>
    <div>
        <Modal :show-delete="showDelete" :delete-index="deleteIndex" @cancel-or-delete="resetFeed"></Modal>
        
        
        <div class="columns is-centered is-mobile" v-show="newJournalsLen > 0" style="display: none;">
            <div class="column is-7 m-b-30">
                <a class="button is-outlined is-primary is-medium is-fullwidth"
                @click="addNewJournal">@{{ newJournalsLen }} New Journals</a>
            </div>
        </div>
        
        <div class="columns is-centered is-mobile" v-for="(journal, index) in journals" :key="journal.id">
            <div class="column is-7 m-b-30">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            @{{ journal.title }}
                        </p>
                        <p class="card-header-icon user-and-time">
                            <strong>{{ ucfirst( auth()->user()->name ) }}</strong>&nbsp;<small> @{{ journal.created_at | ago }} </small>
                        </p>
                        <div class="dropdown is-right" 
                            v-bind:class="{ 'is-active' : journal.isActive }" 
                            :key="journal.id">

                            <div class="dropdown-trigger">
                                <a @click.prevent.stop=" journalFeedActive(index) "
                                    class="card-header-icon"
                                    v-on-clickaway="journalFeedInactive"
                                    aria-controls="dropdown-menu" 
                                    aria-haspopup="true">
                                    <span class="icon">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </span>
                                </a>
                            </div>

                            <div class="dropdown-menu" id="dropdown-menu" role="menu" >
                                <div class="dropdown-content">
                                    <a @click.prevent.stop="showEditModal(index), journal.isActive = false" class="dropdown-item">
                                        Edit
                                    </a>
                                    <a @click.prevent.stop="showDeleteModal(index), journal.isActive = false" class="dropdown-item">
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
                </div>

            </div>
        </div>

        <load-feed></load-feed>
    </div>
</feed>