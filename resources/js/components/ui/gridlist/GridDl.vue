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
    <div :class="cn('grid grid-cols-1 gap-4', props.class)" >
        <slot />
    </div>
</template>
