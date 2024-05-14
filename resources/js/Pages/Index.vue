<template>  
    <h1>{{ greeting }}</h1>  
    
    <p><a href="/businesses">Businesses</a></p>
    <p><a href="/peoples">People</a></p>
    <p><a href="/tags">Tags</a></p>
    <p><a href="/categories">Categories</a></p>
    <p><a href="/tasks">Tasks</a></p>
</template>

<script>
import { ref } from 'vue';
import Api from '../helpers/api.ts';

export default {
    data() {
        return {
            greeting: ref('Welcome to JFC'),
            api: new Api,
        };
    },

    mounted() {
        this.api.checkAuth('/');
    },
};
</script>