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
                <label class="label">Description</label>
                <div class="control">
                    <span >{{ film.description }}</span>
                </div>
            </div>
            <div class="control">
                <a href="/film" class="button is-link">Back</a>
            </div>
        </form>
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
            }
        },
        created() {
            this.film = this.currentFilm;
        },
        methods: {
        }
    }
</script>
