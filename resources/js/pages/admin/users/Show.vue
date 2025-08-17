<template>
    <Head :title="user.registration.name" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex h-full flex-1 flex-col rounded-xl p-4 mb-48">
            <Heading
                class="mt-4 md:mt-8"
                :title="user.registration.name"
            />

            <GridList
                class="grid-cols-5"
                >
                    <GridCell
                        class="col-span-5 flex flex-dense gap-4 bg-gray-100 border-t border-t-gray-400 text-center"
                        >
                        <Pill v-if="user.registration" variant="green">
                            registered
                        </Pill>
                        <Pill v-else variant="gray" class="text-gray-400">
                            registered
                        </Pill>

                        <Pill v-if="user.verifications?.length > 0" variant="green">
                            verified
                        </Pill>
                        <Pill v-else-if="user.registration" variant="amber">
                            awaiting verification
                        </Pill>
                        <Pill v-else variant="gray" class="text-gray-400">
                            verified
                        </Pill>


                        <Pill v-if="user.attendees?.length > 0" variant="green">
                            attending {{ user.attendees.length > 1 ? '(' + user.attendees.length +')' : ''}}
                        </Pill>
                        <Pill v-else variant="gray" class="text-gray-400">
                            attending
                        </Pill>

                        <Pill v-if="user.payments?.length > 0 && user.payments.filter((payment) => payment.received_at).length > 0" variant="green">
                            paid
                        </Pill>
                        <Pill v-else-if="user.payments?.length > 0" variant="amber">
                            awaiting payment
                        </Pill>
                        <Pill v-else variant="gray" class="text-gray-400">
                            paid
                        </Pill>

                    </GridCell>
                    <GridCell
                        class="bg-gray-100 border-t border-t-gray-400 text-center"
                        >

                        <Dialog
                            v-if="user.verifications?.length == 0 && user.registration"
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

                        <div class="grid grid-cols-3 gap-2">
                        <AdminPaymentForm
                            v-if="user.payments.length > 0"
                            v-for="payment in user.payments"
                            :key="payment.id"
                            :payment="payment"
                            />
                        <div v-else class="col-span-2"></div>
                        <AdminPaymentCreateForm
                            :payment="{
                                user_id: user.id,
                            }"
                            :user="user",
                            />
                        </div>
                    </GridCell>

                    <template v-if="displayDetails">
                        <GridDl
                            v-if="user.registration"
                            class="col-span-5 grid-cols-4 grid-flow-row-dense p-4 "
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

                            <GridDlCell class="col-span-3" v-if="user.registration.bio">
                                <GridDt>
                                    Bio
                                </GridDt>
                                <GridDd>
                                    {{ user.registration.bio }}
                                </GridDd>
                            </GridDlCell>
                        </GridDl>
                        <GridCell
                            v-else
                            class="col-span-5 justify-center"
                            >
                            <div class="text-center text-gray-400">
                                registration not filled
                            </div>
                        </GridCell>
                    </template>
            </GridList>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import AdminPaymentForm from '@/pages/admin/payments/AdminPaymentForm.vue';
import AdminPaymentCreateForm from '@/pages/admin/payments/AdminPaymentCreateForm.vue';
import { type BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';
import { GridCell, GridHeading, GridList, GridDl, GridDlCell, GridDt, GridDd,  } from '@/components/ui/gridlist';
import Heading from '@/components/Heading.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Label } from '@/components/ui/label';
import { Pill } from '@/components/ui/pill';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { BellIcon, CheckCircleIcon, ExclamationCircleIcon, UsersIcon } from '@heroicons/vue/24/outline';
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
    'users'
])

const open = ref(false)

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
        title: 'Users',
        href: route('admin.users.index'),
    },
];

const form = useForm({
    verify: true,
    user_id: null,
});

const verifyUser = (user) => {

    form.user_id = user.id

    form.post(route('admin.verifications.store'), {
        preserveScroll: true,
        onError: () => page.props.flash.error = 'There was an issue processing your request',
    });
};

</script>
