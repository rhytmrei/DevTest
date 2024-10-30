<template>
    <div class="container mx-auto">
        <div v-if="successMessage" class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ successMessage }}
        </div>
        <div class="flex justify-between items-center mb-4">

            <h1 class="text-2xl font-bold">Deals</h1>
            <router-link
                to="/create"
                class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">
                Create
            </router-link>
        </div>
        <table class="min-w-full bg-white">
            <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Deal Name</th>
                <th class="py-2 px-4 border-b">Stages</th>
                <th class="py-2 px-4 border-b">Account Name</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="deal in deals" :key="deal.id">
                <td class="py-2 px-4 border-b">{{ deal.id }}</td>
                <td class="py-2 px-4 border-b">{{ deal.Deal_Name }}</td>
                <td class="py-2 px-4 border-b">{{ deal.Stage }}</td>
                <td class="py-2 px-4 border-b">{{ deal.Account_Name.name }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from 'vuex';

export default {
    data() {
        return {
            deals: [],
        };
    },
    computed: {
        ...mapGetters(['successMessage'])
    },
    mounted() {
        this.fetchDeals();
        console.log("Component mounted.");
    },
    methods: {
        async fetchDeals() {
            try {
                const response = await axios.get('/deals');
                this.deals = response.data;
            } catch (error) {
                console.error('Error:', error);
            }
        },
    },
};
</script>
