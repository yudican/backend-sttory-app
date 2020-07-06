import AppForm from '../app-components/Form/AppForm';

Vue.component('genre-form', {
    mixins: [AppForm],
    data: function () {
        return {
            form: {
                name: '',

            },
            mediaCollections: ['cover']
        }
    }

});