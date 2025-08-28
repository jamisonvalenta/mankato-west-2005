<template>
    <Dialog v-model:open="open" class="max-h-full">
        <DialogTrigger as-child>
            <div class="z-10 absolute left-0 bottom-0 bg-white/60  hover:bg-white/80 cursor-pointer p-1 rounded-md">
                <Pencil
                    class="h-5 w-5 text-gray-600 hover:text-green-600 "
                    :tabindex="8"
                    aria-title="Edit Image Description"
                    title="Edit Image Description"
                />
            </div>
        </DialogTrigger>

        <DialogContent class="max-w-xl">
            <DialogHeader>
                <DialogTitle>
                    Edit Image Description
                </DialogTitle>
            </DialogHeader>

            <form @submit.prevent="submit" class="flex flex-col gap-6 mt-24">
                <div class="grid grid-cols-1 gap-12">
                    <AdvancedImage
                        :cldImg="cld.image(media.cloudinary_public_id)"
                        :plugins="plugins"
                        className="rounded-lg w-full"
                    />
                    <div class="grid grid-cols-1 gap-2">
                        <Label for="description">Image Description</Label>
                        <TextArea
                            id="description"
                            type="text"
                            v-model="form.description"
                        />
                        <InputError :message="form.errors.description" />
                    </div>
                </div>
            </form>

            <DialogFooter class="grid grid-cols-2 gap-4 sm:gap-8 sm:gap-2 sm:flex sm:justify-between">
                <DialogClose as-child >
                    <Button variant="outline" class="" :tabindex="11"> Cancel </Button>
                </DialogClose>


                <Button
                    variant="destructive"
                    @click="editImage"
                    :disabled="form.processing"
                    :tabindex="12"
                    >
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Save
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<script setup lang="ts">
import { Button } from '@/components/ui/button';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Textarea } from '@/components/ui/textarea';
import { Label } from '@/components/ui/label';
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { LoaderCircle, Pencil } from 'lucide-vue-next';
import { type SharedData, type User } from '@/types';
import { AdvancedImage, placeholder, responsive } from '@cloudinary/vue';
import { thumbnail } from "@cloudinary/url-gen/actions/resize";
import { Cloudinary } from '@cloudinary/url-gen';

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

const page = usePage<SharedData>();

// Create a Cloudinary instance and set your cloud name.
const cld = new Cloudinary({
  cloud: {
    cloudName: page.props.cloudinary.cloud_name,
  },
});
const plugins = [
    responsive({steps: [360, 750, 1200]}),
    placeholder({mode: 'blur'})
]

const form = useForm(props.media)
const open = ref(false)
const emit = defineEmits(['deleted'])


const editImage = () => {
    form.post(route('media.update', props.media.id), {
        preserveScroll: true,
        onSuccess: () => closeModals(),
    });
};

const user = page.props.auth.user as User;

const closeModals = () => {
    open.value = false
    emit('edited')
};

</script>
