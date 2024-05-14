<template>
    <div>
        <h5 class="mb-3">{{ page }}</h5>

        <div class="p-3 smaller">
            <div class="mb-3">
                <label for="title" class="form-label">Task Name</label>
                <input type="text" class="form-control" id="name" v-model="task.name">
                <span class="text-danger smaller">{{ validation.name }}</span>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" rows="3" v-model="task.description"></textarea>
                <span class="text-danger smaller">{{ validation.description }}</span>
            </div>

            <div class="mb-3">
                <label for="peoples" class="form-label">Assign People</label>
                <h6 class="mb-1">
                    <span class="badge rounded-pill bg-primary mx-1" v-for="people in selectedPeoples">{{ people.name }}</span>
                </h6>
                <div class="row">
                    <div class="col-10">
                        <select class="form-control" id="peoples" v-model="people">
                            <option selected value="" disabled>Select people</option>
                            <option v-for="people in peoples" :value="people">
                                {{ people.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-success mb-3" @click="addPeople()">Assign people</button>
                    </div>
                </div>
                <span class="text-danger smaller">{{ validation.people_ids }}</span>
            </div>

            <div class="mb-3">
                <label for="businesses" class="form-label">Assign Business</label>
                <h6 class="mb-1">
                    <span class="badge rounded-pill bg-primary mx-1" v-for="business in selectedBusinesses">{{ business.name }}</span>
                </h6>
                <div class="row">
                    <div class="col-10">
                        <select class="form-control" id="businesses" v-model="business">
                            <option selected value="" disabled>Select business</option>
                            <option v-for="business in businesses" :value="business">
                                {{ business.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-success mb-3" @click="addBusiness()">Assign business</button>
                    </div>
                </div>
                <span class="text-danger smaller">{{ validation.business_ids }}</span>
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
            page: (this.id ? 'Update' : 'Create') + '  Task',
            success: '',
            error: '',
            api: new Api,
            peoples: [],
            selectedPeoples: [],
            people: '',
            businesses: [],
            selectedBusinesses: [],
            business: '',
            validation: {
                name: '',
                description: '',
                people_ids: '',
                business_ids: '',
            },
            task: {
                name: '',
                description: '',
                people_ids: '',
                business_ids: '',
            }
        };
    },

    mounted() {
        this.api.checkAuth();

        this.api.get('peoples')
        .then((response) => {
            this.peoples = response.data.data;
        })
        .catch((error) => {
            console.log(error);
        });

        this.api.get('businesses')
        .then((response) => {
            this.businesses = response.data.data;
        })
        .catch((error) => {
            console.log(error);
        });

        if (this.id !== null) {
            this.api.get(`tasks/${this.id}`)
            .then((response) => {
                this.task = response.data.data;
                this.selectedPeoples = response.data.data.peoples;
                this.selectedBusinesses = response.data.data.businesses;
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
                description: '',
                people_ids: '',
                business_ids: '',
            };

            this.success = '';
            this.error = '';

            this.task.people_ids = this.selectedPeoples.map(function (people) {
                return people.id;
            });

            this.task.business_ids = this.selectedBusinesses.map(function (business) {
                return business.id;
            });

            let apiRequest = null;

            if (this.id === null) {
                apiRequest = this.api.post('tasks', this.task);
            } else {
                apiRequest = this.api.put(`tasks/${this.id}`, this.task);
            }

            apiRequest
            .then((response) => {
                this.success = response.data.message;

                if (this.id === null) {
                    this.task = {
                        name: '',
                        description: '',
                        people_ids: '',
                        business_ids: '',
                    }

                    this.selectedPeoples = [];
                    this.selectedBusinesses = [];
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

        addPeople() {
            if (this.people !== '' && this.selectedPeoples.indexOf(this.people) < 0) {
                this.selectedPeoples.push(this.people);
            }
            
            this.people = '';
        },

        addBusiness() {
            if (this.business !== '' && this.selectedBusinesses.indexOf(this.business) < 0) {
                this.selectedBusinesses.push(this.business);
            }
            
            this.business = '';
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