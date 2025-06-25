<template>
    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex h-full flex-1 flex-col rounded-xl p-4">
            <GridList
                class="grid-cols-4"
                >
                <GridHeading > Name </GridHeading>
                <GridHeading class="col-span-2"> Status </GridHeading>
                <GridHeading> Actions </GridHeading>

                <template
                    v-for="user in users"
                    :key="user.id"
                    >
                    <GridCell class="bg-gray-100 border-t border-t-gray-400 "> {{ user.name }}</GridCell>
                    <GridCell
                        class="col-span-2 grid grid-cols-6 gap-4 bg-gray-100 border-t border-t-gray-400 text-center"
                        >
                        <Pill v-if="user.registration" variant="green">
                            registered
                        </Pill>
                        <Pill v-else variant="amber">
                            registered
                        </Pill>

                        <Pill v-if="user.verifications?.length > 0" variant="green">
                            verified
                        </Pill>
                        <Pill v-else variant="amber">
                            verified
                        </Pill>


                        <Pill v-if="user.attendees?.length > 0" variant="green">
                            attending
                        </Pill>
                        <Pill v-else variant="amber">
                            attending
                        </Pill>

                        <Pill v-if="user.payments?.length > 0" variant="green">
                            paid
                        </Pill>
                        <Pill v-else variant="amber">
                            paid
                        </Pill>

                    </GridCell>
                    <GridCell
                        class="bg-gray-100 border-t border-t-gray-400 text-center"
                        >

                        <Dialog v-if="user.verifications?.length == 0 && user.registration">
                            <DialogTrigger as-child>
                                <Button variant="outline">Verify User</Button>
                            </DialogTrigger>
                            <DialogContent>
                                <form class="space-y-6"
                                    @submit.prevent="submit"
                                    @submit="verifyUser(user)"
                                    >
                                    <input type="hidden" name="id" :value="user.id">
                                    <DialogHeader class="space-y-3">
                                        <DialogDescription>
                                            Verify user is a member of the class of 2005
                                        </DialogDescription>
                                    </DialogHeader>

                                    <DialogFooter class="gap-2">
                                        <DialogClose as-child>
                                            <Button variant="outline" > Cancel </Button>
                                        </DialogClose>

                                        <Button variant="default" :disabled="form.processing">
                                            <button type="submit">Verify User</button>
                                        </Button>
                                    </DialogFooter>
                                </form>
                            </DialogContent>
                        </Dialog>
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
import { GridCell, GridHeading, GridList, GridDl, GridDlCell, GridDt, GridDd,  } from '@/components/ui/gridlist';
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

const form = useForm({
    verify: true,
    user_id: null,
});

const verifyUser = (user) => {

    form.user_id = user.id

    form.post(route('admin.verifications.store'), {
        preserveScroll: true,
        onSuccess: () =>  closeModal(),
        onError: () => page.props.flash.error = 'There was an issue processing your request',
        onFinish: () => closeModal(),
    });
};

</script>
