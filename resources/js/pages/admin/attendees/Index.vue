<template>
    <Head title="Attendees" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex h-full flex-1 flex-col rounded-xl p-4 mb-48">
            <Heading
                class="mt-4 md:mt-8"
                title="Attendees"
            />


            <GridList
                v-if="attendees.length > 0"
                class="grid-cols-5"
                >
                <GridCell class="col-span-2 text-gray-500 my-5">
                    Displaying {{ attendees.length }} matches
                </GridCell>
                <GridCell class="col-span-3 text-gray-500 my-5 flex flex-row-reverse gap-3 ">
                </GridCell>

                <GridHeading > Name </GridHeading>
                <GridHeading > Nametag </GridHeading>
                <GridHeading> Pronouns </GridHeading>
                <GridHeading> Accommodation Requests </GridHeading>
                <GridHeading> Actions </GridHeading>

                <template
                    v-for="(attendee, i) in attendees"
                    :key="attendee.id"
                    >
                    <GridCell class="" :class="i % 2 ? '' : 'bg-gray-50 border-t border-t-gray-200 border-b border-b-gray-200 '"> {{ attendee.name }}</GridCell>
                    <GridCell class="" :class="i % 2 ? '' : 'bg-gray-50 border-t border-t-gray-200 border-b border-b-gray-200 '"> {{ attendee.name != attendee.nametag ? attendee.nametag : '' }}</GridCell>
                    <GridCell class="" :class="i % 2 ? '' : 'bg-gray-50 border-t border-t-gray-200 border-b border-b-gray-200 '"> {{ attendee.pronouns }}</GridCell>
                    <GridCell class="" :class="i % 2 ? '' : 'bg-gray-50 border-t border-t-gray-200 border-b border-b-gray-200 '"> {{ attendee.accommodation_requests }}</GridCell>

                    <GridCell
                        class="text-center" :class="i % 2 ? '' : 'bg-gray-50 border-t border-t-gray-200 border-b border-b-gray-200 '"
                        >

                        <Dialog
                            v-if="attendee.user.verifications?.length == 0 && user.registration"
                            >
                            <DialogTrigger as-child>
                                <Button variant="default" size="sm">Verify User</Button>
                            </DialogTrigger>
                            <DialogContent>
                                <form class="space-y-6"
                                    @submit.prevent="submit"
                                    @submit="verifyUser(user)"
                                    >
                                    <input type="hidden" name="id" :value="user.id">
                                    <DialogHeader class="space-y-3">
                                        <DialogDescription>
                                            <span class="font-semibold">{{ user.registration.name }}</span> is a member of the class of 2005?
                                        </DialogDescription>
                                    </DialogHeader>

                                    <DialogFooter class="gap-2 sm:justify-between">
                                        <DialogClose as-child>
                                            <Button variant="outline" > Cancel </Button>
                                        </DialogClose>

                                        <Button variant="default" :disabled="form.processing">
                                            <button type="submit">Yep, sure is!</button>
                                        </Button>
                                    </DialogFooter>
                                </form>
                            </DialogContent>
                        </Dialog>



                        <Ambulance
                            class="w-5 h-5 text-gray-500 hover:text-red-500 cursor-pointer"
                            :class="{'text-red-500': open[attendee.id]}"
                            @click="toggleDetails(attendee.id)"
                            title="display emergency contact details"
                            aria-title="display emergency contact details"
                            />
                        <!-- <AdminPaymentForm
                            v-if="attendee.user.payments.length > 0"
                            v-for="payment in attendee.user.payments"
                            :key="payment.id"
                            :payment="payment"
                            /> -->
                    </GridCell>

                    <template v-if="open[attendee.id] === true">
                        <GridDl
                            class="col-span-5 grid-cols-5 grid-flow-row-dense p-4 border-b border-b-gray-200"

                            >

                            <GridDlCell>
                                <GridDt>
                                    Emergency Contact Name
                                </GridDt>
                                <GridDd>
                                    {{ attendee.emergency_contact_name }}
                                </GridDd>
                            </GridDlCell>

                            <GridDlCell>
                                <GridDt>
                                    Phone
                                </GridDt>
                                <GridDd>
                                    {{ attendee.emergency_contact_phone }}
                                </GridDd>
                            </GridDlCell>

                            <GridDlCell>
                                <GridDt>
                                    Relationship
                                </GridDt>
                                <GridDd>
                                    {{ attendee.emergency_contact_relationship }}
                                </GridDd>
                            </GridDlCell>
                        </GridDl>
                        <!-- <GridCell
                            v-else
                            class="col-span-5 justify-center"
                            >
                            <div class="text-center text-gray-400">
                                registration not filled
                            </div>
                        </GridCell> -->
                    </template>
                </template>

            </GridList>

            <div
                v-else
                class='h-24'
                >
                <p class="mt-8 border-2 p-6 border-dashed border-gray-200 rounded-lg bg-gray-50/50 text-gray-500 leading-loose text-center">
                    No users match search
                </p>

            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import AdminPaymentForm from '@/pages/admin/payments/AdminPaymentForm.vue';
import { type BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';
import { GridCell, GridHeading, GridList, GridDl, GridDlCell, GridDt, GridDd,  } from '@/components/ui/gridlist';
import Heading from '@/components/Heading.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Label } from '@/components/ui/label';
import { Pill } from '@/components/ui/pill';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { BellIcon, CheckCircleIcon, ExclamationCircleIcon, UsersIcon } from '@heroicons/vue/24/outline';
import { Ambulance } from 'lucide-vue-next';
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
import queryString from 'query-string';
import { ref, computed } from 'vue';

const props = defineProps([
    'attendees'
])

const open = ref({})

const filter = queryString.parse(window.location.search)?.filter

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
        title: 'Attendees',
        href: route('admin.attendees.index'),
    },
];

const form = useForm({
    verify: true,
    user_id: null,
});

const toggleDetails = (attendeeId) => {
    if (! open.value.hasOwnProperty(attendeeId)) {
        open.value[attendeeId] = true
        return
    }

    if (open.value[attendeeId] === true) {
        open.value[attendeeId] = false
    } else {
        open.value[attendeeId] = true
    }
}

const verifyUser = (user) => {

    form.user_id = user.id

    form.post(route('admin.verifications.store'), {
        preserveScroll: true,
        onError: () => page.props.flash.error = 'There was an issue processing your request',
    });
};

</script>
