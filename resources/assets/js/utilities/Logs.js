/**
 * Logs Class
 */
class Logs
{
    constructor() {
        this.logs = {};
    }

    //current laravel response json structure
        //logs (obj)
        //  logs (obj)
        //    errors (obj)
        //      desc (arr)
        //      name (arr)
        //    message (str)
    has( field ) {
        // if this logs has a field errors[field], then show TRUE
        if( this.hasErrorProp() )
            return Array.isArray(this.logs.errors[field]);
        else return false;
    }

    getError( field ) {
        //if( this.hasErrorProp() === false )
        if( this.logs.errors[field] )
            return this.logs.errors[field][0];
        return false;
    }

    fetchErrors( data ) {
        this.logs = data;
    }

    clear( field = null ) {
        if( field === null )
            this.logs.errors = {};
        if( this.hasErrorProp() )
            delete this.logs.errors[ field ];
    }

    any() {
        if( this.hasErrorProp() )
            return Object.keys(this.logs.errors).length > 0;
        return false;
    }

    hasErrorProp() {
        return this.logs.hasOwnProperty('errors') === true;
    }
}

export default Logs;