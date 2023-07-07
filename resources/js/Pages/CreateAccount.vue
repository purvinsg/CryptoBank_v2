<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {useForm} from "@inertiajs/inertia-vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";

const props = defineProps({
    currencies: Array,
});

const data = {
    selected: null,
};

const form = useForm({
    name: '',
    currency: 'EUR',
});

const submit = () => {
    form.transform(data => ({
        ...data,
    })).post(route('accounts.store'), {
        onFinish: () => form.reset('name', 'currency'),
    });
};
</script>

<template>
    <AppLayout title="Overview">
        <template #header>
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                Create Account
            </h2>
        </template>

        <div class="mt-5 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="py-4 px-8 sm:px-6 lg:px-6 bg-white overflow-hidden shadow-md sm:rounded-lg overflow-x-auto">
            <p class="text-center text-gray-600">
                Create an account and unlock a world of possibilities!
                Seamlessly manage your finances, track your expenses,
                invest in a wide range of cryptocurrencies, and enjoy secure transactions.
                Experience the convenience of personalized financial solutions tailored to your needs.
                Join our community today and embrace the future of banking with confidence and ease.
                Let us be your trusted partner on your journey to financial success and empowerment.
            </p>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded">
                    <form @submit.prevent="submit" class="w-1/2 mx-auto py-8">
                        <div>
                            <InputLabel for="name" value="Account Name"/>
                            <TextInput
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autofocus
                            />
                            <InputError class="mt-2" :message="form.errors.name"/>
                        </div>

                        <div class="select-wrapper mt-4">
                            <InputLabel for="currency" value="Currency"/>
                            <SelectInput
                                id="currency"
                                v-model="form.currency"
                                :options="currencies.slice(0, 10)"
                                class="mt-1 block w-full select"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.currency"/>
                        </div>

                        <div class="flex items-center justify-center mt-4">
                            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                           :disabled="form.processing">
                                Create
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
