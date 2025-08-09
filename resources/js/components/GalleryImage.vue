<script setup lang="ts">
import { cn } from '@/lib/utils';
import { computed } from 'vue';

interface Props {
    src: string;
    class?: string;
}

const props = withDefaults(defineProps<Props>(), {
    src: '',
    class: '',
});

const className = computed(() => cn('w-full w-auto', props.class));

</script>

<template>
    <img :class="className" :src="src" />
</template>
