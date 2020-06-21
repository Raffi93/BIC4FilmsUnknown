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
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li  v-if="pagination.prev_page_url" class="page-item">
                    <a class="pagination-previous" href="#" @click="fetchFilms(pagination.prev_page_url)">Previous</a></li>
                <li  v-else class="page-item">
                    <span>Previous</span></li>

                <li class="page-item is-disabled"><a class="page-link has-text-dark" href="#" >Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>

                <li v-if="pagination.next_page_url" class="page-item">
                    <a class="pagination-next" href="#" @click="fetchFilms(pagination.next_page_url)">Next</a></li>
                <li  v-else class="page-item">
                    <span>Next</span></li>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        props: {
            enableEdit: {
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
                pagination: {},
            }
        },
        created() {
            this.fetchFilms("/page/film");
        },
        methods: {
            fetchFilms(page_url) {
                console.log(page_url);
                let currentPage = this;
                page_url = page_url || '/page/film'
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.films = res.data;
                        currentPage.makePagination(res);
                    })
                    .catch(err => console.log(err));
            },
            makePagination(links) {
                let pagination = {
                    current_page: links.current_page,
                    last_page: links.last_page,
                    next_page_url: links.next_page_url,
                    prev_page_url: links.prev_page_url,
                    first_page_url: links.first_page_url
                };
                this.pagination = pagination;
            }
        }
    }
</script>
