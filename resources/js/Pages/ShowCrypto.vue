<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Inertia} from "@inertiajs/inertia";
import {useForm} from "@inertiajs/inertia-vue3";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import SelectInput from "@/Components/SelectInput.vue";
import NumericInput from "@/Components/NumericInput.vue";
import BuyButton from "@/Components/BuyButton.vue";
import SellButton from "@/Components/SellButton.vue";
import {formatMoney} from "@/helpers";

const props = defineProps({
    crypto: Object,
    accounts: Array,
    accountsWithCrypto: Array,
});

const buyForm = useForm({
    account: '',
    amount: null,
});

const sellForm = useForm({
    account: '',
    amount: null,
});

const submitBuyForm = () => {
    buyForm.transform(data => ({
        ...data,
    })).post(route('crypto.buy', props.crypto.id), {
        onFinish: () => buyForm.reset('account', 'amount'),
    });
};

const submitSellForm = () => {
    sellForm.transform(data => ({
        ...data,
    })).post(route('crypto.sell', props.crypto.id), {
        onFinish: () => sellForm.reset('account', 'amount'),
    });
};

const onAccountChange = (event) => {
    const currency = event.target.options[event.target.selectedIndex].text.split(' ')[1];

    Inertia.get(route('crypto.show', {id: props.crypto.id}), {
        currency: currency,
    }, {
        preserveState: true,
        preserveScroll: true,
        only: ['crypto'],
    });
};

const onSellAccountChange = (event) => {
    const accountNumber = event.target.value;
    sellForm.amount = props.accountsWithCrypto.find(account => account.number === accountNumber)
        .cryptos.find(crypto => +crypto.crypto_id === props.crypto.id).amount;
};
</script>

<template>
    <AppLayout v-bind:title="crypto.name">
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
            <div class="mt-2 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg flex items-center flex-col">
                    <div class="flex items-center py-8">
                        <img v-bind:src="crypto.logo" alt={{crypto.name}} width="60" class="rounded">
                        <div class="flex flex-col-reverse items-end">
                            <span class="ml-2 font-bold text-3xl">{{ crypto.name }}</span>

                        </div>
                        <div class="flex flex-col-reverse items-end">

                            <span class="ml-2 font-semibold bg-gray-300 text-gray-800 rounded px-3 py-1 text-xs">
                                {{ crypto.symbol }}
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="flex font-bold text-2xl mb-4">
                            <span class="mr-2">Price:</span>
                            <span class="">{{ formatMoney(crypto.price, crypto.currency) }}</span>
                        </div>
                        <div>
                            <div class="flex mb-2 justify-between">
                                <span class="font-bold text-xl mr-4">Percent change 1h %:</span>
                                <span v-if="crypto.percentChange1h < 0" class="text-red-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                          <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                        </svg>
                                        {{ crypto.percentChange1h.toFixed(2) }}%
                                </span>
                                <span v-else class="text-green-500 flex items-center">
                                    <!-- svg chevron up direction-->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                      <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
                                    </svg>
                                    +{{ crypto.percentChange1h.toFixed(2) }}%
                                </span>
                            </div>
                            <div class="flex mb-2 justify-between">
                                <span class="font-bold text-xl mr-4">Percent change 24h %:</span>
                                <span v-if="crypto.percentChange24h < 0" class="text-red-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                          <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                        </svg>
                                        {{ crypto.percentChange24h.toFixed(2) }}%
                                </span>
                                <span v-else class="text-green-500 flex items-center">
                                    <!-- svg chevron up direction-->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                      <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
                                    </svg>
                                    +{{ crypto.percentChange24h.toFixed(2) }}%
                                </span>
                            </div>
                            <div class="flex mb-2 justify-between">
                                <span class="font-bold text-xl mr-4">Percent change 7d %:</span>
                                <span v-if="crypto.percentChange7d < 0" class="text-red-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                          <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                        </svg>
                                        {{ crypto.percentChange7d.toFixed(2) }}%
                                </span>
                                <span v-else class="text-green-500 flex items-center">
                                    <!-- svg chevron up direction-->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                      <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.5 15.75l7.5-7.5 7.5 7.5"/>
                                    </svg>
                                    +{{ crypto.percentChange7d.toFixed(2) }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="pb-4 pt-4 px-4 bg-white overflow-hidden shadow-xl sm:rounded mx-auto sm:px-4 lg:px-2">
                    <form @submit.prevent="submitBuyForm" class="flex items-center justify-center space-x-10">
                        <div>
                            <InputLabel for="account" value="Select account" />
                            <SelectInput
                                id="account"
                                v-model="buyForm.account"
                                :options="accounts"
                                valueProp="number"
                                displayProp="name"
                                @change="onAccountChange($event)"
                                class="mt-1 block"
                                required
                            />
                            <InputError class="mt-2" :message="buyForm.errors.account" />
                        </div>

                        <div>
                            <InputLabel for="amount" value="Amount" />
                            <NumericInput
                                id="amount"
                                v-model="buyForm.amount"
                                type="number"
                                class="mt-1 block"
                                required
                            />
                            <InputError class="mt-2" :message="buyForm.errors.amount" />
                        </div>

                        <div class="mt-6">
                            <BuyButton :class="{ 'opacity-25': buyForm.processing }" :disabled="buyForm.processing">
                                Buy
                            </BuyButton>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-5 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="pb-4 pt-4 px-4 bg-white overflow-hidden shadow-xl sm:rounded mx-auto sm:px-4 lg:px-2">
                    <form @submit.prevent="submitSellForm" class="flex items-center justify-center space-x-10">
                        <div>
                            <InputLabel for="sell-account" value="Select account" />
                            <SelectInput
                                id="sell-account"
                                v-model="sellForm.account"
                                :options="accountsWithCrypto"
                                @change="onSellAccountChange($event)"
                                valueProp="number"
                                displayProp="name"
                                class="mt-1 block"
                                required
                            />
                            <InputError class="mt-2" :message="sellForm.errors.account" />
                        </div>

                        <div>
                            <InputLabel for="sell-amount" value="Amount" />
                            <NumericInput
                                id="sell-amount"
                                v-model="sellForm.amount"
                                type="number"
                                class="mt-1 block"
                                required
                            />
                            <InputError class="mt-2" :message="sellForm.errors.amount" />
                        </div>

                        <div class="mt-6">
                            <SellButton :class="{ 'opacity-25': sellForm.processing }" :disabled="sellForm.processing">
                                Sell
                            </SellButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
