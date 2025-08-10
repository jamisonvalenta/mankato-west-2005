<template>
    <Head title="Class of 2005 Reunion" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">


                <!-- Users -->
                <div class="relative aspect-video rounded-xl border border-sidebar-border/70">
                    <section class="overflow-hidden">
                        <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-4 py-3">
                            <BellIcon class="h-10 w-10 flex-none rounded-lg bg-white object-cover border border-gray-900/10" />
                            <div class="text-md font-medium leading-6 text-gray-900">Users</div>
                            <div class="relative ml-auto">
                                <!-- <ellipsis-menu></ellipsis-menu> -->
                            </div>
                        </div>
                        <div class="divide-y divide-gray-100">
                            <section class="px-4">
                                <dl class=" text-sm leading-6 grid grid-cols-[1fr,5em] py-4 gap-4">
                                    <dt class="text-gray-500 text-lg leading-loose">
                                        <UsersIcon
                                            class="text-gray-500 w-5 h-5 inline-block mr-2"
                                            />
                                        Total
                                    </dt>
                                    <dd class="">
                                        <Link :href="route('admin.users.index')">
                                            <span class="inline-flex items-center rounded-md bg-gray-50 px-3 py-2 text-xs font-medium text-gray-800 ring-1 ring-inset ring-gray-600/20">
                                                {{ usersCount }}
                                            </span>
                                        </Link>
                                    </dd>

                                    <dt class="text-gray-500 text-lg leading-loose">
                                        <div class="w-5 h-5 mr-2 inline-block"></div>
                                        Incomplete registrations
                                    </dt>
                                    <dd class="">
                                        <Link :href="route('admin.users.index', {filter: 'unregistered'})">
                                            <span class="inline-flex items-center rounded-md bg-gray-50 px-3 py-2 text-xs font-medium text-gray-800 ring-1 ring-inset ring-gray-600/20">
                                                {{ usersUnregisteredCount }}
                                            </span>
                                        </Link>
                                    </dd>

                                    <dt class="text-gray-500 text-lg leading-loose">
                                        <ExclamationCircleIcon
                                            v-if="usersAwaitingVerificationCount > 0"
                                            class="text-amber-500 w-5 h-5 inline-block mr-2"
                                            />
                                        <div v-else class="w-5 h-5 mr-2 inline-block"></div>
                                        Users awaiting verification
                                    </dt>
                                    <dd class="">
                                        <Link :href="route('admin.users.index', {filter: 'unverified'})">
                                            <span
                                                :class='{
                                                    "bg-yellow-50 text-yellow-800 ring-yellow-600/20": usersAwaitingVerificationCount > 0,
                                                    "bg-green-50 text-green-800 ring-green-600/20": usersAwaitingVerificationCount === 0,
                                                }'
                                            class="inline-flex items-center rounded-md  px-3 py-2 text-xs font-medium ring-1 ring-inset ">
                                                {{ usersAwaitingVerificationCount }}
                                            </span>
                                        </Link>
                                    </dd>

                                    <dt class="text-gray-500 text-lg leading-loose">
                                        <ExclamationCircleIcon
                                            v-if="usersAwaitingPaymentCount > 0"
                                            class="text-amber-500 w-5 h-5 inline-block mr-2"
                                            />
                                        <div v-else class="w-5 h-5 mr-2 inline-block"></div>
                                        Users awaiting payment
                                    </dt>
                                    <dd class="">
                                        <Link :href="route('admin.users.index', {filter: 'awaitingpayment'})">
                                            <span
                                                :class='{
                                                    "bg-yellow-50 text-yellow-800 ring-yellow-600/20": usersAwaitingPaymentCount > 0,
                                                    "bg-green-50 text-green-800 ring-green-600/20": usersAwaitingPaymentCount === 0,
                                                }'
                                            class="inline-flex items-center rounded-md  px-3 py-2 text-xs font-medium ring-1 ring-inset ">
                                                {{ usersAwaitingPaymentCount }}
                                            </span>
                                        </Link>
                                    </dd>

                                    <dt class="text-gray-500 text-lg leading-loose">
                                        <CheckCircleIcon
                                        class="text-green-500 w-5 h-5 inline-block mr-2"
                                        />
                                        # attendees (paid)
                                    </dt>
                                    <dd class="">
                                        <Link :href="route('admin.users.index', {filter: 'complete'})">
                                            <span
                                                class="bg-green-50 text-green-800 ring-green-600/20 inline-flex items-center rounded-md  px-3 py-2 text-xs font-medium ring-1 ring-inset ">
                                                {{ confirmedAttendeesCount }}
                                            </span>
                                        </Link>
                                    </dd>
                                </dl>
                            </section>
                        </div>
                    </section>
                </div>


                <!-- Financials -->
                <div class="relative aspect-video rounded-xl border border-sidebar-border/70">
                    <section class="overflow-hidden">
                        <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-4 py-3">
                            <PiggyBank class="h-10 w-10 flex-none rounded-lg bg-white object-cover border border-gray-900/10" />
                            <div class="text-md font-medium leading-6 text-gray-900">Financials</div>
                            <div class="relative ml-auto">
                                <!-- <ellipsis-menu></ellipsis-menu> -->
                            </div>
                        </div>
                        <div class="divide-y divide-gray-100">
                            <section class="px-4">
                                <dl class="text-sm leading-6 grid grid-cols-[1fr,5em] py-4 gap-4">
                                    <dt class="text-gray-500 text-lg leading-loose">
                                        <MessageCircleDashed
                                            class="text-gray-500 w-5 h-5 inline-block mr-2"
                                            />
                                        Total Promised
                                    </dt>
                                    <dd class="">
                                            <span class="inline-flex items-center rounded-md bg-gray-50 px-3 py-2 text-xs font-medium text-gray-800 ring-1 ring-inset ring-gray-600/20">
                                                ${{ paymentPromisedTotal }}
                                            </span>
                                    </dd>

                                    <dt class="text-gray-500 text-lg leading-loose">
                                        <DollarSign
                                            class="text-gray-500 w-5 h-5 inline-block mr-2"
                                            />
                                        Total Received
                                    </dt>
                                    <dd class="">
                                            <span class="inline-flex items-center rounded-md bg-gray-50 px-3 py-2 text-xs font-medium text-gray-800 ring-1 ring-inset ring-gray-600/20">
                                                ${{ paymentReceivedTotal }}
                                            </span>
                                    </dd>
                                </dl>
                            </section>
                        </div>
                    </section>
                </div>


                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70">
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { BellIcon, CheckCircleIcon, ExclamationCircleIcon, UsersIcon } from '@heroicons/vue/24/outline';
import { Baby, Camera, DollarSign, PiggyBank, UsersRound, PartyPopper, MessageCircleDashed } from 'lucide-vue-next';
import { CheckIcon } from '@heroicons/vue/24/solid';

defineProps<{
    usersCount?: number;
    usersUnregisteredCount?: number;
    usersAwaitingVerificationCount?: number;
    usersAwaitingPaymentCount?: number;
    confirmedAttendeesCount?: number;
    paymentReceivedTotal?: number;
    paymentPromisedTotal?: number;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
    },
    {
        title: 'Admin',
        href: route('admin.dashboard'),
    },
];
</script>
