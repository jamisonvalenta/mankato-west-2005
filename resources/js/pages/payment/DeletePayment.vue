<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button variant="destructive" :tabindex="9" class=""> Delete </Button>
        </DialogTrigger>

        <DialogContent class="max-w-md">
            <DialogHeader>
                <DialogTitle>
                        Delete Payment
                </DialogTitle>
                <DialogDescription class="text-sm my-4">
                    You are about to delete this payment
                </DialogDescription>
            </DialogHeader>

            <DialogFooter class="grid grid-cols-2 gap-4 sm:gap-8 sm:gap-2 sm:flex sm:justify-between">
                <DialogClose as-child >
                    <Button variant="outline" class="" :tabindex="11"> Cancel </Button>
                </DialogClose>

                <Button
                    variant="destructive"
                    @click="deletePayment"
                    :disabled="form.processing"
                    :tabindex="12"
                    >
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Delete
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { LoaderCircle } from 'lucide-vue-next';
import { type SharedData, type User } from '@/types';

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
]);

const form = useForm(props.payment)
const open = ref(false)
const emit = defineEmits(['deleted'])


const deletePayment = () => {
    form.delete(route('payments.destroy', props.payment), {
        preserveScroll: true,
        onSuccess: () => closeModals(),
    });
};

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

const closeModals = () => {
    open.value = false
    emit('deleted')
};

</script>
