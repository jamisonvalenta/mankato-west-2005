<template>
    <Head title="Class of 2005 Reunion" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-2 xl:grid-cols-3">



                <!-- Tasks -->
                <div class="relative aspect-video rounded-xl border border-sidebar-border/70">
                    <section class="overflow-hidden">
                        <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-4 py-3">
                            <ListBulletIcon class="h-10 w-10 flex-none rounded-lg bg-white object-cover border border-gray-900/10" />
                            <div class="text-md font-medium leading-6 text-gray-900">
                                My Tasks
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
                                                        class="mr-2"
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
                                                v-if="attendeesFilled && registration"
                                                class="text-green-500 w-5 h-5 inline-block mr-2"
                                                />
                                            <div v-else class="w-5 h-5 mr-2 inline-block"></div>
                                            Reunion Registration
                                        </dt>
                                        <dd class="text-gray-700">
                                            <Link
                                                v-if="registration"
                                                :href="route('attendee.index')"
                                                >
                                                <Button
                                                    v-if="! attendeesFilled"
                                                    variant="default"
                                                    size="default"
                                                    class="mr-2"
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
                                            <div v-if="attendeesFilled && registration">
                                                <Link
                                                    v-if="attendeesFilled && ! payment"
                                                    :href="route('payments.index')">
                                                    <Button
                                                        variant="default"
                                                        size="default"
                                                        class="mr-2"
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
                                                    <Link
                                                        v-else
                                                        :href="route('payments.index')"
                                                        class="cursor-pointer">
                                                        <Pill  variant="amber">
                                                            Not Received
                                                        </Pill>
                                                    </Link>
                                                </div>

                                            </div>
                                        </dd>

                                    </div>
                                </dl>
                                <div v-if="payment?.received_at" class="w-full grid grid-cols-1 justify-center gap-4 text-center my-4">
                                    <hr>
                                    <div>
                                        <StarIcon class="text-yellow-500 w-6 h-6 inline-block mx-4 -mt-2"/>
                                        <span class="font-semibold text-lg text-gray-500 inline-block variant-smallcaps leading-loose">
                                            Registration Complete
                                        </span>
                                        <StarIcon class="text-yellow-500 w-6 h-6 inline-block mx-4 -mt-2"/>
                                    </div>

                                    <span class="text-gray-500">
                                        Check back occasionally as we continue to add information and features!
                                    </span>
                                </div>
                                <div v-else class="w-full grid grid-cols-1 justify-center gap-4 text-center my-4">
                                    <hr>
                                    <div>
                                        <ExclamationCircleIcon class="text-yellow-500 w-6 h-6 inline-block mx-4 -mt-2"/>
                                        <span class="font-semibold text-lg text-gray-500 inline-block variant-smallcaps leading-loose">
                                            Registration Incomplete
                                        </span>
                                        <ExclamationCircleIcon class="text-yellow-500 w-6 h-6 inline-block mx-4 -mt-2"/>
                                    </div>

                                    <span class="text-gray-500">
                                        <template v-if="payment && ! payment.received_at">
                                            Please send your payment (<TextLink :href="route('payments.index')">review instructions</TextLink>)
                                        </template>
                                        <template v-else>
                                            Please fill out your class registration, add attendees, payment forms!
                                        </template>
                                    </span>
                                </div>
                            </section>
                        </div>
                    </section>
                </div>

                <!-- Announcements -->
                <div class="relative aspect-video rounded-xl border border-sidebar-border/70">
                    <section class="overflow-scroll-y">
                        <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-4 py-3">
                            <BellIcon class="h-10 w-10 flex-none rounded-lg bg-white object-cover border border-gray-900/10" />
                            <div class="text-md font-medium leading-6 text-gray-900">
                                Announcements
                            </div>
                            <div class="relative ml-auto">
                                <!-- <ellipsis-menu></ellipsis-menu> -->
                            </div>
                        </div>
                        <div class="divide-y divide-gray-100">
                            <section class="px-4">
                                <dl class="divide-y divide-gray-100 text-sm leading-6">
                                    <div class="grid grid-cols-[4em,1fr] py-4 gap-4">
                                        <dt class="text-gray-500 text-md leading-loose">
                                            July 1
                                        </dt>
                                        <dd class="text-gray-700">
                                            Reunion Registration and Payments are live!
                                            <span v-if="user.registration && ! user.registration.bio">
                                                Please <TextLink :href="route('registration.edit', registration)">fill in your bio </TextLink> .
                                            </span>
                                        </dd>

                                        <dt class="text-gray-500 text-md leading-loose">
                                            April 30
                                        </dt>
                                        <dd class="text-gray-700">
                                            <span class="font-bold">Not able to attend?</span> You can still register and join in the fun of answering questions and reading through your classmates' responses.
                                        </dd>

                                    </div>
                                </dl>
                            </section>
                        </div>
                    </section>
                </div>


                <div class="col-span-1 relative min-h-[20em] overflow-hidden rounded-xl border border-sidebar-border/70">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-4 py-3">
                        <PartyPopper class="h-10 w-10 flex-none rounded-lg bg-white object-cover border border-gray-900/10" />
                        <div class="text-md font-medium leading-6 text-gray-900">
                            Who's Registered
                        </div>
                        <div class="relative ml-auto">
                            <!-- <ellipsis-menu></ellipsis-menu> -->
                        </div>
                    </div>
                    <div class="text-gray-700 p-4 overflow-y-auto">
                        <ul v-if="verified">
                            <li
                                v-for="verifiedUser in usersVerified"
                                class="list-none"
                                >
                                {{ verifiedUser.name }}
                                <span v-if="verifiedUser.registration.original_name"> ({{ verifiedUser.registration.original_name }})</span>
                            </li>
                        </ul>
                        <p v-else class="mt-8 border-2 p-6 border-dashed border-gray-200 rounded-lg bg-gray-50/50 text-gray-500 leading-loose text-center">
                            You need to be verified before you can view this section
                        </p>
                    </div>
                </div>



                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-4 py-3">
                        <HomeModernIcon class="h-10 w-10 flex-none rounded-lg bg-white object-cover border border-gray-900/10" />
                        <div class="text-md font-medium leading-6 text-gray-900">
                            Hotel Information
                        </div>
                        <div class="relative ml-auto">
                            <!-- <ellipsis-menu></ellipsis-menu> -->
                        </div>
                    </div>
                    <div class="text-gray-700 p-4">
                        <p class="my-4 leading-loose">
                            We will likely be reserving a room block at the Fairfield Inn and Suites in Mankato, walking distance from The Venue
                        </p>
                    </div>
                </div>

                <div class="relative min-h-[20em] overflow-hidden rounded-xl border border-sidebar-border/70">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-4 py-3">
                        <Baby class="h-10 w-10 flex-none rounded-lg bg-white object-cover border border-gray-900/10" />
                        <div class="text-md font-medium leading-6 text-gray-900">
                            Childcare
                        </div>
                        <div class="relative ml-auto">
                            <!-- <ellipsis-menu></ellipsis-menu> -->
                        </div>
                    </div>
                    <div class="text-gray-700 p-4">
                        <p class="my-4 leading-loose">
                            If you have a child who would like to offer babysitting services during the event, either at a private home or hotel, please <a href="mailto:westscarlets2005@gmail.com" class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:!decoration-current "> email us</a>.
                        </p>
                        <p class="my-4 leading-loose">
                            Note: Being listed is in no way a recommendation. Parents are responsible for vetting any services offered.
                        </p>

                    </div>
                </div>

                <div class="relative min-h-[20em] overflow-hidden rounded-xl border border-sidebar-border/70">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-4 py-3">
                        <PiggyBank class="h-10 w-10 flex-none rounded-lg bg-white object-cover border border-gray-900/10" />
                        <div class="text-md font-medium leading-6 text-gray-900">
                            Reunion Financials
                        </div>
                        <div class="relative ml-auto">
                            <!-- <ellipsis-menu></ellipsis-menu> -->
                        </div>
                    </div>
                    <div class="text-gray-700 p-4">
                        <p class="my-4 leading-loose">
                            It is our goal to utilize your money efficiently. Between your donations and careful budgeting, we hope to practice generosity in Mankato/North Mankato!
                        </p>
                        <p class="my-4 leading-loose">
                            If you know any local charitable causes, or have connections to the Mankato West such that we might be able understand how a donation could be helpful to current students, please <a href="mailto:westscarlets2005@gmail.com" class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:!decoration-current"> email us</a>.
                        </p>
                        <p class="my-4 leading-loose">
                            <span class="font-bold">Refund Policy:</span> In the event you are unable to attend, we can not proactively offer a refund. However, if we have a budget surplus, we may be able to offer a refund following the close of the reunion.
                        </p>

                    </div>
                </div>

                <div class="relative min-h-[20em] overflow-hidden rounded-xl border border-sidebar-border/70">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-4 py-3">
                        <Camera class="h-10 w-10 flex-none rounded-lg bg-white object-cover border border-gray-900/10" />
                        <div class="text-md font-medium leading-6 text-gray-900">
                            Photo Uploads
                        </div>
                        <div class="relative ml-auto">
                            <!-- <ellipsis-menu></ellipsis-menu> -->
                        </div>
                    </div>
                    <div class="text-gray-700 p-4">
                        <p class="my-4 leading-loose">
                            Have some beloved images from high school? Find a scanner and upload them here!
                        </p>

                        <p class="my-4 leading-loose">
                            We'll build a slideshow for the reunion, and/or use them as inspiration for event festivities!
                        </p>

                        <p class="mt-8 border-2 p-6 border-dashed border-gray-200 rounded-lg bg-gray-50/50 text-gray-500 leading-loose text-center">
                            Uploader coming soon!
                        </p>

                    </div>
                </div>

                <div
                    v-if="userSpotlight && verified"
                    class="sm:col-span-2 relative  overflow-hidden rounded-xl border border-sidebar-border/70">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-4 py-3">
                        <UsersRound class="h-10 w-10 flex-none rounded-lg bg-white object-cover border border-gray-900/10" />
                        <div class="text-md font-medium leading-6 text-gray-900">
                            What have your classmates been up to?
                            <TextLink v-if="user.registration" :href="route('registration.edit', registration)" class="text-gray-400">
                                edit my bio
                            </TextLink>
                        </div>
                        <div class="relative ml-auto">
                            <!-- <ellipsis-menu></ellipsis-menu> -->
                        </div>
                    </div>
                    <div class="text-gray-700 p-4">
                        <template v-if="verified">
                            <h3 class="text-md font-semibold font-gray-600">
                            {{ userSpotlight.name }}
                            <span v-if="userSpotlight.registration.original_name" class=""> (formerly {{ userSpotlight.registration.original_name }}) </span>

                            </h3>
                            <p class="my-4 leading-loose">
                                {{ userSpotlight.registration.bio }}
                            </p>
                        </template>

                        <p v-else class="mt-4 border-2 p-6 border-dashed border-gray-200 rounded-lg bg-gray-50/50 text-gray-500 leading-loose text-center">
                            You need to be verified before you can view this section
                        </p>
                    </div>
                </div>


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
import { Baby, Camera, PiggyBank, UsersRound, PartyPopper } from 'lucide-vue-next';
import TextLink from '@/components/TextLink.vue';
import { computed } from 'vue';

const props = defineProps([
    'registration',
    'verified',
    'eventRegistrationFilled',
    'attendeesFilled',
    'attendeeCount',
    'payment',
    'usersVerified',
    'userSpotlight',
    'biosCount',
]);


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
    },
];

const page = usePage();
const user = page.props.auth.user as User;

</script>
