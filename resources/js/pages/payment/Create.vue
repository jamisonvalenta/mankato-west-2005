<template>
    <Head title="Payment"/>

    <AppLayout :breadcrumbs="breadcrumbs">
        <PaymentForm :payment="{}"/>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import PaymentForm from "./PaymentForm.vue";

defineProps<{}>();

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
