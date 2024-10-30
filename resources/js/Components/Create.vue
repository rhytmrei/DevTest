<template>
    <div class="container mx-auto">
        <router-link to="/" class="border border-gray-200 font-bold py-2 px-4 rounded">
            Back
        </router-link>
        <h1 class="text-2xl font-bold my-4">Create Deal and Account</h1>
        <form @submit.prevent="submitForm" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">

            <div v-if="validationErrors.length" class="mb-4 text-red-800 rounded-lg bg-red-50" role="alert">
                <ul>
                    <li v-for="(error, index) in validationErrors" :key="index">{{ error }}</li>
                </ul>
            </div>

            <!-- Deal fields -->
            <div class="mb-4">
                <label for="deal_name" class="block text-gray-700 text-sm font-bold mb-2">Deal name</label>
                <input type="text" v-model="deal.Deal_Name" id="deal_name" class="border rounded w-full py-2 px-3 leading-tight">
            </div>

            <div class="mb-4">
                <label for="deal_stage" class="block text-gray-700 text-sm font-bold mb-2">Deal stage</label>
                <input type="text" v-model="deal.Stage" id="deal_stage" class="border rounded w-full py-2 px-3 leading-tight">
            </div>

            <hr/>

            <!-- Account fields -->
            <div class="mb-4">
                <label for="account_name" class="block text-gray-700 text-sm font-bold mb-2">Account name</label>
                <input type="text" v-model="account.Account_Name" id="account_name" class="border rounded w-full py-2 px-3 leading-tight">
            </div>

            <div class="mb-4">
                <label for="account_website" class="block text-gray-700 text-sm font-bold mb-2">Account website</label>
                <input type="text" v-model="account.Account_Website" id="account_website" class="border rounded w-full py-2 px-3 leading-tight">
            </div>

            <div class="mb-4">
                <label for="account_phone" class="block text-gray-700 text-sm font-bold mb-2">Account phone</label>
                <input type="text" v-model="account.Account_Phone" id="account_phone" class="border rounded w-full py-2 px-3 leading-tight">
            </div>

            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">Create</button>
        </form>
    </div>
</template>

<script>
import axios from "axios";
import { mapActions } from 'vuex';

export default {
    data() {
        return {
            account: {
                Account_Name: '',
                Account_Website: '',
                Account_Phone: '',
            },
            deal: {
                Deal_Name: '',
                Stage: '',
            },
            validationErrors: {}
        };
    },
    methods: {
        ...mapActions(['setSuccessMessage']),
        submitForm() {
            const formData = {
                account: this.account,
                deal: this.deal
            };
            axios.post('/create', formData)
                .then(response => {
                    if (response.data.status === 'success') {
                        this.setSuccessMessage('Deal and account were created successfully!');
                        this.$router.push('/');
                    }
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        this.validationErrors = Object.values(error.response.data.errors).flat();
                    } else {
                        this.validationErrors = {message: error.response.data.message}
                    }
                });
        }
    }
};
</script>
