<template>
    <Head title="Class of 2005 Reunion" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-2 xl:grid-cols-3">
                <div class="relative aspect-video rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <section class="overflow-hidden bg-red-50">
                        <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 px-4 py-3">
                            <BellIcon class="h-10 w-10 flex-none rounded-lg bg-white object-cover border border-gray-900/10" />
                            <div class="text-md font-medium leading-6 text-gray-900">Tasks</div>
                            <div class="relative ml-auto">
                                <!-- <ellipsis-menu></ellipsis-menu> -->
                            </div>
                        </div>
                        <div class="divide-y divide-gray-100">
                            <section class="px-6">
                                <dl class="divide-y divide-gray-100 text-sm leading-6">
                                    <div class="flex justify-between py-4 gap-x-4">
                                        <dt class="text-gray-500">
                                            Registration
                                        </dt>
                                        <dd class="grid grid-cols-2 text-gray-700">

                                            <template
                                                v-if="! registrationFilled"
                                                >
                                                <span
                                                    class="mx-2 px-2 py-1 rounded-sm bg-red-200 text-xs inline-block">
                                                    not started
                                                </span>
                                                <Link
                                                    :href="route('registration.create')"
                                                    class="mx-2 px-3 py-2 rounded-md bg-blue-200 outline outline-blue-400 text-sm inline-block"
                                                    >
                                                    Begin
                                                </Link>
                                            </template>
                                            <CheckCircleIcon
                                                v-else
                                                class="mx-2 px-3 py-2 rounded-sm bg-red-200 text-sm inline-block"/>
                                        </dd>
                                    </div>
                                    <template v-if="registrationVerified">
                                        <div class="flex justify-between py-4 gap-x-4">
                                            <dt class="text-gray-500">
                                                Payment Status
                                            </dt>
                                            <dd class="text-gray-700">
                                                <span class="mx-2 px-3 py-2 rounded-md bg-red-200 text-sm inline-block">
                                                    begin registration
                                                </span>
                                            </dd>
                                        </div>
                                    </template>
                                </dl>
                            </section>
                        </div>
                    </section>
                </div>


                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { BellIcon,CheckCircleIcon } from '@heroicons/vue/24/outline';
import { Link } from '@inertiajs/vue3';

defineProps<{
    registrationFilled?: boolean;
    canResetPassword: boolean;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
    },
];
</script>
