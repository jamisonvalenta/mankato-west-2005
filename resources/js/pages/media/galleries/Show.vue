<template>
    <Head title="Upload Media"/>

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col rounded-xl p-4">

            <fieldset class="">
                <div class="mt-6 grid grid-cols-1 gap-y-6 sm:grid-cols-3 sm:gap-x-4 mb-4">
                    <Link
                        v-for="gallery in galleries"
                        :href="route('media.galleries.show', gallery.key)"
                        :aria-label="gallery.title"
                        :aria-description="`${gallery.description}`">
                        <div
                            class="group relative flex rounded-lg border border-gray-300 bg-white p-4"
                            :class="{
                                'outline outline-2  -outline-offset-2 outline-indigo-600 bg-indigo-50 cursor-pointer': galleryModel === gallery.key}"
                             >
                            <div class="flex-1">
                                <span class="block text-sm font-medium text-gray-900">{{ gallery.title }} ({{ gallery.media.length }})</span>
                                <span class="mt-1 block text-sm text-gray-600">{{ gallery.description }}</span>
                            </div>
                        </div>
                    </Link>
                </div>
            </fieldset>

            <div class="grid grid-cols-2 mt-4 md:mt-8">
                <Heading
                    class=""
                    :title="gallery.title"
                    :description="gallery.description"
                />
                <div  class="text-right">
                    <Link :href="route('media.create', {gallery: gallery.key})">
                        <Button
                            variant="default"
                            size="default"
                            class=""
                            >
                            Upload Photos
                        </Button>
                    </Link>
                </div>
            </div>



            <div
                v-if="media.length > 0"
                class="flex justify-center w-full pb-24"
                >

                <Galleria
                    ref="galleria"
                    v-model:activeIndex="activeIndex"
                    :value="images"
                    :numVisible="5"
                    containerStyle="width:100%; max-width:1200px; background-color: black; "
                    :showThumbnails="showThumbnails"
                    :showItemNavigators="true"
                    :showItemNavigatorsOnHover="userAgentSupportsHover ? false : true"
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
                                'relative min-h-[500px]',
                                { 'max-h-[800px] ': ! fullScreen },
                                { 'flex-1 justify-center bg-black max-h-full': fullScreen },
                            ]
                        },
                        itemscontainer: 'h-full',
                        items: 'h-full z-1',
                        item: 'flex h-full content-center align-items-center',
                        thumbnails: 'absolute w-full left-0 bottom-0',
                        footer: 'bg-black z-20'
                    }"
                >
                    <template #item="slotProps">
                        <template v-if="fullScreen">
                            <AdvancedImage
                                :cldImg="cld.image(slotProps.item.cloudinary_public_id).resize(thumbnail().height(1200))"
                                :alt="slotProps.item.alt"
                                className="shadow-lg max-w-full h-auto"
                              />
                            <!-- Preload previous image -->
                            <!-- Preload next image -->
                            <AdvancedImage
                                v-if="images.hasOwnProperty(activeIndex + 1)"
                                :cldImg="cld.image(images[activeIndex + 1].cloudinary_public_id).resize(thumbnail().height(1200))"
                                className="hidden"
                              />
                            <AdvancedImage
                                v-if="images.hasOwnProperty(activeIndex - 1)"
                                :cldImg="cld.image(images[activeIndex - 1].cloudinary_public_id).resize(thumbnail().height(1200))"
                                className="hidden"
                              />
                        </template>
                        <template v-else>
                            <AdvancedImage
                                :cldImg="cld.image(slotProps.item.cloudinary_public_id).resize(thumbnail().height(800))"
                                :alt="slotProps.item.alt"
                                className="shadow-lg max-h-full max-w-full"
                              />
                            <!-- Preload previous image -->
                            <!-- Preload next image -->
                            <AdvancedImage
                                v-if="images.hasOwnProperty(activeIndex + 1)"
                                :cldImg="cld.image(images[activeIndex + 1].cloudinary_public_id).resize(thumbnail().height(800))"
                                className="hidden"
                              />
                            <AdvancedImage
                                v-if="images.hasOwnProperty(activeIndex - 1)"
                                :cldImg="cld.image(images[activeIndex - 1].cloudinary_public_id).resize(thumbnail().height(800))"
                                className="hidden"
                              />
                        </template>
                    </template>
                    <template #thumbnail="slotProps">
                        <div class="grid gap-4 justify-center bg-black">
                            <AdvancedImage
                                :cldImg="cld.image(slotProps.item.cloudinary_public_id).resize(thumbnail().width(100).height(100))"
                                :alt="slotProps.item.alt"
                                className="rounded-md shadow-md"
                              />

                        </div>
                    </template>
                    <template #footer>
                        <div class="flex items-stretch bg-surface-950 text-white min-h-10 py-2 z-20">
                            <button type="button" @click="onThumbnailButtonClick" class="bg-transparent border-none rounded-none hover:bg-white/10 text-white inline-flex justify-center items-center cursor-pointer px-3">
                                <GalleryHorizontal class="w-4 h-4 inline-block"/>
                            </button>
                            <button type="button" @click="toggleAutoSlide" class="bg-transparent border-none rounded-none hover:bg-white/10 text-white inline-flex justify-center items-center cursor-pointer px-3">
                                <Pause v-if="isAutoPlay" class="w-4 h-4 inline-block"/>
                                <Play v-else class="w-4 h-4 inline-block"/>
                            </button>
                            <span v-if="images" class="flex items-center gap-4 ml-3">
                                <span class="text-sm">{{ activeIndex + 1 }}/{{ images.length }}</span>

                                <span class="grid grid-cols-1 gap-2">
                                    <span
                                        v-if="images[activeIndex].description"
                                        class="text-sm"

                                        >
                                        {{ images[activeIndex].description }}
                                    </span>
                                    <span class="text-sm">
                                        from {{ images[activeIndex].user.registration.name }}
                                    </span>
                                </span>
                            </span>
                            <button type="button" @click="toggleFullScreen" class="bg-transparent border-none rounded-none hover:bg-white/10 text-white inline-flex justify-center items-center cursor-pointer px-3 ml-auto">
                                <Minimize2 v-if="fullScreen" class="w-4 h-4 inline-block"/>
                                <Maximize2 v-else class="w-4 h-4 inline-block"/>
                            </button>
                        </div>
                    </template>
                </Galleria>

             </div>
            <div
                v-else
                class="flex justify-center items-center rounded-xl border-2 border-gray-200 border-dashed h-56 w-full sm:col-span-6">
                <p class="text-gray-500">
                    No images Uploaded
                </p>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import GalleryImage from '@/components/GalleryImage.vue';
import { ref, computed, onMounted } from "vue";
import { PhotoService } from '@/service/PhotoService';
import { Link, usePage } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { GalleryHorizontal, Pause, Play, Maximize2, Minimize2, CircleCheck } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Cloudinary } from '@cloudinary/url-gen';
import {thumbnail} from "@cloudinary/url-gen/actions/resize";
import { AdvancedImage } from '@cloudinary/vue'


const props = defineProps([
    'galleries',
    'gallery',
    'media',
])

const page = usePage();

const cld = new Cloudinary({
  cloud: {
    cloudName: page.props.cloudinary.cloud_name,
  },
});

const galleryModel = ref(props.gallery.key)

const galleria = ref();

const images = ref(props.media);

const activeIndex = ref(0);
const showThumbnails = ref(false);
const fullScreen = ref(false);
const isAutoPlay = ref(true);

onMounted(() => {
    bindDocumentListeners();
});


const userAgentSupportsHover = window.matchMedia('(hover: none)').matches

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
        numVisible: 2
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

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
    },
    {
        title: 'Photos',
        href: route('media.index'),
    },
    {
        title: 'Galleries',
        href: route('media.galleries.show', 'archive'),
    },
];
</script>
