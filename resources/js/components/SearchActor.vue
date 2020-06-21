<template>
    <div class="container">
        <div class="content">
            <div class="field">
                <label class="label">Name</label>
                <div class="control">
                    <input class="input" @keyup="searchActorKeyPressed()" v-on:keyup.enter="searchActor()" type="text"
                           v-model='q' placeholder="Actor Name">
                </div>
            </div>
            <div class="field">
                <label class="label">immediately search</label>
                <label class="checkbox"><input v-model='immSearch' value="1" type="checkbox"></label>
            </div>
            <div class="field">
                <div class="control">
                    <button @click="searchActor()" class="button is-success">Search</button>
                </div>
            </div>
            <div class="field">
                <label class="label">Result</label>
                <div class="control" v-if="actors.length > 0">
                    <div class="list is-hoverable">
                        <span v-for="actor in actors" class="list-item">{{ actor.name }}</span>
                    </div>
                </div>
                <div class="control" v-if="actors.length == 0">
                    {{nonFound}}
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import Form from "../utilities/Form";

    export default {
        data() {
            return {
                actors: [],
                actor: {
                    id: '',
                    slug: '',
                    name: '',
                    description: '',
                },
                q: '',
                nonFound: '',
                immSearch: '',
            }
        },
        created() {
        },
        methods: {
            searchActor() {
                let q = this.q;
                if (q === "") {
                    if (this.actors.length === 0) {
                        alert("Name can not be empty!");
                    }
                    this.actors = [];
                } else {
                    let data = {
                        q: q
                    }
                    let form = new Form(data);
                    form.post('/search/actor')
                        .then(res => {
                            if (res.length === 0) {
                                this.actors = [];
                                this.nonFound = "None Found";
                            } else {
                                this.actors = res;
                                this.nonFound = "";
                            }
                        })
                        .catch(error => {
                            this.statusErr = 1,
                                console.log(error, error.status)
                        });
                }
            },
            searchActorKeyPressed() {
                if (this.immSearch !== true) {
                    return;
                }
                let q = this.q;
                if (q === "") {
                    this.actors = [];
                } else {
                    let data = {
                        q: q
                    }
                    let form = new Form(data);
                    form.post('/search/actor')
                        .then(res => {
                            if (res.length === 0) {
                                this.actors = [];
                                this.nonFound = "None Found";
                            } else {
                                this.actors = res;
                                this.nonFound = "";
                            }
                        })
                        .catch(error => {
                            this.statusErr = 1,
                                console.log(error, error.status)
                        });
                }
            }
        }
    }

</script>
