import Logs from './Logs';

/**
 * Form Class
 */
class Form {
    constructor(oData) {
        //oData = { name: '', desc: '' }
        this.oOriginalData = oData; //pointer to original data.
        this.isLoading = false;
        this.logs = new Logs();

        //this.oOriginalData.name will become this.name
        for (let field in oData) {
            this[field] = oData[field];
        }
    }

    data() {
        let oData = {};

        /**
         * Since oOriginalData had 
            form: new Form({
                name: '',
                desc: '',
            })
            in VUE instance.

            it means {name: '', desc: ''} will be passed to ajax
         */
        for (let key in this.oOriginalData) {
            oData[key] = this[key];
        }
        console.log('Data being passed:');
        console.log(oData);

        return oData;
    }

    post(sUrl) {
        return this.submit('post', sUrl); //returns a promise
    }

    reset( callback = null ) {
        this.logs.clear();

        if ( callback ) { //perform callback instead of default
            callback();
            return;
        }
        //clearing of fields //default
        for (let field in this.oOriginalData) {
            this[field] = '';
        }
    }

    //can also have post(sUrl) => submit('POST', sUrl))
    submit(sRequestType, sUrl, oData = null) {
        console.log('submitting. data below:');
        console.log( this.data() );
        this.isLoading = true;
        return new Promise( (resolve, reject) => {
            axios[sRequestType]( sUrl, oData ? oData : this.data() )
                .then( (response) => {
                    this.onSuccess(response); //trigger your default onSuccess

                    resolve(response); //use form.submit(...).then( yourcallback )
                }).catch( (error) => {
                    this.onFail(error);
                    
                    reject(error);
                });
        });

        //axios.post / .patch , etc
        // axios[sRequestType]( sUrl, this.data() )
        //     .then( this.onSuccess.bind(this) )
        //     .catch( this.onFail.bind(this) );
    }

    onSuccess(response) {
        //TEMPORARY, do not store your code here since it should be dynamic
        //the "this" keyword is bound NOT on Form Class (needs .bind(this))
        console.log('onSuccess');

        //this.reset();
        this.isLoading = false;
    }

    onFail(error) {
        console.log('onFail');
        this.logs.fetchErrors(error.response.data);
        this.isLoading = false;
    }

}

export default Form;