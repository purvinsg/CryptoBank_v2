<script setup>
import TextInput from "./TextInput.vue";

defineProps({
    searchOne: String,
    searchOnePlaceholder: String,
    searchTwo: String,
    searchTwoPlaceholder: String,
    startDate: String,
    endDate: String
});

const emit = defineEmits(['update:searchOne', 'update:searchTwo', 'update:startDate', 'update:endDate', 'reset']);
</script>

<template>
    <div class="pb-4 pt-4 px-4 bg-white overflow-hidden shadow-xl sm:rounded mx-auto sm:px-4 lg:px-2 flex items-center space-x-4">
        <div class="flex items-center">
            <TextInput
                id="search-one"
                :value="searchOne"
                @input="$emit('update:searchOne', $event.target.value)"
                type="text"
                class="mt-1 block"
                :placeholder="searchOnePlaceholder"
            />
        </div>
        <div class="flex items-center">
            <TextInput
                id="search-two"
                :value="searchTwo"
                @input="$emit('update:searchTwo', $event.target.value)"
                type="text"
                class="mt-1 ml-2 block"
                :placeholder="searchTwoPlaceholder"
            />
        </div>
        <div class="flex items-center">
            <TextInput
                id="start_date"
                :value="rounded-mdstartDate"
                @input="$emit('update:startDate', $event.target.value)"
                type="date"
                class="mt-1 ml-2 block"
                placeholder="Start date..."
            />
        </div>
        <div class="flex items-center">
            <TextInput
                id="end_date"
                :value="endDate"
                @input="$emit('update:endDate', $event.target.value)"
                type="date"
                class="mt-1 ml-2 block"
                placeholder="End date..."
            />
        </div>

        <div class="flex-grow"></div>

        <div>
            <button type="button" @click="$emit('reset')" class="inline-flex items-center px-5 py-2 bg-red-600 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-800 active:bg-red-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Reset</button>
        </div>
        <div class="ml-2 pb-2 pt-2 px-9 py-2"></div>


    </div>
</template>
