<template>
    <a href="/tags/create" class="btn btn-success smallest float-end">Add new</a>

    <div>
        <h5 class="mb-3">{{ page }}</h5>

        <table class="table border">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tag Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="tag in tags">
                    <td>
                        {{ tag.id }}
                    </td>
                    <td>
                        {{ tag.name }}
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary smallest mx-1" @click="editTag(tag.id)">
                            Edit
                        </button>
                        <button type="button" class="btn btn-danger smallest mx-1" @click="deleteTag(tag)">
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import Api from '../helpers/api.ts';

export default {
    data() {
        return {
            api: new Api,
            tags: [],
            page: 'Tags',
        };
    },

    mounted() {
        this.api.checkAuth();
        this.getTags();
    },

    methods: {
        getTags() {
            this.api.get('tags')
            .then((response) => {
                this.tags = response.data.data;
            })
            .catch((error) => {
                console.log(error);
            });
        },

        editTag(id) {
            window.location = `/tags/${id}`;
        },

        deleteTag(tag) {
            if (confirm('Are you sure to delete this tag?')) {
                this.api.delete(`tags/${tag.id}`)
                .then((response) => {
                    this.tags.splice(
                        this.tags.indexOf(tag),
                        1
                    );
                })
                .catch((error) => {
                    console.log(error);
                });
            }
        },
    },
};
</script>

<style type="text/css" scoped>
    .smaller {
        font-size: .9em;
    }
    .smallest {
        font-size: .8em;
    }
    td {
        vertical-align: middle;
    }
</style>