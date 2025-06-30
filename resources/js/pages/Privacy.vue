<template>
    <Head title="Privacy Statement" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex h-full flex-1 flex-col rounded-xl p-4 max-w-3xl">
            <Heading
                class="mt-4 md:mt-8"
                title="We value your privacy."
            />

            <p class="mt-0 my-4 leading-loose">In the world today, our attention and data is constantly monetized. Our information, when acquired, is sold through data brokers so that it can be used to sell us, or sell things <span class="italic">to</span> us.  </p>

            <p class="my-4 leading-loose">We've opted to build this registration system from scratch using open-sourced tools on a private, secured server for the explict purpose of side-stepping data-harvesting and commoditization of your attention to this website.</p>

            <p class="my-4 leading-loose">Information you do input into the registration, supplemental photos, or survey questions, will not be accessible now or any time in the future to any human, corporation, or AI. Only people who have been registered and verified will have access to that information, and only if you checked the box on your registration that indicates you're interested in sharing that information.</p>

            <p class="my-4 leading-loose"> We will not reveal your contact information (phone, email) to anyone other than the reunion committee. If we need additional information to verify your identity, we will use this contact information to contact you.</p>

            <p class="my-4 leading-loose">We reserve the right to use an external tool such as Mailchimp to simplfy the task of sending emails concerning reunion topics only.</p>
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
import { ref } from 'vue';

defineProps<{
}>();

const open = ref(false)

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
    },
    {
        title: 'Privacy',
        href: route('privacy'),
    },
];

</script>
