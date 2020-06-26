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
                <input v-model="film.name" class="input" type="text">
            </div>
        </div>
        <div class="field">
            <label class="label">Description</label>
            <div class="control">
                <textarea v-model="film.description" class="textarea" rows="5"/>
            </div>
        </div>
        <div class="control">
            <a href="/actor" class="button is-link">Back</a>
            <button :disabled="disabled === 1" @click="editFilm(film)" class="button is-success">Save</button>
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
                    <span>Are you sure to delete this film?</span>
                </section>
                <footer class="modal-card-foot">
                    <div class="control">
                        <button @click="closeModal()" class="button is-success">Cancel</button>
                        <button @click="deleteFilm(film)" class="button is-danger">Confirm</button>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</template>

<script>
    import Form from "../utilities/Form";

    export default {
        props: {
            currentFilm: {
                required: false,
                type: Object
            }
        },
        data() {
            return {
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
            this.film = this.currentFilm;
        },
        methods: {
            deleteFilm(film) {
                try {
                    this.errors = [];
                    this.isActiveNotification = false;
                    if (!film.name) {
                        this.errors.push('Name required.');
                    }
                    if (!film.description) {
                        this.errors.push('Description required.');
                    }

                    if (this.errors.length > 0) {
                        return;
                    }

                    let data = {
                        name: film.name,
                        description: film.description
                    }
                    let form = new Form(data);
                    form.delete('/film/' + film.slug).then(value => {

                        if (value.message.indexOf("Error") >= 0) {
                            this.errorMessage = value.message;
                            this.isActiveNotification = true;
                            this.notificationClass = "danger";
                        } else {
                            this.closeModal();
                            this.errorMessage = value.message;
                            this.isActiveNotification = true;
                            this.notificationClass = "success";
                            film.name = '';
                            film.description = '';
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
            editFilm(film) {
                try {
                    this.errors = [];
                    this.isActiveNotification = false;
                    if (!film.name) {
                        this.errors.push('Name required.');
                    }
                    if (!film.description) {
                        this.errors.push('Description required.');
                    }

                    if (this.errors.length > 0) {
                        return;
                    }

                    let data = {
                        name: film.name,
                        description: film.description,
                    }
                    let form = new Form(data);
                    form.put('/film/' + film.slug).then(res => {

                        if (res.message.indexOf("Error") >= 0) {
                            this.errorMessage = res.message;
                            console.log(res.error);
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
                    }).catch(test => {
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
            openModal() {
                this.isActive = true;
            },
            closeModal() {
                this.isActive = false;
            }
        }
    }
</script>
