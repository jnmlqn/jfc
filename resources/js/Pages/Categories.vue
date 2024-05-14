<template>
    <a href="/categories/create" class="btn btn-success smallest float-end">Add new</a>

    <div>
        <h5 class="mb-3">{{ page }}</h5>

        <table class="table border">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="category in categories">
                    <td>
                        {{ category.id }}
                    </td>
                    <td>
                        {{ category.name }}
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary smallest mx-1" @click="editCategory(category.id)">
                            Edit
                        </button>
                        <button type="button" class="btn btn-danger smallest mx-1" @click="deleteCategory(category)">
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
            categories: [],
            page: 'Categories',
        };
    },

    mounted() {
        this.api.checkAuth();
        this.getCategories();
    },

    methods: {
        getCategories() {
            this.api.get('categories')
            .then((response) => {
                this.categories = response.data.data;
            })
            .catch((error) => {
                console.log(error);
            });
        },

        editCategory(id) {
            window.location = `/categories/${id}`;
        },

        deleteCategory(category) {
            if (confirm('Are you sure to delete this category?')) {
                this.api.delete(`categories/${category.id}`)
                .then((response) => {
                    this.categories.splice(
                        this.categories.indexOf(category),
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