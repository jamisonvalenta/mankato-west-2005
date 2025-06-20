<template>
    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex h-full flex-1 flex-col rounded-xl p-4">
            <GridList
                class="grid-cols-4"
                >
                <GridHeading> Name </GridHeading>
                <GridHeading> </GridHeading>
                <GridHeading> Status </GridHeading>
                <GridHeading> Actions </GridHeading>

                <template
                    v-for="user in users"
                    :key="user.id"
                    >
                    <GridCell class="bg-gray-100 border-t border-t-gray-400 "> {{ user.name }}</GridCell>
                    <GridCell class="bg-gray-100 border-t border-t-gray-400 "> {{ user.registration.original_name }}</GridCell>
                    <GridCell
                        class="bg-gray-100 border-t border-t-gray-400 text-center"
                        >
                        <template v-if="user.verifications?.length > 0">
                            <Pill variant="green"> verified </Pill>
                        </template>

                        <template v-else-if="user.registration">
                            <Pill variant="amber"> awaiting verification </Pill>
                        </template>

                        <template v-else>
                            <Pill variant="violet"> unregistered </Pill>
                        </template>

                    </GridCell>
                    <GridCell
                        class="bg-gray-100 border-t border-t-gray-400 text-center"
                        >
                        <Pill> Actions go here</Pill>
                    </GridCell>
                    <GridDl
                        class="col-span-4 grid-cols-4 grid-flow-row-dense p-4 "
                        >

                        <GridDlCell>
                            <GridDt>
                                Name (2005)
                            </GridDt>
                            <GridDd>
                                {{ user.registration.original_name}}
                            </GridDd>
                        </GridDlCell>

                        <GridDlCell>
                            <GridDt>
                                Email
                            </GridDt>
                            <GridDd>
                                {{ user.email }}
                            </GridDd>
                        </GridDlCell>

                        <GridDlCell>
                            <GridDt>
                                Phone
                            </GridDt>
                            <GridDd>
                                {{ user.registration.phone }}
                            </GridDd>
                        </GridDlCell>

                        <GridDlCell>
                            <GridDt>
                                City
                            </GridDt>
                            <GridDd>
                                {{ user.registration.city }}
                            </GridDd>
                        </GridDlCell>

                        <GridDlCell>
                            <GridDt>
                                State
                            </GridDt>
                            <GridDd>
                                {{ user.registration.state }}
                            </GridDd>
                        </GridDlCell>

                        <GridDlCell>
                            <GridDt>
                                Country
                            </GridDt>
                            <GridDd>
                                {{ user.registration.country }}
                            </GridDd>
                        </GridDlCell>

                        <GridDlCell class="col-span-2">
                            <GridDt>
                                Bio
                            </GridDt>
                            <GridDd>
                                {{ user.registration.bio }}
                            </GridDd>
                        </GridDlCell>
                    </GridDl>
                </template>

            </GridList>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';
import { GridCell, GridHeading, GridList, GridDl, GridDt, GridDd,  } from '@/components/ui/gridlist';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { Label } from '@inertiajs/vue3';
import { Pill } from '@/components/ui/pill';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { BellIcon, CheckCircleIcon, ExclamationCircleIcon, UsersIcon } from '@heroicons/vue/24/outline';
import { CheckIcon } from '@heroicons/vue/24/solid';

defineProps<{
    users: array;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
    },
    {
        title: 'Admin',
        href: route('admin.dashboard'),
    },
    {
        title: 'Users',
        href: route('admin.users.index'),
    },
];
</script>
