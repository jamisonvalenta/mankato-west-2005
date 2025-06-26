<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button variant="destructive" :tabindex="9" class=""> Delete </Button>
        </DialogTrigger>

        <DialogContent class="max-w-md">
            <DialogHeader>
                <DialogTitle>
                        Delete Attendee
                </DialogTitle>
                <DialogDescription class="text-sm my-4">
                    You are about to delete this attendee from the 2025 Reunion.
                </DialogDescription>
            </DialogHeader>

            <DialogFooter class="grid grid-cols-2 gap-4 sm:gap-8 sm:gap-2 sm:flex sm:justify-between">
                <DialogClose as-child >
                    <Button variant="outline" class="" :tabindex="11"> Cancel </Button>
                </DialogClose>

                <Button
                    variant="destructive"
                    @click="deleteAttendee"
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
    'attendee',
    'postRoute',
    '_method',
]);

const form = useForm(props.attendee)
const open = ref(false)
const emit = defineEmits(['onDrag'])


const deleteAttendee = () => {
    form.delete(route('attendee.destroy', props.attendee.id), {
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
