<feed inline-template v-cloak>
    <div>
        <div class="columns is-centered is-mobile" v-for="journal in journals">
            <div class="column is-7 m-b-30">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            @{{ journal.title }}
                        </p>
                        <p class="card-header-icon user-and-time">
                            <strong>{{ ucfirst( auth()->user()->name ) }}</strong>&nbsp;<small> @{{ journal.created_at | ago }} </small>
                        </p>
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