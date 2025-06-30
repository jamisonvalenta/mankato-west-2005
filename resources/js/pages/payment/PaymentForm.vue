<template>
    <Dialog v-model:open="open">
            <DialogTrigger as-child>
                <Button :variant="isUpdating ? 'outline' : 'default'" class="mt-4">
                    <template v-if="isUpdating">
                        Edit
                    </template>
                    <template v-else>
                        <Plus class="h-5 w-5" />
                        Add Payment
                    </template>
                </Button>
            </DialogTrigger>

            <DialogContent class="max-w-md">
                <form @submit.prevent="submit" >
                <DialogHeader>
                    <DialogTitle>
                        <template v-if="isUpdating">
                            Edit Payment
                        </template>
                        <template v-else>
                            Add Payment
                        </template>
                    </DialogTitle>
                    <DialogDescription>
                        Refund Policy: In the event you are unable to attend, we can no offer a refund. However, if we have a budget surplus, we may be able to accommodate your following the close of the reunion.
                    </DialogDescription>

                </DialogHeader>

                <div class="grid grid-cols-1 gap-12 mt-12">

                    <div class="grid gap-2">
                        <Label for="amount">Payment Amount</Label>
                        <div class="mt-2  text-xs text-gray-500 font-regular">
                           Any amount between $0 and $150 per attendee is welcome
                       </div>
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
                            Account Sending From
                            <div class="mt-2  text-xs text-gray-500 font-regular">
                               Venmo: @account_name; Check: Account Owner/check number
                           </div>
                       </Label>
                        <Input
                            id="user_notes"
                            type="text"
                            :tabindex="2"
                            v-model="form.user_notes"
                        />
                        <InputError :message="form.errors.user_notes" />
                    </div>
                </div>

                <DialogFooter class="grid grid-cols-2 gap-4 sm:gap-8 sm:gap-2 sm:flex sm:justify-between mt-4">

                    <DeletePayment
                        v-if="isUpdating"
                        :payment="payment"
                        :tabindex="5"
                        @deleted="open = false"
                        />
                    <DialogClose as-child >
                        <Button variant="outline" class="" :tabindex="4"> Cancel </Button>
                    </DialogClose>


                    <Button type="submit" class="col-span-2 md:col-span-1 w-full md:max-w-[15em]" :disabled="form.processing" :tabindex="3">
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
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
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
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

const defaultAmount = computed(() => props.attendees.length * 50);
const isUpdating = computed(() => props.payment.id !== null);

const open = ref(false)
const form = useForm(props.payment)

form.defaults({
  amount: defaultAmount,
})

const submit = () => {
    if (isUpdating) {
        form.post(route('payments.store'), {
            onSuccess:  () => open.value = false
        });
    } else {
        form.post(route('payments.update', props.payment), {});
    }
};
</script>
