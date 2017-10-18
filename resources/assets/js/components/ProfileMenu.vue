<script>
    import { mixin as clickaway } from 'vue-clickaway';

    export default {
        name: 'profile-menu',

        mixins: [ clickaway ],

        data() {
            return {
                isActive: false
            }
        },

        methods: {
            toggle() {
                this.isActive = !this.isActive;
            },
            off() {
                this.isActive = false;
            }
        }
    }
</script>