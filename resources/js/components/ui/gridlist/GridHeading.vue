<script setup lang="ts">
import { cn } from '@/lib/utils';
import type { HTMLAttributes } from 'vue';

interface Props {
    class?: HTMLAttributes['class'];
}

const props = defineProps<Props>();


</script>

<template>
    <div :class="cn('font-semibold text-gray-700 text-left p-2', props.class)" >
        <slot />
    </div>
</template>
