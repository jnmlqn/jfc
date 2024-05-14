<template>
    <div>
        <h5 class="mb-3">{{ page }}</h5>

        <div class="p-3 smaller">
            <div class="mb-3">
                <label for="title" class="form-label">People Name</label>
                <input type="text" class="form-control" id="name" v-model="people.name">
                <span class="text-danger smaller">{{ validation.name }}</span>
            </div>

            <div class="mb-3">
                <label for="business_id" class="form-label">Business</label>
                <select class="form-control" id="business_id" v-model="people.business_id">
                    <option selected value="" disabled>Select business</option>
                    <option v-for="business in businesses" :value="business.id">
                        {{ business.name }}
                    </option>
                </select>
                <span class="text-danger smaller">{{ validation.business_id }}</span>
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

            <div class="mb-3" v-if="id !== null">
                <label for="tasks" class="form-label">Assigned Tasks</label>
                <ul>
                    <li v-for="task in people.tasks">{{ task.name }}</li>
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
            page: (this.id ? 'Update' : 'Create') + '  People',
            success: '',
            error: '',
            api: new Api,
            businesses: [],
            tags: [],
            selectedTags: [],
            tag: '',
            validation: {
                name: '',
                business_id: '',
                tag_ids: '',
            },
            people: {
                name: '',
                business_id: '',
                tag_ids: '',
            }
        };
    },

    mounted() {
        this.api.checkAuth();

        this.api.get('businesses')
        .then((response) => {
            this.businesses = response.data.data;
        })
        .catch((error) => {
            console.log(error);
        });

        this.api.get('tags')
        .then((response) => {
            this.tags = response.data.data;
        })
        .catch((error) => {
            console.log(error);
        });

        if (this.id !== null) {
            this.api.get(`peoples/${this.id}`)
            .then((response) => {
                this.people = response.data.data;
                this.selectedTags = response.data.data.tags
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
                business_id: '',
                tag_ids: '',
            };

            this.success = '';
            this.error = '';
            this.people.tag_ids = this.selectedTags.map(function (tag) {
                return tag.id;
            });

            let apiRequest = null;

            if (this.id === null) {
                apiRequest = this.api.post('peoples', this.people);
            } else {
                apiRequest = this.api.put(`peoples/${this.id}`, this.people);
            }

            apiRequest
            .then((response) => {
                this.success = response.data.message;

                if (this.id === null) {
                    this.people = {
                        name: '',
                        business_id: '',
                        tag_ids: '',
                    }

                    this.selectedTags = [];
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
        }
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