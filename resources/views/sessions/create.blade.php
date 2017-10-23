@extends ('layouts.master')

@section ('content')
    <section class="section">
        <login inline-template>
            <div class="container">
                <div class="box">
                    <h1 class="title is-2 is-spaced">Sign In</h1>

                    <br>

                    <div class="notification is-danger" v-show="hasErrCredentials" style="display: none;">
                        <p v-text="msgCredentials"></p>
                        <button class="delete" @click="hasErrCredentials = false"></button>
                    </div>

                    <form @submit.prevent="login" @keydown="form.logs.clear($event.target.name)">
                        {{ csrf_field() }}

                        <div class="field">
                            <label for="email">Email:</label>

                            <div class="control">
                                <input class="input" type="email" name="email" v-model="form.email">
                            </div>

                            <p class="help is-danger" v-if="form.logs.has('email')" v-text="form.logs.getError('email')"></p>
                        </div>

                        <div class="field">
                            <label for="password">Password:</label>

                            <div class="control">
                                <input class="input" type="password" name="password" id="password" v-model="form.password">
                            </div>

                            <p class="help is-danger" v-if="form.logs.has('password')" v-text="form.logs.getError('password')"></p>
                        </div>

                        <div class="control">
                            <button class="button is-primary" v-bind:class="{ 'is-loading' : form.isLoading }" type="submit" :disabled="form.logs.any()" >Login</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </login>
    </section>
    
@endsection