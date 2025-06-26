<template>
    <Head title="Attendees" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col rounded-xl p-4">
            <Heading
                class="mt-4 md:mt-8"
                title="2025 20-year Reunion Attendee Registration"
            />

            <div class="grid grid-cols-1 gap-4 md:grid-cols-[1fr,15em] md:gap-8">
                <div class="">
                    Please list everyone who will be attending the 20th reunion event, <span class="italic">including yourself</span>. Attendees must be 21+.
                </div>

                <AttendeeForm
                    :attendee="newAttendee"
                    />
            </div>


            <GridList
                class="grid-cols-1 md:grid-cols-4 mt-8"
                >
                <template
                    v-for="attendee in attendees"
                    :key="attendee.id"
                    >

                    <div class="grid grid-cols-[1fr,10em] md:col-span-4 bg-gray-100 border-b border-b-gray-400">
                        <GridHeading class="leading-10 pl-4">
                            {{ attendee.name }}
                        </GridHeading>

                        <GridHeading class="mt-1">
                            <AttendeeForm :attendee="attendee" />
                        </GridHeading>
                    </div>

                    <GridDl
                        class="md:col-span-4 md:grid-cols-4 grid-flow-row-dense p-4 "
                        >

                        <GridDlCell>
                            <GridDt>
                                Nametag
                            </GridDt>
                            <GridDd>
                                {{ attendee.nametag }}
                            </GridDd>
                        </GridDlCell>

                        <GridDlCell class="md:col-span-3">
                            <GridDt>
                                Accommodation Requests
                            </GridDt>
                            <GridDd>
                                {{ attendee.accommodation_requests ?? 'none'}}
                            </GridDd>
                        </GridDlCell>

                        <GridDlCell class="">
                            <GridDt>
                                Emergency Contact Name
                            </GridDt>
                            <GridDd>
                                {{ attendee.emergency_contact_name }}
                            </GridDd>
                        </GridDlCell>

                        <GridDlCell class="">
                            <GridDt>
                                Emergency Contact Phone
                            </GridDt>
                            <GridDd>
                                {{ attendee.emergency_contact_phone }}
                            </GridDd>
                        </GridDlCell>

                        <GridDlCell class="">
                            <GridDt>
                                Emergency Contact Relationship
                            </GridDt>
                            <GridDd>
                                {{ attendee.emergency_contact_relationship }}
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
];

const newAttendee = computed( () => {
    if (props.attendees.length === 0) {
        return {
            id: null,
            name: user.name,
            nametag: null,
            relationship: 'self',
            accommodation_requests: null,
            emergency_contact_name: null,
            emergency_contact_phone: null,
            emergency_contact_relationship:null,
        }
    }

    return {
        id: null,
        name: null,
        nametag: null,
        relationship: 'spouse',
        accommodation_requests: null,
        emergency_contact_name: null,
        emergency_contact_phone: null,
        emergency_contact_relationship:null,
    }
})




</script>
