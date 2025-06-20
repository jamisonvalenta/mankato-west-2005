<script setup lang="ts">
import { cn } from '@/lib/utils';
import type { HTMLAttributes } from 'vue';
import { computed } from 'vue';

interface GridListProps {
    class?: HTMLAttributes['class'];
}

const props = defineProps<GridListProps>();

</script>

<template>
    <div :class="cn('grid grid-cols-1', props.class)" >
        <slot />
    </div>
</template>
