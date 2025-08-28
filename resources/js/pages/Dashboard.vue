<template>
    <Head title="Class of 2005 Reunion" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">



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
<!--
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
                                            <TextLink
                                                v-if="payment?.received_at"
                                                :href="route('payments.index')"
                                                class="ml-2 text-sm text-gray-500">
                                                    view/add
                                            </TextLink>
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
                                                    <Pill
                                                        v-if="payment?.received_at"
                                                        variant="green">
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
                                        </dd> -->

                                    </div>
                                </dl>
                                <div v-if="verified" class="w-full grid grid-cols-1 justify-center gap-4 text-center my-4">
                                    <hr>
                                    <div>
                                        <StarIcon class="text-yellow-500 w-6 h-6 inline-block mx-4 -mt-2"/>
                                        <span class="font-semibold text-lg text-gray-500 inline-block variant-smallcaps leading-loose">
                                            Class Registration Complete
                                        </span>
                                        <StarIcon class="text-yellow-500 w-6 h-6 inline-block mx-4 -mt-2"/>
                                    </div>
<!--
                                    <span class="text-gray-500">
                                        Check back occasionally as we continue to add information and features!
                                    </span> -->
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
<!--
                                    <span class="text-gray-500">
                                        <template v-if="payment && ! payment.received_at">
                                            Please send your payment (<TextLink :href="route('payments.index')">review instructions</TextLink>)
                                        </template>
                                        <template v-else>
                                            Please fill out your class registration, add attendees, payment forms!
                                        </template>
                                    </span> -->
                                </div>
                            </section>
                        </div>
                    </section>
                </div>
<!-- Galleries -->
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-4 py-3">
                        <FileImage class="h-10 w-10 flex-none rounded-lg bg-white object-cover border border-gray-900/10" />
                        <div class="text-md font-medium leading-6 text-gray-900">
                            Galleries
                        </div>

                        <div class="relative ml-auto">
                            <Link
                                v-if="verified"
                                :href="route('media.galleries.show', 'archive')"
                                >
                                <Button
                                    variant="default"
                                    size="default"
                                    >

                                    View Galleries
                                </Button>
                            </Link>
                        </div>
                    </div>
                    <div class="text-gray-700">
                        <div class="text-gray-500 leading-loose text-center">
                            <div
                                v-if="! verified"
                                class="flex justify-center items-center rounded-xl border-2 border-gray-200 border-dashed h-24 w-full sm:col-span-6">
                                <p class="text-gray-500">
                                    Please
                                    <TextLink
                                    :href="route('registration.create')">
                                        register
                                    </TextLink>
                                    and wait to be verified

                                </p>
                            </div>
                            <div
                                v-if="images.length > 0"
                                class="flex justify-center w-full"
                                >

                                <Galleria
                                    ref="galleria"
                                    v-model:activeIndex="activeIndex"
                                    :value="images"
                                    containerStyle="width:100%; background-color: transparent; border:none;"
                                    :showThumbnails="false"
                                    :showItemNavigators="true"
                                    :showItemNavigatorsOnHover="true"
                                    :circular="true"
                                    :autoPlay="isAutoPlay"
                                    :transitionInterval="3000"
                                    :responsiveOptions="responsiveOptions"
                                    :pt="{
                                        root: {
                                            class: [{ 'flex flex-col bg-black': fullScreen }]
                                        },
                                        content: {
                                            class: [
                                                'relative w-full',
                                                { 'flex-1 justify-center bg-black': fullScreen }
                                            ]
                                        },
                                        itemscontainer: 'w-full min-h-[300px] min-w-full ',
                                        items: 'w-full rounded-none',
                                        item: 'flex w-full content-center align-items-center',
                                        footer: 'bg-gray-100',

                                    }"
                                >
                                    <template #item="slotProps">
                                        <AdvancedImage
                                            :cldImg="cld.image(slotProps.item.cloudinary_public_id).resize(
                                                    thumbnail()
                                                    .height(300)
                                                    .width(450)
                                                )"
                                            :alt="slotProps.item.alt"
                                            :className="(fullScreen ? 'max-w-full h-auto' : 'max-h-full max-w-full')
                                            "
                                          />
                                        <!-- Preload next image -->
                                        <AdvancedImage
                                            v-if="images.hasOwnProperty(activeIndex + 1)"
                                            :cldImg="cld.image(slotProps.item.cloudinary_public_id).resize(
                                                    thumbnail()
                                                    .height(300)
                                                    .width(450)
                                                )"
                                            className="hidden"
                                          />
                                    </template>
                                    <template #footer>
                                        <div class="grid grid-cols-1 w-full gap-2">
                                            <div class="flex items-stretch bg-surface-950 text-black h-10">
                                                <button type="button" @click="toggleAutoSlide" class="bg-transparent border-none rounded-none hover:bg-white/10 text-black inline-flex justify-center items-center cursor-pointer px-3">
                                                    <Pause v-if="isAutoPlay" class="w-4 h-4 inline-block"/>
                                                    <Play v-else class="w-4 h-4 inline-block"/>
                                                </button>
                                                <span v-if="images.length" class="flex items-center gap-4 ml-3">
                                                    <span class="text-sm">{{ activeIndex + 1 }}/{{ images.length }}</span>
                                                    <span class="text-sm">
                                                    from {{ images[activeIndex].user.registration.name }}
                                                </span>
                                                </span>
                                                <button type="button" @click="toggleFullScreen" class="bg-transparent border-none rounded-none hover:bg-white/10 text-black inline-flex justify-center items-center cursor-pointer px-3 ml-auto">
                                                    <Minimize2 v-if="fullScreen" class="w-4 h-4 inline-block"/>
                                                    <Maximize2 v-else class="w-4 h-4 inline-block"/>
                                                </button>
                                            </div>
                                            <div
                                                class="text-left px-4 leading-6 mb-2"
                                                v-if="images[activeIndex].description"
                                            >
                                                <span
                                                    class="text-sm"
                                                    >
                                                    {{ images[activeIndex].description }}
                                                </span>

                                            </div>
                                        </div>
                                    </template>
                                </Galleria>

                             </div>
                        </div>

                    </div>
                </div>


                <!-- Announcements -->
                <div class="relative aspect-video rounded-xl border border-sidebar-border/70">
                    <section class="overflow-scroll-y">
                        <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-4 py-3">
                            <BellIcon class="h-10 w-10 flex-none rounded-lg bg-white object-cover border border-gray-900/10" />
                            <div class="text-md font-medium leading-6 text-gray-900">
                                Announcements
                            </div>
                        </div>
                        <div class="divide-y divide-gray-100">
                            <section class="px-4">
                                <dl class="divide-y divide-gray-100 text-sm leading-6">
                                    <div class="grid grid-cols-[4em,1fr] py-4 gap-4">
                                        <dt class="text-gray-500 text-md leading-loose">
                                            Aug 28
                                        </dt>
                                        <dd class="text-gray-700">
                                            <span v-if="verified" >
                                                Photo Galleries, images have descriptions
                                            </span>
                                        </dd>
                                        <dt class="text-gray-500 text-md leading-loose">
                                            Aug 16
                                        </dt>
                                        <dd class="text-gray-700">
                                            <span v-if="verified" >
                                                100 people attended the 20 Year Reunion!
                                            </span>
                                        </dd>
                                        <dt class="text-gray-500 text-md leading-loose">
                                            Aug 9
                                        </dt>
                                        <dd class="text-gray-700">
                                            <span v-if="verified" >
                                                Photo Uploader active.
                                                <TextLink :href="route('media.create')"> Upload archival, current, or reunion photos</TextLink>
                                            </span>

                                            <span v-else> Event Details page Published (<TextLink :href="route('registration.create')">register</TextLink> with the class to upload or view photos)</span>
                                        </dd>

                                        <dt class="text-gray-500 text-md leading-loose">
                                            Aug 8
                                        </dt>
                                        <dd class="text-gray-700">
                                            Reunion event details published
                                        </dd>

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




                <div class="col-span-1 relative min-h-[20em] rounded-xl border border-sidebar-border/70">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-4 py-3">
                        <UsersRound class="h-10 w-10 flex-none rounded-lg bg-white object-cover border border-gray-900/10" />
                        <div class="text-md font-medium leading-6 text-gray-900">
                            Who's Registered ({{ verifiedUsers.length }})
                        </div>
                    </div>
                    <div class="text-gray-700 p-4 overflow-y-auto max-h-[25em]">
                        <ul v-if="verified">
                            <li
                                v-for="user in visibleVerifiedUsers"
                                class="list-none"
                                >
                                {{ user.name }}
                                <span v-if="user.registration.original_name">
                                    ({{ user.registration.original_name }})
                                </span>
                            </li>
                            <li v-if="invisibleVerifiedUsers.length > 0"
                                class="list-none"
                                >
                                + {{ invisibleVerifiedUsers.length }} others!
                            </li>

                        </ul>
                        <p v-else class="mt-8 border-2 p-6 border-dashed border-gray-200 rounded-lg bg-gray-50/50 text-gray-500 leading-loose text-center">
                            Before viewing this seciton, you need to be verified
                        </p>
                    </div>
                </div>

<!--
                <div
                    v-if="verified"
                    class="sm:col-span-1 relative  overflow-hidden rounded-xl border border-sidebar-border/70">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-4 py-3">
                        <AlignJustify class="h-10 w-10 flex-none rounded-lg bg-white object-cover border border-gray-900/10" />
                        <div class="text-md font-medium leading-6 text-gray-900">
                            20-year Reunion Schedule
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

                        <div class="my-4 flex items-center justify-center">
                            <Link :href="route('events.twenty-year')">
                                <Button
                                    variant="default"
                                    size="default"
                                    class=""
                                    >

                                    20-year Reunion Details
                                </Button>
                            </Link>
                        </div>

                    </div>
                </div> -->

<!--
                <div class="relative min-h-[20em] overflow-hidden rounded-xl border border-sidebar-border/70">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-4 py-3">
                        <PiggyBank class="h-10 w-10 flex-none rounded-lg bg-white object-cover border border-gray-900/10" />
                        <div class="text-md font-medium leading-6 text-gray-900">
                            Reunion Financials
                        </div>
                        <div class="relative ml-auto">
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
                </div> -->

<!--
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
                </div> -->





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
import { Baby, Camera, PiggyBank, UsersRound, PartyPopper, AlignJustify, FileImage, GalleryHorizontal, Pause, Play, Maximize2, Minimize2 } from 'lucide-vue-next';
import TextLink from '@/components/TextLink.vue';
import { computed, ref, onMounted } from 'vue';
import { Cloudinary } from '@cloudinary/url-gen';
import {thumbnail} from "@cloudinary/url-gen/actions/resize";
import { AdvancedImage, placeholder } from '@cloudinary/vue'

const props = defineProps([
    'registration',
    'verified',
    'eventRegistrationFilled',
    'attendeesFilled',
    'attendeeCount',
    'payment',
    'verifiedUsers',
    'invisibleVerifiedUsers',
    'visibleVerifiedUsers',
    'userSpotlight',
    'biosCount',
    'media'
]);


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
    },
];

const page = usePage();
const user = page.props.auth.user as User;

const cld = new Cloudinary({
  cloud: {
    cloudName: page.props.cloudinary.cloud_name,
  },
});
const plugins = [
    placeholder({mode: 'blur'})
]

const galleria = ref();

const images = ref(props.media);

const activeIndex = ref(0);
const showThumbnails = ref(false);
const fullScreen = ref(false);
const isAutoPlay = ref(true);


onMounted(() => {
    bindDocumentListeners();
});


const toggleAutoSlide = () => {
    isAutoPlay.value  = !isAutoPlay.value ;
};
const onThumbnailButtonClick = () => {
    showThumbnails.value  = !showThumbnails.value ;
};

const responsiveOptions = ref([
    {
        breakpoint: '1300px',
        numVisible: 4
    },
    {
        breakpoint: '575px',
        numVisible: 1
    }
]);

const toggleFullScreen = () => {
    if (fullScreen.value ) {
        closeFullScreen();
    } else {
        openFullScreen();
    }
};
const onFullScreenChange = () => {
    fullScreen.value  = !fullScreen.value ;
};
const openFullScreen = () =>{
    let elem = galleria.value.$el;

    if (elem.requestFullscreen) {
        elem.requestFullscreen();
    } else if (elem.mozRequestFullScreen) {
        /* Firefox */
        elem.mozRequestFullScreen();
    } else if (elem.webkitRequestFullscreen) {
        /* Chrome, Safari & Opera */
        elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) {
        /* IE/Edge */
        elem.msRequestFullscreen();
    }
};
const closeFullScreen = () => {
    if (document.exitFullscreen) {
        document.exitFullscreen();
    } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
    } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
    }
};
const bindDocumentListeners = () => {
    document.addEventListener('fullscreenchange', onFullScreenChange);
    document.addEventListener('mozfullscreenchange', onFullScreenChange);
    document.addEventListener('webkitfullscreenchange', onFullScreenChange);
    document.addEventListener('msfullscreenchange', onFullScreenChange);
};
const unbindDocumentListeners = () => {
    document.removeEventListener('fullscreenchange', onFullScreenChange);
    document.removeEventListener('mozfullscreenchange', onFullScreenChange);
    document.removeEventListener('webkitfullscreenchange', onFullScreenChange);
    document.removeEventListener('msfullscreenchange', onFullScreenChange);
};

</script>
