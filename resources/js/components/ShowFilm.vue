<template>
    <div class="container">
        <form>
            <div class="field">
                <label class="label">Name</label>
                <div class="control">
                    <span>{{ film.name }}</span>
                </div>
            </div>
            <div class="field">
                <label class="label">Slug</label>
                <div class="control">
                    <span>{{ film.slug }}</span>
                </div>
            </div>
            <div class="field">
                <label class="label">Description</label>
                <div class="control">
                    <span >{{ film.description }}</span>
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
                film: {
                    id: '',
                    name: '',
                },
            }
        },
        created() {
            this.fetchFilm("/film/filmbyslug");
        },
        methods: {
            fetchFilm: function (uri) {
                let data = {
                    search: location.pathname.split("/")[2]
                }
                let form = new Form(data);
                form.post(uri).then(res => {
                    this.film = res[0];
                }).catch(error =>{
                    console.log(error);
                })
            },
        }
    }
</script>
