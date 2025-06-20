<script setup lang="ts">
import { cn } from '@/lib/utils';
import { Primitive, type PrimitiveProps } from 'radix-vue';
import type { HTMLAttributes } from 'vue';
import { pillVariants, type PillVariants } from '.';

interface Props extends PrimitiveProps {
    variant?: PillVariants['variant'];
    size?: PillVariants['size'];
    class?: HTMLAttributes['class'];
}

const props = withDefaults(defineProps<Props>(), {
    as: 'pill',
});
</script>

<template>
    <Primitive :as="as" :as-child="asChild" :class="cn(pillVariants({ variant, size }), props.class)">
        <slot />
    </Primitive>
</template>
