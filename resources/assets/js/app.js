
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Login from './components/Login';
import Create from './components/Create';
import Edit from './components/Edit';
import Feed from './components/Feed';
import { store } from './store';

new Vue({
    el: '#app',

    store,

    components: {
        Login,
        Create,
        Feed,
        Edit
    },

    computed: {
        message() {
            return this.$store.state.showMsg;
        }
    },

    created() {}
});
