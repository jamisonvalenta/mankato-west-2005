<template>
    <Head title="Payments" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col rounded-xl p-4">
            <Heading
                class="mt-4 md:mt-8"
                title="20-year Reunion Payment"
            />

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-16">
                <div>
                    <h2 class="text-lg mt-8 mb-4 text-gray-500">
                        Event Cost
                    </h2>

                    <p class="my-4">
                        To support a wide range of economic states, reunion cost is donation based, pay-what-you-can. We recommend a per-attendee donation of $50.
                    </p>

                    <p class="my-4">
                        Your recommended donation: <span class="font-bold">${{ user.attendees.length * 50 }}</span>.
                    </p>

                    <p class="my-4">
                        Any amount between $0 and $150 per attendee is welcome.
                    </p>

                    <h2 class="text-lg mt-8 mb-4 text-gray-500">
                        Donation Details
                    </h2>
                    <p class="my-4">
                        Payments via check or Venmo are supported. If you need accommodations, please email us. Payments will be handled through Jamison's business, Trellis.
                    </p>

                    <PaymentForm :payment="defaultPayment"/>
                </div>

                <div class="mt-4 border-t border-t-gray-200 md:mt-0 md:border-t-0 md:border-l border-l-gray-200 md:pl-8 md:pt-8">
                    <h2 class="text-lg mb-4 text-gray-500">
                        Where to Send Money
                    </h2>

                    <div class="grid grid-cols-2">
                        <div>
                            <h3 class="text-sm uppercase mt-8 mb-4 text-gray-500">
                                Venmo
                            </h3>
                            <p class="my-4">
                                @trellisllc
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm uppercase mt-8 mb-4 text-gray-500">
                                Checks
                            </h3>
                            <p class="my-4">
                                <span class="text-gray-500">Mail to:</span><br>
                                Jamison Valenta<br>
                                1415 Race St #1<br>
                                Denver, CO 80206
                            </p>
                            <p class="my-4">
                                <span class="text-gray-500">Paid to:</span><br>
                                Trellis
                            </p>
                        </div>
                    </div>

                </div>


            </div>

            <template v-if="payments.length">
                <h2 class="text-xl text-gray-500 mt-20">
                    Payments
                </h2>
                <GridList
                    class="grid-cols-1 md:grid-cols-2 md:grid-cols-4 mt-8 mb-12"
                    >
                    <template
                        v-for="payment in payments"
                        :key="payment.id"
                        >
                        <GridDl
                            class="sm:grid-cols-2 md:col-span-4 md:grid-cols-4 grid-flow-row-dense p-4 "
                            >

                            <GridDlCell>
                                <GridDt>
                                    Amount
                                </GridDt>
                                <GridDd>
                                    ${{ payment.amount }}
                                </GridDd>
                            </GridDlCell>

                            <GridDlCell>
                                <GridDt>
                                    Payment Account Notes
                                </GridDt>
                                <GridDd >
                                    <template v-if="payment.user_notes">
                                        {{ payment.user_notes }}
                                    </template>
                                    <template v-else>
                                        <span class="text-gray-400">not entered</span>
                                    </template>
                                </GridDd>
                            </GridDlCell>

                            <GridDlCell class="">
                                <GridDt>
                                    Status
                                </GridDt>
                                <GridDd>
                                        <Pill
                                            v-if="payment.received_at"
                                            variant="green">
                                            received: payment.received_at
                                        </Pill>
                                        <Pill
                                            v-else
                                            variant="gray"
                                        >
                                            waiting for payment
                                        </Pill>
                                </GridDd>
                            </GridDlCell>

                            <GridDlCell v-if="payment.received_at" class="">
                                <GridDt>
                                    Received By
                                </GridDt>
                                <GridDd>
                                    {{ payment.received_by?.name }}
                                </GridDd>
                            </GridDlCell>

                            <GridCell>
                                <PaymentForm :payment="payment"/>
                            </GridCell>
                        </GridDl>
                    </template>

                </GridList>


                <div class="grid grid-cols-1 justify-center gap-4 text-center mt-12 mb-24">
                    <Link :href="route('dashboard')" class="text-center">
                        <Button variant="default" size="lg">
                            Return to Dashboard
                        </Button>
                    </Link>
                </div>
            </template>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import PaymentForm from '@/pages/payment/PaymentForm.vue';
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
import { Plus } from 'lucide-vue-next';
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
    payments: array,
    attendees: array,
}>();

const page = usePage();
const user = page.props.auth.user as User;
const defaultPayment = {
    id: null,
    amount: props.attendees.length * 50,
    user_notes: null,

}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
    },
    {
        title: 'Payments',
        href: route('payments.index'),
    },
];



</script>
