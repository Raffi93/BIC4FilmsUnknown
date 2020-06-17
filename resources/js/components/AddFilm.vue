<template>
    <div class="container">
        <div class="content">
            <div class="field">
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
                statusErr: 0,
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
                    let data = {
                        name: this.name,
                        description: this.description
                    }
                    let form = new Form(data);
                    form.post('/film').then(value => {
                        console.log(value.message)
                        if (value.message.indexOf("Error") >= 0) {
                            alert(value.message)
                        }
                    }).catch(reason => {
                        console.log("Reason: " + reason)
                        alert(reason);
                    })
                }
                catch (e) {
                    console.log("Exc: " + e)
                }

                /*
                let name = this.name;
                let description = this.description;
                axios.post('/film', {
                    name,
                    description,
                })
                    .then(response => {
                        console.log(response)
                    })
                    .catch(error => {
                        this.statusErr = 1,
                            console.log(error, error.status)
                    });
                this.statusErr = 0;

                */
                this.name = '';
                this.description = '';
            },
        }
    }

</script>
