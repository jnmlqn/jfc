<template>
  <div>
    <h5 class="mb-3 mt-3">Please login to continue</h5>

    <p class="error text-danger">{{ error }}</p>

    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" placeholder="name@example.com" v-model="email">
        <span class="text-danger smaller">{{ validation.email }}</span>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" v-model="password">
        <span class="text-danger smaller">{{ validation.password }}</span>
    </div>

    <button type="button" class="btn btn-primary float-end" @click="login()">
        Login
    </button>

    <br/>
  </div>
</template>

<script>
import Api from '../helpers/api.ts';

export default {
    props: {
        role: String,
    },

    data() {
        return {
            api: new Api,
        };
    },

    mounted() {
        this.api.checkAuth('/', true);
    },

    data() {
        return {
            error: '',
            email: '',
            password: '',
            validation: {
                email: '',
                password: '',
            },
            api: new Api
        };
    },

    methods: {
        login() {
            this.error = '';
            this.validation.email = '';
            this.validation.password = ''

            if (!this.email.trim() || !this.email.includes('@')) {
                this.validation.email = 'Please enter a valid email address';
            }

            if (!this.password.trim()) {
                this.validation.password = 'Please enter a valid password';
            }

            if (this.validation.email !== '' || this.validation.password !== '') {
                return;
            }

            const data = {
                email: this.email,
                password: this.password,
            };

            this.api.login(data)
            .then((response) => {
                let resp = response.data;
                document.cookie = `access_token=${resp.data.token}`;
                window.location = '/';
            })
            .catch((error) => {
                console.log(error);
                this.error = error.response.data.message;
            });
        }
    }
};
</script>

<style type="text/css" scoped>
    .smaller {
        font-size: .8em;
    }
    .error {
        text-align: center;
    }
</style>