<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'inline-flex items-center px-1 pt-1 border-b-2 border-grey-600 text-m font-bold leading-5 text-gray-900 focus:outline-black focus:border-gray-900 transition'
        : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-m font-medium leading-5 text-gray-600 hover:text-gray-700 hover:border-gray-700 focus:outline-none focus:text-gray-700 focus:border-gray-600 transition';
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
