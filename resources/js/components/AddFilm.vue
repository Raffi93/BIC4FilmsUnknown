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
                <label class="label">Description</label>
                <div class="control">
                    <textarea class="textarea" v-model="description" rows="5"/>
                </div>
            </div>
            <div class="control">
                <button @click="addFilm()" class="button is-success">Create</button>
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
        methods: {
            addFilm() {
                try {
                    this.errors = [];
                    this.isActive = false;
                    if (!this.name) {
                        this.errors.push('Name required.');
                    }
                    if (!this.description) {
                        this.errors.push('Description required.');
                    }

                    if (this.errors.length > 0){
                        return;
                    }

                    let data = {
                        name: this.name,
                        description: this.description
                    }
                    let form = new Form(data);
                    form.post('/film').then(res => {

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
            closeNotification () {
                this.isActive = false;
            },
        }
    }

</script>
