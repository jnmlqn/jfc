<template>
    <a href="/peoples/create" class="btn btn-success smallest float-end">Add new</a>

    <div>
        <h5 class="mb-3">{{ page }}</h5>

        <table class="table border">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Business</th>
                    <th width="25%">Tags</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="people in peoples">
                    <td>
                        {{ people.id }}
                    </td>
                    <td>
                        {{ people.name }}
                    </td>
                    <td>
                        {{ people.business.name }}
                    </td>
                    <td>
                        <span class="badge rounded-pill bg-primary mx-1" v-for="tag in people.tags">{{ tag }}</span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary smallest mx-1" @click="editPeople(people.id)">
                            Edit
                        </button>
                        <button type="button" class="btn btn-danger smallest mx-1" @click="deletePeople(people)">
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
            peoples: [],
            page: 'Peoples',
        };
    },

    mounted() {
        this.api.checkAuth();
        this.getPeoples();
    },

    methods: {
        getPeoples() {
            this.api.get('peoples')
            .then((response) => {
                this.peoples = response.data.data;
            })
            .catch((error) => {
                console.log(error);
            });
        },

        editPeople(id) {
            window.location = `/peoples/${id}`;
        },

        deletePeople(people) {
            if (confirm('Are you sure to delete this people?')) {
                this.api.delete(`peoples/${people.id}`)
                .then((response) => {
                    this.peoples.splice(
                        this.peoples.indexOf(people),
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