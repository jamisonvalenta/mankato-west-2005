<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button
                v-if="! payment.received_at"
                variant="default"
                size="sm"
                @click="form.received = true"
                >
                Confirm ${{ payment.amount }} Payment
            </Button>
            <Button
                v-else
                variant="outline"
                size="sm"
                >
                Edit ${{ payment.amount }} Payment
            </Button>
        </DialogTrigger>
        <DialogContent>
            <form class="space-y-6"
                @submit.prevent="submit"
                >
                <DialogHeader class="space-y-3">
                    <DialogDescription>
                        Did you recieve a payment for <span class="font-semibold">{{ user.registration.name }}</span> for <span class="font-semibold">${{ payment.amount}}</span> ?
                    </DialogDescription>
                </DialogHeader>

                <div class="grid grid-cols-1 gap-12 mt-12">

                    <div class="grid gap-2">
                        <Label for="amount">Payment Amount</Label>
                        <Input
                            id="amount"
                            type="number"
                            :tabindex="1"
                            autofocus
                            v-model="form.amount"
                        />
                        <InputError :message="form.errors.amount" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="user_notes">
                            User Notes (sending account)
                       </Label>
                        <Input
                            id="user_notes"
                            type="text"
                            :tabindex="2"
                            disabled
                            v-model="form.user_notes"
                        />
                        <InputError :message="form.errors.user_notes" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="received" class="flex items-center space-x-3 text-gray-600 cursor-pointer">
                        <Checkbox id="received" v-model:checked="form.received" :tabindex="3" />
                        <span>Payment has been received</span>
                    </Label>
                        <InputError :message="form.errors.user_notes" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="admin_notes">
                            Admin Notes
                       </Label>
                        <Textarea
                            id="admin_notes"
                            type="text"
                            :tabindex="4"
                            v-model="form.admin_notes"
                        />
                        <InputError :message="form.errors.admin_notes" />
                    </div>
                </div>



                <DialogFooter class="gap-2 sm:justify-between">
                    <DialogClose as-child>
                        <Button variant="outline"  :tab-index="6"> Cancel </Button>
                    </DialogClose>

                    <Button
                        type="submit"
                        variant="default"
                        :disabled="form.processing"
                        :tab-index="5">
                        Save
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>

<script setup lang="ts">
import DeletePayment from '@/pages/payment/DeletePayment.vue';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { type SharedData, type User } from '@/types';
import { computed, ref } from 'vue';
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

const props = defineProps([
    'payment',
    'attendees',
]);

const page = usePage<SharedData>();
const user = page.props.auth.user as User;


const open = ref(false)
const form = useForm({...props.payment, received: props.payment.received_at !== null})

const submit = () => {
    form.post(route('admin.payments.update', props.payment), {
        preserveScroll: true,
        onSuccess: open.value = false,
    });
};
</script>
