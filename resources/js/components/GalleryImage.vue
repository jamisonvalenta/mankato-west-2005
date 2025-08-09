<script setup lang="ts">
import { cn } from '@/lib/utils';
import { computed, ref } from 'vue';
import DeleteMedia from '@/pages/media/DeleteMedia.vue';

interface Props {
    media?: object;
    src: string;
    class?: string;
}

const props = withDefaults(defineProps<Props>(), {
    src: '',
    class: '',
});

const open = ref(false)

const className = computed(() => cn('w-full h-auto rounded-md', props.class));

</script>

<template>
    <div class="relative">
        <img :class="className" :src="src" />
        <DeleteMedia
            v-if="media != null"
            :media="media"
            @deleted="open = false"
            />
    </div>
</template>
