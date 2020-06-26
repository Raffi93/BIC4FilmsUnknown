<template>
    <div class="container">
        <div class="list is-hoverable" style="margin-top: 10px;">
            <span v-for="actor in actors" class="list-item">
                <span v-if="enableShow">
                    <a :href="'actor/' + actor.slug" title="Show">{{ actor.name }}</a>
                </span>
                <span v-else>
                    {{ actor.name }}
                </span>
                <a v-if="enableEdit" :href="'actor/' + actor.slug + '/edit'" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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
                actors: [],
                actor: {
                    id: '',
                    slug: '',
                    name: '',
                    description: '',
                },
            }
        },
        created() {
            this.actors = this.currentList;
        },
        methods: {
        }
    }
</script>
