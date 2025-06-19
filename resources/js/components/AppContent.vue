<script setup lang="ts">
import { SidebarInset } from '@/components/ui/sidebar';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { BellIcon, CheckCircleIcon, ExclamationTriangleIcon } from '@heroicons/vue/24/outline';


interface Props {
    variant?: 'header' | 'sidebar';
    class?: string;
}

const props = defineProps<Props>();
const className = computed(() => props.class);

const page = usePage();

const error = computed(() => page.props.flash?.error);
const message = computed(() => page.props.flash?.message);
const success = computed(() => page.props.flash?.success);

</script>

<template>
    <SidebarInset v-if="props.variant === 'sidebar'" :class="className">
        <slot />
    </SidebarInset>


    <main v-else class="mx-auto flex h-full w-full max-w-7xl flex-1 flex-col gap-4 rounded-xl" :class="className">
        <div
            v-if="error || message || success"
            class="mt-8 m-4">

            <div v-if="success" class="text-green-800 border border-green-200 bg-green-50 rounded-md p-4">
                <CheckCircleIcon class="h-6 w-6 mr-2  -mt-1 text-green-600 inline-block " />
                {{ success }}
            </div>

            <div v-if="message" class="text-amber-800 border border-amber-200 bg-amber-50 rounded-md p-4">
                <BellIcon class="h-6 w-6 mr-2  -mt-1 text-amber-600 inline-block " />
                {{ message }}
            </div>

            <div v-if="error" class="text-red-800 border border-red-200 bg-red-50 rounded-md p-4">
                <ExclamationTriangleIcon class="h-6 w-6 -mt-1 inline-block mr-2  " />
                {{ error }}
            </div>

        </div>
        <slot />
    </main>
</template>
