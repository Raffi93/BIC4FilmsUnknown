<template>
    <div class="container">
        <div class="content">
            <div class="field">
                <div :class="'notification is-' + this.notificationClass" v-if="isActive">
                    <button @click="closeNotification()" class="delete"></button>
                    {{this.errorMessage}}
                </div>
                <div class="notification is-danger" v-if="errors.length">
                    <b>Please correct the following error(s):</b>
                    <ul>
                        <li v-for="error in errors">{{ error }}</li>
                    </ul>
                </div>
                <label class="label">Name</label>
                <div class="control">
                    <input class="input" type="text" v-model='name' name="name">
                </div>
            </div>
            <div class="field">
                <label class="label">Film</label>
                <div class="select">
                    <select v-model="film_id" :disabled="loading">
                        <option v-if="loading" :value="film.id"> Loading...</option>
                        <option v-if="!loading" v-for="film in films" :value="film.id">
                            {{film.name}}
                        </option>
                    </select>
                </div>
            </div>
            <div class="field">
                <label class="label">Description</label>
                <div class="control">
                    <textarea class="textarea" v-model="description" rows="5"/>
                </div>
            </div>
            <div class="control">
                <button @click="addActor()" class="button is-success">Create</button>
            </div>
        </div>
    </div>

</template>

<script>

    import Form from "../utilities/Form";

    export default {
        data() {
            return {
                name: '',
                description: '',
                film_id: '',
                errorMessage : '',
                isActive: false,
                notificationClass: '',
                errors: [],
                films: [],
                film: {
                    id: '',
                    name: '',
                },
            }
        },
        created() {
            this.fetchFilms("/list/film");
        },
        methods: {
            addActor() {
                try {
                    this.errors = [];
                    this.isActive = false;
                    if (!this.name) {
                        this.errors.push('Name required.');
                    }
                    if (!this.description) {
                        this.errors.push('Description required.');
                    }
                    if (!this.film_id) {
                        this.errors.push('Film required.');
                    }

                    if (this.errors.length > 0){
                        return;
                    }

                    let data = {
                        name: this.name,
                        description: this.description,
                        film_id: this.film_id
                    }
                    let form = new Form(data);
                    form.post('/actor').then(res => {

                        if (res.message.indexOf("Error") >= 0) {
                            this.errorMessage = res.message;
                            console.log(res.error);
                            this.isActive = true;
                            this.notificationClass = "danger";
                        }
                        else {
                            this.errorMessage = res.message;
                            this.isActive = true;
                            this.notificationClass = "success";
                            this.name = '';
                            this.description = '';
                            this.film_id = '';
                        }
                    }).catch(() => {
                        this.errorMessage = "Some mystic Error occurred (I think the Backend could not handle that the slug already exist) !";
                        this.isActive = true;
                        this.notificationClass = "danger";
                    })
                }
                catch (e) {
                    this.errorMessage = e;
                    this.isActive = true;
                    this.notificationClass = "danger";
                }
            },
            fetchFilms(uri) {
                uri = uri || '/list/film'
                fetch(uri)
                    .then(res => res.json())
                    .then(res => {
                        this.films = res;
                    })
                    .catch(err => console.log(err));
            },
            closeNotification () {
                this.isActive = false;
            },
        },
        computed: {
            loading() {
                return !this.films.length
            }
        },

        watch: {
            films() {
                if (!this.loading && this.film_id === '') {
                    this.film_id = _.first(this.films).id;
                }
            }
        }
    }

</script>
