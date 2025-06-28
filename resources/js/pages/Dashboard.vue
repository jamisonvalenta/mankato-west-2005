<template>
    <Head title="Class of 2005 Reunion" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-2 xl:grid-cols-3">
                <div class="relative aspect-video rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <section class="overflow-hidden">
                        <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-4 py-3">
                            <BellIcon class="h-10 w-10 flex-none rounded-lg bg-white object-cover border border-gray-900/10" />
                            <div class="text-md font-medium leading-6 text-gray-900">
                                Your Tasks
                            </div>
                            <div class="relative ml-auto">
                                <!-- <ellipsis-menu></ellipsis-menu> -->
                            </div>
                        </div>
                        <div class="divide-y divide-gray-100">
                            <section class="px-4">
                                <dl class="divide-y divide-gray-100 text-sm leading-6">
                                    <div class="grid grid-cols-[1fr,10em] py-4 gap-4">
                                        <dt class="text-gray-500 text-lg leading-loose">
                                            <CheckCircleIcon
                                                v-if="registration"
                                                class="text-green-500 w-5 h-5 inline-block mr-2"
                                                />
                                            <div v-else class="w-5 h-5 mr-2 inline-block"></div>
                                            Class Registration
                                        </dt>
                                        <dd class="text-gray-700">

                                                <Link
                                                    v-if="! registration"
                                                    :href="route('registration.create')">
                                                    <Button
                                                        variant="default"
                                                        size="default"
                                                        class="mr-2 hover:bg-gray-600"
                                                        >

                                                        Begin
                                                    </Button>
                                                </Link>

                                                <TextLink
                                                    v-else
                                                    :href="route('registration.edit', registration)"
                                                    class="leading-9 text-gray-600 hover:text-black "
                                                    >
                                                    edit
                                                </TextLink>
                                        </dd>

                                        <dt class="text-gray-500 text-lg leading-loose">
                                            <CheckCircleIcon
                                                v-if="verified"
                                                class="text-green-500 w-5 h-5 inline-block mr-2"
                                                />

                                            <ClockIcon
                                                v-else-if="! verified && registration"
                                                class="text-amber-500 w-5 h-5 inline-block mr-4"
                                                />
                                            <div v-else class="w-5 h-5 mr-2 inline-block"></div>
                                            Verification
                                        </dt>
                                        <dd class="text-gray-700 pt-3">

                                                <Pill v-if="! verified && registration" variant="amber">
                                                    Pending Approval
                                                </Pill>

                                        </dd>

                                        <dt class="text-gray-500 text-lg leading-loose">
                                            <CheckCircleIcon
                                                v-if="attendeesFilled && verified && registration"
                                                class="text-green-500 w-5 h-5 inline-block mr-2"
                                                />
                                            <div v-else class="w-5 h-5 mr-2 inline-block"></div>
                                            Reunion Registration
                                        </dt>
                                        <dd class="text-gray-700">
                                            <Link
                                                v-if="verified"
                                                :href="route('attendee.index')"
                                                >
                                                <Button
                                                    v-if="! attendeesFilled"
                                                    variant="default"
                                                    size="default"
                                                    class="mr-2 hover:bg-gray-600"
                                                    >

                                                    Add Attendees
                                                </Button>

                                                <TextLink v-else
                                                    :href="route('attendee.index')"
                                                    class="leading-9 text-gray-600 hover:text-black "
                                                    >
                                                    edit {{ attendeeCount }} attendees
                                                </TextLink>
                                            </Link>
                                        </dd>

                                        <dt class="text-gray-500 text-lg leading-loose">
                                            <CheckCircleIcon
                                                v-if="payment && payment?.received_at" class="text-green-500 w-5 h-5 inline-block mr-4"
                                                />
                                            <ClockIcon
                                                v-else-if="payment && ! payment.received_at"
                                                class="text-amber-500 w-5 h-5 inline-block mr-4"
                                                />
                                            <div v-else class="w-5 h-5 mr-2 inline-block"></div>
                                            Payment
                                        </dt>
                                        <dd class="text-gray-700">
                                            <div v-if="attendeesFilled && verified && registration">
                                                <Link
                                                    v-if="attendeesFilled && ! payment"
                                                    :href="route('payments.index')">
                                                    <Button
                                                        variant="default"
                                                        size="default"
                                                        class="mr-2 hover:bg-gray-600"
                                                        >

                                                        Pay Now
                                                    </Button>
                                                </Link>

                                                <div v-else
                                                    :href="route('payments.index')"
                                                    class="leading-9 text-gray-600 hover:text-black "
                                                    >
                                                    <Pill v-if="payment?.received_at" variant="green">
                                                        Received ${{ payment.amount }}
                                                    </Pill>
                                                    <Pill v-else variant="amber">
                                                        Not Received
                                                    </Pill>
                                                </div>

                                            </div>
                                        </dd>

                                    </div>
                                </dl>
                                <div v-if="payment?.received_at" class="w-full grid grid-cols-1 justify-center gap-4 text-center my-4">
                                    <div>
                                        <StarIcon class="text-yellow-500 w-6 h-6 inline-block mx-4 -mt-2"/>
                                        <span class="text-lg text-gray-500 inline-block variant-smallcaps leading-loose">
                                            Registration Complete
                                        </span>
                                        <StarIcon class="text-yellow-500 w-6 h-6 inline-block mx-4 -mt-2"/>
                                    </div>

                                    <span class="text-gray-500">
                                        Check back occasionally as we continue to add information and features!
                                    </span>
                                </div>
                            </section>
                        </div>
                    </section>
                </div>


                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';
import { Pill } from '@/components/ui/pill';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { BellIcon,CheckCircleIcon,StarIcon } from '@heroicons/vue/24/outline';
import { CheckIcon } from '@heroicons/vue/24/solid';
import { ClockIcon } from '@heroicons/vue/24/outline';
import TextLink from '@/components/TextLink.vue';
import { computed } from 'vue';

const props = defineProps([
    'registration',
    'verified',
    'eventRegistrationFilled',
    'attendeesFilled',
    'attendeeCount',
    'payment',
]);


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
    },
];

</script>
