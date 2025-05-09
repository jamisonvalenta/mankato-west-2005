<template>
    <Head title="Registration"/>

    <AppLayout :breadcrumbs="breadcrumbs">
        <RegistrationForm
          :registration="{}"
          :post-route="route('registration.store')"
          _method="POST"
          success-message="Thank you for completing your registration. Go back to the dashboard to complete additional tasks.">
        </RegistrationForm>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import RegistrationForm from "./RegistrationForm.vue";

defineProps<{
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
    },
    {
        title: 'Registration',
        href: route('registration.create'),
    },
];

</script>
