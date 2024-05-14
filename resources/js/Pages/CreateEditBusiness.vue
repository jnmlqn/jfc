<template>
    <div>
        <h5 class="mb-3">{{ page }}</h5>

        <div class="p-3 smaller">
            <div class="mb-3">
                <label for="title" class="form-label">Business Name</label>
                <input type="text" class="form-control" id="name" v-model="business.name">
                <span class="text-danger smaller">{{ validation.name }}</span>
            </div>

            <div class="mb-3">
                <label for="tags" class="form-label">Tags</label>
                <h6 class="mb-1">
                    <span class="badge rounded-pill bg-primary mx-1" v-for="tag in selectedTags">{{ tag.name }}</span>
                </h6>
                <div class="row">
                    <div class="col-10">
                        <select class="form-control" id="tags" v-model="tag">
                            <option selected value="" disabled>Select tags</option>
                            <option v-for="tag in tags" :value="tag">
                                {{ tag.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-success mb-3" @click="addTag()">Add Tag</button>
                    </div>
                </div>
                <span class="text-danger smaller">{{ validation.tag_ids }}</span>
            </div>

            <div class="mb-3">
                <label for="categories" class="form-label">Categories</label>
                <h6 class="mb-1">
                    <span class="badge rounded-pill bg-primary mx-1" v-for="category in selectedCategories">{{ category.name }}</span>
                </h6>
                <div class="row">
                    <div class="col-10">
                        <select class="form-control" id="categories" v-model="category">
                            <option selected value="" disabled>Select categories</option>
                            <option v-for="category in categories" :value="category">
                                {{ category.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-success mb-3" @click="addCategory()">Add Category</button>
                    </div>
                </div>
                <span class="text-danger smaller">{{ validation.category_ids }}</span>
            </div>

            <div class="mb-3" v-if="id !== null">
                <label for="tasks" class="form-label">Assigned Tasks</label>
                <ul>
                    <li v-for="task in business.tasks">{{ task.name }}</li>
                </ul>
            </div>

            <p class="success text-success">
                {{ success }}
            </p>

            <p class="error text-danger">
                {{ error }}
            </p>

            <button type="button" class="btn btn-primary float-end smaller" @click="save()">
                {{ id === null ? 'Create' : 'Save' }}
            </button>
        </div>
    </div>
</template>

<script>
import Api from '../helpers/api.ts';

export default {
    props:{
        id: {
            type: [Number, null],
            default: null,
        }
    },

    data() {
        return {
            page: (this.id ? 'Update' : 'Create') + ' Business',
            success: '',
            error: '',
            api: new Api,
            tags: [],
            categories: [],
            selectedTags: [],
            selectedCategories: [],
            tag: '',
            category: '',
            validation: {
                name: '',
                tag_ids: '',
                category_ids: '',
            },
            business: {
                name: '',
                tag_ids: '',
                category_ids: '',
            }
        };
    },

    mounted() {        
        this.api.checkAuth();

        this.api.get('tags')
        .then((response) => {
            this.tags = response.data.data;
        })
        .catch((error) => {
            console.log(error);
        });

        this.api.get('categories')
        .then((response) => {
            this.categories = response.data.data;
        })
        .catch((error) => {
            console.log(error);
        });

        if (this.id !== null) {
            this.api.get(`businesses/${this.id}`)
            .then((response) => {
                this.business.name = response.data.data.name;
                this.business.tasks = response.data.data.tasks;
                this.selectedTags = response.data.data.tags;
                this.selectedCategories = response.data.data.categories;
            })
            .catch((error) => {
                console.log(error);
            });
        }
    },

    methods: {
        save() {
            this.validation = {
                name: '',
                tag_ids: '',
                category_ids: '',
            };

            this.success = '';
            this.error = '';
            this.business.tag_ids = this.selectedTags.map(function (tag) {
                return tag.id;
            });
            this.business.category_ids = this.selectedCategories.map(function (category) {
                return category.id;
            });

            let apiRequest = null;

            if (this.id === null) {
                apiRequest = this.api.post('businesses', this.business);
            } else {
                apiRequest = this.api.put(`businesses/${this.id}`, this.business);
            }

            apiRequest
            .then((response) => {
                this.success = response.data.message;

                if (this.id === null) {
                    this.business = {
                        name: '',
                        tag_ids: '',
                        category_ids: '',
                    }

                    this.selectedTags = [];
                    this.selectedCategories = [];
                }
            })
            .catch((error) => {
                if (error.response.status === 422) {
                    const errorMessages = error.response.data.data.errors;

                    console.log(errorMessages);

                    for (const [key, value] of Object.entries(errorMessages)) {
                        this.validation[key] = value.join(', ');
                    }
                } else {
                    this.error = error.response.message;
                }
            });
        },

        addTag() {
            if (this.tag !== '' && this.selectedTags.indexOf(this.tag) < 0) {
                this.selectedTags.push(this.tag);
            }
            
            this.tag = '';
        },

        addCategory() {
            if (this.category !== '' && this.selectedCategories.indexOf(this.category) < 0) {
                this.selectedCategories.push(this.category);
            }
            
            this.category = '';
        },
    },
};
</script>

<style type="text/css" scoped>
    .smaller {
        font-size: .9em;
    }
    .success, .error {
        text-align: center;
    }
</style>