<script setup lang="ts">
import { cn } from '@/lib/utils';
import { computed, ref } from 'vue';
import DeleteMedia from '@/pages/media/DeleteMedia.vue';
import { AdvancedImage, lazyload, placeholder } from '@cloudinary/vue';
import { thumbnail } from "@cloudinary/url-gen/actions/resize";
import { Cloudinary } from '@cloudinary/url-gen';
import { usePage } from '@inertiajs/vue3';

interface Props {
    media?: object;
    src: string;
    class?: string;
}

const props = withDefaults(defineProps<Props>(), {
    src: '',
    class: '',
});

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

const open = ref(false)

const className = computed(() => cn('w-full h-auto rounded-md', props.class));

</script>

<template>
    <div class="relative">
        <AdvancedImage :cldImg="cld.image(media.cloudinary_public_id).resize(thumbnail().width(200))"  />
        <!-- :plugins="plugins" -->

        <!-- <img :class="className" :src="src" /> -->
        <DeleteMedia
            v-if="media != null"
            :media="media"
            @deleted="open = false"
            />
    </div>
</template>
