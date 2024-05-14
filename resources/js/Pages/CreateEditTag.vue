<template>
    <div>
        <h5 class="mb-3">{{ page }}</h5>

        <div class="p-3 smaller">
            <div class="mb-3">
                <label for="title" class="form-label">Tag Name</label>
                <input type="text" class="form-control" id="name" v-model="tag.name">
                <span class="text-danger smaller">{{ validation.name }}</span>
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
            page: (this.id ? 'Update' : 'Create') + '  Tag',
            success: '',
            error: '',
            api: new Api,
            validation: {
                name: '',
            },
            tag: {
                name: '',
            }
        };
    },

    mounted() {
        this.api.checkAuth();

        if (this.id !== null) {
            this.api.get(`tags/${this.id}`)
            .then((response) => {
                this.tag.name = response.data.data.name;
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
            };

            this.success = '';
            this.error = '';

            let apiRequest = null;

            if (this.id === null) {
                apiRequest = this.api.post('tags', this.tag);
            } else {
                apiRequest = this.api.put(`tags/${this.id}`, this.tag);
            }

            apiRequest
            .then((response) => {
                this.success = response.data.message;

                if (this.id === null) {
                    this.tag = {
                        name: '',
                    }
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