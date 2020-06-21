<template>
    <div class="container">
        <form>
            <div class="field">
                <label class="label">Name</label>
                <div class="control">
                    <span>{{ actor.name }}</span>
                </div>
            </div>
            <div class="field">
                <label class="label">Slug</label>
                <div class="control">
                    <span>{{ actor.slug }}</span>
                </div>
            </div>
            <div class="field">
                <label class="label">Film</label>
                <span>{{ film.name }}</span>
            </div>
            <div class="field">
                <label class="label">Description</label>
                <div class="control">
                    <span>{{ actor.description }}</span>
                </div>
            </div>
            <div class="control">
                <a href="/actor" class="button is-link">Back</a>
            </div>
        </form>
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
                film: {
                    id: '',
                    name: '',
                },
            }
        },
        created() {
            this.fetchActor("/actor/actorbyslug");
        },
        methods: {
            fetchActor: function (uri) {
                let data = {
                    search: location.pathname.split("/")[2]
                }
                let form = new Form(data);
                form.post(uri).then(res => {
                    this.actor = res[0];
                    this.film = res[0].film;
                }).catch(error =>{
                    console.log(error);
                })
            },
        }
    }
</script>
