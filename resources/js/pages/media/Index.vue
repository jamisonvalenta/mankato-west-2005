<template>
    <Head title="Upload Media"/>

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col rounded-xl p-4">

            <div class="grid grid-cols-2 mt-4 md:mt-8">
                <Heading
                        class=""
                        :title="'Your Photos (' + countImages + ')'"
                    />
                <div  class="text-right">
                    <Link :href="route('media.create')">
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
                v-if="countImages > 0"
                class="grid grid-cols-1 gap-4 sm:gap-8"
                >
                <div
                    v-for="gallery in galleries"
                    >
                    <h2 class="text-gray-500 text-lg font-semilbold">
                        {{ gallery.title }}
                    </h2>
                    <div
                    class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 md: gap-8 rounded-xl border-2 border-gray-200 bg-gray-100 p-4 md:p-8 shadow-inset-md">
                    <GalleryImage
                        v-for="media in gallery.images"
                        :media="media"
                        :src="media.url"/>
                    </div>
                </div>
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
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { CloudUpload, Images, X } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';


const props = defineProps([
    'galleries',
    'countImages',
])

const page = usePage()

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
