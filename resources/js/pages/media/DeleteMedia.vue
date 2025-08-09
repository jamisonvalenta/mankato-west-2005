<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <div class="z-10 absolute right-0 bottom-0 bg-white/60  hover:bg-white/80 cursor-pointer p-1 rounded-md">
                <CircleX class="h-5 w-5  text-red-600 hover:text-red-500 " :tabindex="9" aria-title="Delete" title="Delete Image"/>
            </div>
        </DialogTrigger>

        <DialogContent class="max-w-md">
            <DialogHeader>
                <DialogTitle>
                        Delete Image
                </DialogTitle>
                <DialogDescription class="text-sm my-4">
                    You are about to delete this image
                </DialogDescription>
            </DialogHeader>

            <DialogFooter class="grid grid-cols-2 gap-4 sm:gap-8 sm:gap-2 sm:flex sm:justify-between">
                <DialogClose as-child >
                    <Button variant="outline" class="" :tabindex="11"> Cancel </Button>
                </DialogClose>

                <Button
                    variant="destructive"
                    @click="deleteImage"
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
import { LoaderCircle, CircleX } from 'lucide-vue-next';
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
    'media',
]);

const form = useForm(props.media)
const open = ref(false)
const emit = defineEmits(['deleted'])


const deleteImage = () => {
    form.delete(route('media.destroy', props.media), {
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
