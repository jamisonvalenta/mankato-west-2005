<template>
    <Head title="Class of 2005 Reunion" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-2 xl:grid-cols-3">

                <div
                    class="sm:col-span-1 relative  overflow-hidden rounded-xl border border-sidebar-border/70">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-4 py-3">
                        <AlignJustify class="h-10 w-10 flex-none rounded-lg bg-white object-cover border border-gray-900/10" />
                        <div class="text-md font-medium leading-6 text-gray-900">
                            Event Schedule
                        </div>
                    </div>
                    <div class="text-gray-700 p-4">
                        <dl class="grid grid-cols-[6em,1fr] gap-2 text-gray-700 text-base">
                            <dt class="uppercase text-sm font-semibold">Date</dt>
                            <dd>Saturday August 16, 2025</dd>
                            <dt class="uppercase text-sm font-semibold ">Location</dt>
                            <dd>
                                <a class="hover:text-blue-500 " href="https://www.thevenuemankato.com">
                                    The Venue
                                </a>
                                <br>
                                1850 Madison Ave
                                <br>
                                Mankato MN 56001
                            </dd>


                            <dt class="uppercase text-sm font-semibold">6:00pm</dt>
                            <dd>Guests arrive, mingling &amp; appetizers</dd>

                            <dt class="uppercase text-sm font-semibold">6:30pm</dt>
                            <dd>Welcomes and introductions, presentations, activities, etc</dd>

                            <dt class="uppercase text-sm font-semibold">7:30pm</dt>
                            <dd>Live music begins, activities continue</dd>

                            <dt class="uppercase text-sm font-semibold">10:30pm</dt>
                            <dd>Event ends</dd>
                        </dl>
                    </div>
                </div>

                <!-- Food and Libations -->
                <div class="relative aspect-video rounded-xl border border-sidebar-border/70">
                    <section class="overflow-scroll-y">
                        <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-4 py-3">
                            <BellIcon class="h-10 w-10 flex-none rounded-lg bg-white object-cover border border-gray-900/10" />
                            <div class="text-md font-medium leading-6 text-gray-900">
                                Food and Libations
                            </div>
                        </div>
                        <div class="divide-y divide-gray-100">
                            <section class="px-4">
                                <dl class="divide-y divide-gray-100 text-sm leading-6">
                                    <div class="grid grid-cols-[8em,1fr] py-4 gap-4">
                                        <dt class="text-gray-500 text-md leading-loose">
                                            Food
                                        </dt>
                                        <dd class="text-gray-700">
                                            Selection of cheese/vegetable platters, appetizers (details TBA)
                                        </dd>

                                        <dt class="text-gray-500 text-md leading-loose">
                                            Dessert
                                        </dt>
                                        <dd class="text-gray-700">
                                            cookies, cupcakes, brownies?
                                        </dd>

                                        <dt class="text-gray-500 text-md leading-loose">
                                            Drink Tickets
                                        </dt>
                                        <dd class="text-gray-700">
                                            1 ticket per attendee, good for soda, beer, or wine
                                        </dd>

                                        <dt class="text-gray-500 text-md leading-loose">
                                            Cash Bar
                                        </dt>
                                        <dd class="text-gray-700">
                                            Sodas, Beer, Wine, Mixed drinks
                                        </dd>

                                    </div>
                                </dl>
                            </section>
                        </div>
                    </section>
                </div>

                <div class="col-span-1 relative min-h-[20em] rounded-xl border border-sidebar-border/70">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-4 py-3">
                        <UsersRound class="h-10 w-10 flex-none rounded-lg bg-white object-cover border border-gray-900/10" />
                        <div class="text-md font-medium leading-6 text-gray-900">
                            Who's Attending ({{ attendeeCount }})
                        </div>
                        <div class="relative ml-auto">
                            <!-- <ellipsis-menu></ellipsis-menu> -->
                        </div>
                    </div>
                    <div class="text-gray-700 p-4 overflow-y-auto max-h-[25em] pb-8">
                        <ul>
                            <li
                                v-for="userAttending in usersAttendingVisible"
                                class="list-none"
                                >
                                    <span v-for="(attendee, index) in userAttending.attendees"
                                    :class="{
                                        'ml-2 text-gray-400' : index > 0,
                                        }">
                                    {{ index > 0 ? '+ ' + attendee.name :  attendee.name }}
                                </span>
                            </li>

                            <li class="list-none text-gray-500">
                                + {{ attendeeInvisibleCount }} others!
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Entertainment -->
            <div class="relative aspect-video rounded-xl border border-sidebar-border/70">
                <section class="overflow-scroll-y">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-4 py-3">
                        <BellIcon class="h-10 w-10 flex-none rounded-lg bg-white object-cover border border-gray-900/10" />
                        <div class="text-md font-medium leading-6 text-gray-900">
                            Entertainment
                        </div>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <section class="px-4">
                            <dl class="divide-y divide-gray-100 text-sm leading-6">
                                <div class="grid grid-cols-[8em,1fr] py-4 gap-4">
                                    <dt class="text-gray-500 text-md leading-loose">
                                        Neon-LIVE
                                    </dt>
                                    <dd class="text-gray-700">
                                        <TextLink href="https://neonlivemusic.wixsite.com/neonlive"> Website </TextLink>
                                        <TextLink href="https://www.facebook.com/neonliveentertainment?rdid=JCvrXX6ImzhIqpt7">(facebook)</TextLink>
                                    </dd>

                                    <dt class="text-gray-500 text-md leading-loose">
                                        Emcee
                                    </dt>
                                    <dd class="text-gray-700">
                                        Cara Gorman
                                    </dd>
                                </div>
                            </dl>
                        </section>
                    </div>
                </section>
            </div>

        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';
import { Pill } from '@/components/ui/pill';
import { Head, Link, usePage } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { BellIcon,CheckCircleIcon,StarIcon, InformationCircleIcon, HomeModernIcon } from '@heroicons/vue/24/outline';
import { CheckIcon } from '@heroicons/vue/24/solid';
import { ClockIcon, ListBulletIcon, ExclamationCircleIcon } from '@heroicons/vue/24/outline';
import { Baby, Camera, PiggyBank, UsersRound, PartyPopper, AlignJustify } from 'lucide-vue-next';
import TextLink from '@/components/TextLink.vue';
import { computed } from 'vue';

const props = defineProps([
    'attendeeCount',
    'usersAttendingVisible',
    'attendeeInvisibleCount',
]);


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
    },
    {
        title: 'Twenty Year Reunion',
        href: route('events.twenty-year'),
    },
];

const page = usePage();
const user = page.props.auth.user as User;

</script>
