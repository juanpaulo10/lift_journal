{{--  v-show not working since it does not technically delete the element and
show it again. i cant think of any way on how to toggle it via css3  --}}
<div id="flash-msg" v-show="message" v-if="message" 
    class="notification is-success"
    role="alert"
    style="display: none;">
    <p v-text="message"></p>
</div>
<div v-else></div>