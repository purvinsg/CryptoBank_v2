<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {useForm} from "@inertiajs/inertia-vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import NumericInput from "@/Components/NumericInput.vue";

const props = defineProps({
    accounts: Array,
    code: Number,
});

const form = useForm({
    account: '',
    recipient: '',
    amount: '',
    code: '',
});

const submit = () => {
    form.transform(data => ({
        ...data,
    })).post(route('accounts.transfer'), {
        onFinish: () => form.reset('account', 'recipient', 'amount'),
    });
};
</script>

<template>
    <AppLayout title="Overview">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Transfer money
            </h2>
        </template>
        <div class="mt-5 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="py-4 px-8 sm:px-6 lg:px-6 bg-white overflow-hidden shadow-md sm:rounded-lg overflow-x-auto">
                <p class="text-center text-gray-600">
                    Transfer funds securely and swiftly to any account, whether it's within the same bank or to external beneficiaries.
                    Simplify your financial transactions and send money with confidence,
                    knowing that your information is protected every step of the way.
                </p>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="submit" class="w-1/2 mx-auto py-8">
                        <div>
                            <InputLabel for="account" value="From account"/>
                            <SelectInput
                                id="account"
                                class="mt-1 block w-full"
                                v-model="form.account"
                                :options="accounts"
                                valueProp="number"
                                displayProp="number"
                                required
                                autofocus
                            />
                            <InputError class="mt-2" :message="form.errors.account"/>
                        </div>

                        <div class="mt-4">
                            <InputLabel for="recipient" value="Recipient account"/>
                            <TextInput
                                id="recipient"
                                v-model="form.recipient"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.recipient"/>
                        </div>

                        <div class="mt-4">
                            <InputLabel for="amount" value="Amount"/>
                            <NumericInput
                                id="amount"
                                v-model="form.amount"
                                type="number"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.amount"/>
                        </div>

                        <div class="mt-4">
                            <InputLabel for="code" :value="`Enter code number: `+ (code + 1)"/>
                            <NumericInput
                                id="amount"
                                v-model="form.code"
                                type="number"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.code"/>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                           :disabled="form.processing">
                                Transfer
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
