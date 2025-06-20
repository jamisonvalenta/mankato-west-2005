<script setup lang="ts">
import { cn } from '@/lib/utils';
import type { HTMLAttributes } from 'vue';
import { computed } from 'vue';

interface GridDlProps {
    class?: HTMLAttributes['class'];
}

const props = defineProps<GridDlProps>();

</script>

<template>
    <dt :class="cn('text-gray-500 p-0 m-0 text-sm', props.class)" >
        <slot />
    </dt>
</template>
