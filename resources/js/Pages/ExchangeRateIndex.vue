<template>
    <AppLayout title="Exchange Rates">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Exchange Rates
            </h2>
        </template>
        <div class="mt-5 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="py-4 px-8 sm:px-6 lg:px-6 bg-white overflow-hidden shadow-md sm:rounded-lg overflow-x-auto">
                <p class="text-center text-gray-600">
                    Stay up-to-date with the latest exchange rates for different currencies. Explore the current rates
                    and compare them across various currencies.
                </p>
            </div>
        </div>
        <div class="py-5">
            <div class="mt-5 max-w-7xl mx-auto sm:px-6 lg:px-8">


                <div class="mt-5 max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                        <tr class="text-left font-medium">
                            <th class="pb-4 pt-6 px-6">Currency</th>
                            <th class="pb-4 pt-6 px-6">Exchange Rate</th>
                            <th class="pb-4 pt-6 px-6">Updated At</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(rate, index) in exchangeRates" :key="rate.id"
                            class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t">
                  <span class="flex items-center px-6 py-4">
                    {{ rate.symbol }}
                  </span>
                            </td>
                            <td class="border-t">
                  <span class="flex items-center px-6 py-4">
                    {{ formatMoney(rate.rate) }} EUR
                  </span>
                            </td>
                            <td class="border-t">
                                <span class="flex items-center px-6 py-4">
                     {{ formatDate(rate.updated_at) }}
                    </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {formatMoney} from "@/helpers";
import {reactive} from "vue";
import moment from 'moment';


const props = defineProps({
    exchangeRates: Array,
});

const searchForm = reactive({
    search: '',
    error: '',
});
const formatDate = (date) => {
    return moment(date).format('YYYY-MM-DD HH:mm:ss');
};

</script>
