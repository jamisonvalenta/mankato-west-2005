<template>
    <Head title="Upload Media"/>

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col rounded-xl p-4">

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
                class="flex justify-center w-full"
                >

                <Galleria
                    ref="galleria"
                    v-model:activeIndex="activeIndex"
                    :value="images"
                    :numVisible="5"
                    containerStyle="width:100%; max-width:640px; background-color: black; "
                    :showThumbnails="showThumbnails"
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
                                'relative h-[500px]',
                                { 'flex-1 justify-center bg-black': fullScreen }
                            ]
                        },
                        itemscontainer: 'h-full',
                        items: 'h-full',
                        item: 'flex h-full content-center align-items-center',
                        thumbnails: 'absolute w-full left-0 bottom-0 bg-black'
                    }"
                >
                    <template #item="slotProps">
                        <AdvancedImage
                            :cldImg="cld.image(slotProps.item.cloudinary_public_id).resize(thumbnail().height(900))"
                            :alt="slotProps.item.alt"
                            :className="
                                ' shadow-lg ' +
                                (fullScreen ? 'max-w-full h-auto' : 'max-h-full max-w-full')
                            "
                          />
                        <!-- Preload next image -->
                        <AdvancedImage
                            v-if="images.hasOwnProperty(activeIndex + 1)"
                            :cldImg="cld.image(images[activeIndex + 1].cloudinary_public_id).resize(thumbnail().height(900))"
                            className="hidden"
                          />
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
                        <div class="flex items-stretch bg-surface-950 text-white h-10">
                            <button type="button" @click="onThumbnailButtonClick" class="bg-transparent border-none rounded-none hover:bg-white/10 text-white inline-flex justify-center items-center cursor-pointer px-3">
                                <GalleryHorizontal class="w-4 h-4 inline-block"/>
                            </button>
                            <button type="button" @click="toggleAutoSlide" class="bg-transparent border-none rounded-none hover:bg-white/10 text-white inline-flex justify-center items-center cursor-pointer px-3">
                                <Pause v-if="isAutoPlay" class="w-4 h-4 inline-block"/>
                                <Play v-else class="w-4 h-4 inline-block"/>
                            </button>
                            <span v-if="images" class="flex items-center gap-4 ml-3">
                                <span class="text-sm">{{ activeIndex + 1 }}/{{ images.length }}</span>

                                <span class="text-sm">
                                    from {{ images[activeIndex].user.registration.name }}
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
import { GalleryHorizontal, Pause, Play, Maximize2, Minimize2 } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Cloudinary } from '@cloudinary/url-gen';
import {thumbnail} from "@cloudinary/url-gen/actions/resize";
import { AdvancedImage } from '@cloudinary/vue'


const props = defineProps([
    'gallery',
    'media',
])

const page = usePage();

// Create a Cloudinary instance and set your cloud name.
const cld = new Cloudinary({
  cloud: {
    cloudName: page.props.cloudinary.cloud_name,
  },
});

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

const fullScreenIcon = computed(() => {
    return `pi ${fullScreen.value ? 'pi-window-minimize' : 'pi-window-maximize'}`;
});
const slideButtonIcon = computed(() => {
    return `pi ${isAutoPlay.value ? 'pi-pause' : 'pi-play'}`;
});


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
    },
    {
        title: 'Photos',
        href: route('media.index'),
    },
];
</script>
