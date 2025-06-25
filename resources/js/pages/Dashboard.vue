<template>
    <Head title="Class of 2005 Reunion" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-2 xl:grid-cols-3">
                <div class="relative aspect-video rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <section class="overflow-hidden">
                        <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-4 py-3">
                            <BellIcon class="h-10 w-10 flex-none rounded-lg bg-white object-cover border border-gray-900/10" />
                            <div class="text-md font-medium leading-6 text-gray-900">Tasks</div>
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
                                                v-if="registrationFilled"
                                                class="text-green-500 w-5 h-5 inline-block mr-2"
                                                />
                                            <div v-else class="w-5 h-5 mr-2 inline-block"></div>
                                            Class Registration
                                        </dt>
                                        <dd class="text-gray-700">

                                                <Link
                                                    v-if="! registrationFilled"
                                                    :href="registrationFilled ? route('registration.edit') : route('registration.create')">
                                                    <Button
                                                        variant="default"
                                                        size="default"
                                                        class="mr-2 hover:bg-gray-600"
                                                        >

                                                        Begin
                                                    </Button>
                                                </Link>

                                                <TextLink v-else
                                                    :href="route('registration.edit')"
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
                                            <div v-else class="w-5 h-5 mr-2 inline-block"></div>
                                            Verification
                                        </dt>
                                        <dd class="text-gray-700 pt-3">

                                                <span v-if="verified" class="px-3 py-2 rounded-md text-green-800 text-sm block">

                                                </span>
                                                <span v-else class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">Pending Approval </span>
                                        </dd>

                                        <dt class="text-gray-500 text-lg leading-loose">
                                            <CheckCircleIcon
                                                v-if="eventRegistrationFilled"
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
                                                <div v-else class="mt-2 text-gray-600 hover:text-blue-500 ">
                                                {{ attendeeCount }} attendees ... edit</div>
                                            </Link>
                                        </dd>

                                        <dt class="text-gray-500 text-lg leading-loose">
                                            <CheckCircleIcon
                                                v-if="payment.received"
                                                class="text-green-500 w-5 h-5 inline-block mr-4"
                                                />
                                                <div v-else class="w-5 h-5 mr-2 inline-block"></div>
                                            Payment
                                        </dt>
                                        <dd class="text-gray-700">

                                                <span v-if="payment.received" class="mx-2 px-3 py-2 rounded-md bg-green-200 text-green-800 text-sm inline-block">
                                                    Received {{ payment.amount }} on {{ payment.date }}
                                                </span>
                                                <span v-else-if="eventRegistrationFilled" class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">
                                                    Not Received
                                                </span>
                                        </dd>
                                    </div>

                                        <div class="flex justify-between py-4 gap-x-4">
                                            <dt class="text-gray-500">

                                            </dt>
                                            <dd>
                                            </dd>
                                        </div>
                                </dl>
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
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { BellIcon,CheckCircleIcon } from '@heroicons/vue/24/outline';
import { CheckIcon } from '@heroicons/vue/24/solid';
import TextLink from '@/components/TextLink.vue';

defineProps<{
    registrationFilled?: boolean;
    verified?: boolean;
    eventRegistrationFilled?: boolean;
    attendeesFilled?: boolean;
    countAttendees?: integer;
    payment?: object;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
    },
];
</script>
