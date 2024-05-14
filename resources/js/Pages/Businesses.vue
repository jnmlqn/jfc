<template>
    <a href="/businesses/create" class="btn btn-success smallest float-end">Add new</a>

    <div>
        <h5 class="mb-3">{{ page }}</h5>

        <table class="table border">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Business Name</th>
                    <th width="25%">Tags</th>
                    <th width="25%">Categories</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="business in businesses">
                    <td>
                        {{ business.id }}
                    </td>
                    <td>
                        {{ business.name }}
                    </td>
                    <td>
                        <span class="badge rounded-pill bg-primary mx-1" v-for="tag in business.tags">{{ tag }}</span>
                    </td>
                    <td>
                        <span class="badge rounded-pill bg-primary mx-1" v-for="category in business.categories">{{ category }}</span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary smallest mx-1" @click="editBusiness(business.id)">
                            Edit
                        </button>
                        <button type="button" class="btn btn-danger smallest mx-1" @click="deleteBusiness(business)">
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
            businesses: [],
            page: 'Businesses',
        };
    },

    mounted() {
        this.api.checkAuth();
        this.getBusinesses();
    },

    methods: {
        getBusinesses() {
            this.api.get('businesses')
            .then((response) => {
                this.businesses = response.data.data;
            })
            .catch((error) => {
                console.log(error);
            });
        },

        editBusiness(id) {
            window.location = `/businesses/${id}`;
        },

        deleteBusiness(business) {
            if (confirm('Are you sure to delete this business?')) {
                this.api.delete(`businesses/${business.id}`)
                .then((response) => {
                    this.businesses.splice(
                        this.businesses.indexOf(business),
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