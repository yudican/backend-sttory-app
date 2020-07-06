import AppForm from '../app-components/Form/AppForm';

Vue.component('licence-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                descriptions:  '' ,
                
            }
        }
    }

});