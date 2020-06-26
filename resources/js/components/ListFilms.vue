<template>
    <div class="container">
        <div class="list is-hoverable" style="margin-top: 10px;">
            <span v-for="film in films" class="list-item">
                <span v-if="enableShow">
                    <a :href="'film/' + film.slug" title="Show">{{ film.name }}</a>
                </span>
                <span v-else>
                    {{ film.name }}
                </span>
                <a v-if="enableEdit" :href="'film/' + film.slug + '/edit'" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            currentList: {
                required: false,
                type: Object
            },
            enableEdit : {
                type: Boolean
            },
            enableShow: {
                type: Boolean
            }
        },
        data() {
            return {
                films: [],
                film: {
                    id: '',
                    slug: '',
                    name: '',
                    description: '',
                },
            }
        },
        created() {
            //this.fetchFilms("/list/film");
            this.films = this.currentList;
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
            }
        }
    }
</script>
