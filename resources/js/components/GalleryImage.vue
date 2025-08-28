<script setup lang="ts">
import { cn } from '@/lib/utils';
import { computed, ref } from 'vue';
import DeleteMedia from '@/pages/media/DeleteMedia.vue';
import EditMedia from '@/pages/media/EditMedia.vue';
import { AdvancedImage, lazyload, placeholder } from '@cloudinary/vue';
import { thumbnail } from "@cloudinary/url-gen/actions/resize";
import { Cloudinary } from '@cloudinary/url-gen';
import { usePage } from '@inertiajs/vue3';

interface Props {
    media?: object;
    class?: string;
}

const props = withDefaults(defineProps<Props>(), {
    class: '',
});

const plugins = [
    lazyload(),
    placeholder({mode: 'blur'})
]
const page = usePage();

// Create a Cloudinary instance and set your cloud name.
const cld = new Cloudinary({
  cloud: {
    cloudName: page.props.cloudinary.cloud_name,
  },
});

// Instantiate a CloudinaryImage object for the image with the public ID, 'oil'.
// Define plugins for lazyloading and placeholder.
// const plugins = [lazyload(), placeholder()];

const openEdit = ref(false)
const openDelete = ref(false)

const className = computed(() => cn('w-full h-auto rounded-md', props.class));

</script>

<template>
    <div class="relative">
        <div class="grid justify-items-center w-full h-full">
            <AdvancedImage
                :cldImg="cld.image(media.cloudinary_public_id).resize(thumbnail().width(200).height(200))"
                :plugins="plugins"
                className="rounded-lg "
                />
        </div>

        <!-- <img :class="className" :src="src" /> -->
        <EditMedia
            v-if="media != null"
            :media="media"
            @edited="openEdit = false"
            />
        <DeleteMedia
            v-if="media != null"
            :media="media"
            @deleted="openDelete = false"
            />
    </div>
</template>
