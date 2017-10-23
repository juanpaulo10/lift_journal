@extends ('layouts.master')

@section ('content')

<section class="section">
    <register inline-template>
        <div class="container">
            <div class="box">
                <h1 class="title is-2 is-spaced">Register</h1>

                <br>

                <div class="notification is-danger" v-show="errNotif.hasErr" style="display: none;">
                    <p v-text="errNotif.msgInfo"></p>
                    <button class="delete" @click="errNotif.hasErr = false"></button>
                </div>

                <form @submit.prevent="register" @keydown="form.logs.clear($event.target.name)">
                    {{ csrf_field() }}

                    <div class="field">
                        <label for="name">Name:</label>

                        <div class="control">
                            <input class="input" type="text" name="name" v-model="form.name">
                        </div>

                        <p class="help is-danger" 
                            v-if="form.logs.has('name')" 
                            v-text="form.logs.getError('name')"></p>
                    </div>

                    <div class="field">
                        <label for="email">Email:</label>

                        <div class="control">
                            <input class="input" type="email" name="email" v-model="form.email">
                        </div>

                        <p class="help is-danger" 
                            v-if="form.logs.has('email')" 
                            v-text="form.logs.getError('email')"></p>
                    </div>

                    <div class="field">
                        <label for="password">Password:</label>

                        <div class="control">
                            <input class="input" type="password" name="password" id="password" v-model="form.password">
                        </div>

                        <p class="help is-danger" 
                            v-if="form.logs.has('password')" 
                            v-text="form.logs.getError('password')"></p>
                    </div>

                    <div class="field">
                        <label for="password_confirmation">Confirm Password:</label>

                        <div class="control">
                            <input class="input" 
                                    type="password" 
                                    name="password_confirmation" 
                                    id="password_confirmation" 
                                    v-model="form.password_confirmation">
                        </div>

                        <p class="help is-danger" 
                            v-if="form.logs.has('password_confirmation')" 
                            v-text="form.logs.getError('password_confirmation')"></p>
                    </div>

                    <div class="control">
                        <button class="button is-primary" 
                                v-bind:class="{ 'is-loading' : form.isLoading }" 
                                type="submit" 
                                :disabled="form.logs.any()" >
                                    Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </register>
</section>

@endsection