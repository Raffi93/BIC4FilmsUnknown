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
        props: {
            currentActor: {
                required: false,
                type: Object
            }
        },
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
            this.actor = this.currentActor;
            this.film = this.currentActor.film;
        },
        methods: {
        }
    }
</script>
