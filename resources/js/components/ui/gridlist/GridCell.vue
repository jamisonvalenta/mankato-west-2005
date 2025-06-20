<script setup lang="ts">
import { cn } from '@/lib/utils';
import type { HTMLAttributes } from 'vue';

interface Props {
    class?: HTMLAttributes['class'];
}

const props = defineProps<Props>();


</script>

<template>
    <div :class="cn(
        'font-regular text-gray-600 text-left px-4 py-2',
         props.class)" >
        <slot />
    </div>
</template>
