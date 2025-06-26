<template>
    <Head :title="attendee.id === null ? 'Add Attendee' : 'Edit Attendee'" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col rounded-xl p-4">
            <Heading
                class="mt-4 md:mt-8"
                :title="attendee.id === null ? 'Add Attendee' : 'Edit Attendee'"
                description="You are welcome to modify these details after submission."
            />

            <AttendeeForm :attendee="attendee" />

        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import AttendeeForm from '@/pages/attendee/AttendeeForm.vue';
import { type BreadcrumbItem } from '@/types';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { GridCell, GridHeading, GridList, GridDl, GridDlCell, GridDt, GridDd,  } from '@/components/ui/gridlist';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Label } from '@/components/ui/label';
import { Pill } from '@/components/ui/pill';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { BellIcon, CheckCircleIcon, ExclamationCircleIcon, UsersIcon, PlusIcon } from '@heroicons/vue/24/outline';
import { CheckIcon } from '@heroicons/vue/24/solid';

import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';

const props = defineProps<{
    attendees: array;
    attendee: object;
}>();

const page = usePage();
const user = page.props.auth.user as User;

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
    },
    {
        title: 'Attendees',
        href: route('attendee.index'),
    },
    {
        title: props.attendee.id === null ? 'Add Attendee' : 'Edit Attendee',
        href: route('attendee.create'),
    },
];

</script>
