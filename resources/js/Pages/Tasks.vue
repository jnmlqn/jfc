<template>
    <a href="/tasks/create" class="btn btn-success smallest float-end">Add new</a>

    <div>
        <h5 class="mb-3">{{ page }}</h5>

        <table class="table border">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="task in tasks">
                    <td>
                        {{ task.id }}
                    </td>
                    <td>
                        {{ task.name }}
                    </td>
                    <td>
                        {{ task.description }}
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary smallest mx-1" @click="editTask(task.id)">
                            Edit
                        </button>
                        <button type="button" class="btn btn-danger smallest mx-1" @click="deleteTask(task)">
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
            tasks: [],
            page: 'Tasks',
        };
    },

    mounted() {
        this.api.checkAuth();
        this.getTasks();
    },

    methods: {
        getTasks() {
            this.api.get('tasks')
            .then((response) => {
                this.tasks = response.data.data;
            })
            .catch((error) => {
                console.log(error);
            });
        },

        editTask(id) {
            window.location = `/tasks/${id}`;
        },

        deleteTask(task) {
            if (confirm('Are you sure to delete this task?')) {
                this.api.delete(`tasks/${task.id}`)
                .then((response) => {
                    this.tasks.splice(
                        this.tasks.indexOf(task),
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