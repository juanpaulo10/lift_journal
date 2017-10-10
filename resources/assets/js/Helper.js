import Vue from 'vue';

export default Vue.extend({
    filters: {
        ucfirst(value){
            return `${value[0].toUpperCase() + value.slice(1)}`;
        }
    },

    methods: {
        postRequest(url, data){
            return axios.post(url, data);
        },
    }
});