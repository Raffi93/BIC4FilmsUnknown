<template>
    <div class="container">
        <div class="field">
            <div :class="'notification is-' + this.notificationClass" v-if="isActiveNotification">
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
                <input v-model="actor.name" class="input" type="text">
            </div>
        </div>
        <div class="field">
            <label class="label">Film</label>
            <div class="select">
                <select v-model="actor.film_id">
                    <option v-for="film in films" :value="film.id">
                        {{film.name}}
                    </option>
                </select>
            </div>
        </div>
        <div class="field">
            <label class="label">Description</label>
            <div class="control">
                <textarea v-model="actor.description" class="textarea" rows="5"/>
            </div>
        </div>
        <div class="control">
            <a href="/actor" class="button is-link">Back</a>
            <button :disabled="disabled === 1" @click="editActor(actor)" class="button is-success">Save</button>
            <button :disabled="disabled === 1" @click="openModal()" class="button is-danger">Delete</button>
        </div>
        <div class="modal" v-bind:class="{ 'is-active': isActive }">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Delete confirmation</p>
                    <button @click="closeModal()" class="delete" aria-label="close"></button>
                </header>
                <section class="modal-card-body">
                    <span>Are you sure to delete this actor?</span>
                </section>
                <footer class="modal-card-foot">
                    <div class="control">
                        <button @click="closeModal()" class="button is-success">Cancel</button>
                        <button @click="deleteActor(actor)" class="button is-danger">Confirm</button>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</template>

<script>
    import Form from "../utilities/Form";

    export default {
        data() {
            return {
                actor: {
                    id: '',
                    slug: '',
                    name: '',
                    film_id: '',
                    description: '',
                },
                films: [],
                film: {
                    id: '',
                    name: '',
                },
                isActive: false,
                errorMessage : '',
                isActiveNotification: false,
                notificationClass: '',
                disabled: 0,
                errors: [],
            }
        },
        created() {
            this.fetchActor("/actor/actorbyslug");
            this.fetchFilms("/list/film");
        },
        methods: {
            fetchFilms(uri) {
                uri = uri || '/list/film'
                fetch(uri)
                    .then(res => res.json())
                    .then(res => {
                        this.films = res;
                    })
                    .catch(err => console.log(err));
            },
            fetchActor: function (uri) {
                let data = {
                    search: location.pathname.split("/")[2]
                }
                let form = new Form(data);
                form.post(uri).then(res => {
                    this.actor = res[0];
                }).catch(error =>{
                    console.log(error);
                })
            },
            deleteActor(actor) {
                try {
                    this.errors = [];
                    this.isActiveNotification = false;
                    if (!actor.name) {
                        this.errors.push('Name required.');
                    }
                    if (!actor.description) {
                        this.errors.push('Description required.');
                    }
                    if (!actor.film_id) {
                        this.errors.push('Film required.');
                    }

                    if (this.errors.length > 0) {
                        return;
                    }

                    let data = {
                        name: actor.name,
                        description: actor.description,
                        film_id: actor.film_id
                    }
                    let form = new Form(data);
                    form.delete('/actor/' + actor.slug).then(value => {

                        if (value.message.indexOf("Error") >= 0) {
                            this.errorMessage = value.message;
                            this.isActiveNotification = true;
                            this.notificationClass = "danger";
                        } else {
                            this.closeModal();
                            this.errorMessage = value.message;
                            this.isActiveNotification = true;
                            this.notificationClass = "success";
                            actor.name = '';
                            actor.description = '';
                            actor.film_id = '';
                            this.disabled = 1;
                        }
                    }).catch(() => {
                        this.errorMessage = "Some mystic Error occurred!";
                        this.isActiveNotification = true;
                        this.notificationClass = "danger";
                    })
                } catch (e) {
                    this.errorMessage = e;
                    this.isActiveNotification = true;
                    this.notificationClass = "danger";
                }
            },
            editActor(actor) {
                try {
                    this.errors = [];
                    this.isActiveNotification = false;
                    if (!actor.name) {
                        this.errors.push('Name required.');
                    }
                    if (!actor.description) {
                        this.errors.push('Description required.');
                    }
                    if (!actor.film_id) {
                        this.errors.push('Film required.');
                    }

                    if (this.errors.length > 0) {
                        return;
                    }

                    let data = {
                        name: actor.name,
                        description: actor.description,
                        film_id: actor.film_id
                    }
                    let form = new Form(data);
                    form.put('/actor/' + actor.slug).then(res => {
                        if (res.message.indexOf("Error") >= 0) {
                            this.errorMessage = res.message;
                            this.isActiveNotification = true;
                            this.notificationClass = "danger";
                        } else {
                            this.errorMessage = res.message;
                            this.isActiveNotification = true;
                            this.notificationClass = "success";
                            this.name = '';
                            this.description = '';
                            this.film_id = '';
                        }
                    }).catch(res => {
                        this.errorMessage = "Some mystic Error occurred! Error: " + res;
                        this.isActiveNotification = true;
                        this.notificationClass = "danger";
                    })
                } catch (e) {
                    this.errorMessage = e;
                    this.isActiveNotification = true;
                    this.notificationClass = "danger";
                }
            },
            openModal() {
                this.isActive = true;
            },
            closeModal() {
                this.isActive = false;
            },
            closeNotification() {
                this.isActiveNotification = false;
            }
        }
    }
</script>
