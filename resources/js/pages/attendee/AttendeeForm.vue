<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button :variant="isUpdating ? 'outline' : 'default'">
                <template v-if="isUpdating">
                    Edit
                </template>
                <template v-else>
                    <Plus class="h-5 w-5" /> Add Attendee
                </template>
            </Button>
        </DialogTrigger>

        <DialogContent>
            <DialogHeader>
                <DialogTitle>
                    <template v-if="isUpdating">
                        Edit Attendee
                    </template>
                    <template v-else>
                        Create Attendee
                    </template>
                </DialogTitle>
                <DialogDescription class="text-sm my-4">
                    You are welcome to modify these details after submission.
                </DialogDescription>
            </DialogHeader>

            <form class="space-y-6"
                @submit.prevent="save"
                >
                <div class="grid grid-cols-1 gap-8">

                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input
                            id="name"
                            type="text"
                            :tabindex="1"
                            autocomplete="name"
                            v-model="form.name"
                        />
                        <InputError :message="form.errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="nametag">
                            Name for Name Tag
                            <div class="mt-2  text-xs text-gray-500 font-regular">if different from name</div>
                        </Label>
                        <Input
                            id="nametag"
                            type="text"
                            :tabindex="2"
                            v-model="form.nametag"
                        />
                        <InputError :message="form.errors.nametag" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="accommodation_requests">
                            Accomodation Requests:
                            <div class="mt-2  text-xs text-gray-500 font-regular">
                               allergies, dietary restrictions, and accessibility needs
                           </div>
                           </Label>
                        <Textarea
                            id="accommodation_requests"
                            :tabindex="3"
                            v-model="form.accommodation_requests"
                            class=""
                            placeholder="n/a"
                        />
                        <InputError :message="form.errors.accommodation_requests" />
                    </div>

                    <hr>

                    <h4 class="text-lg">
                        Emergency Contact
                    </h4>
                    <div class="grid gap-2">
                        <Label for="emergency_contact_name">
                            Name *
                        </Label>
                        <Input
                            id="emergency_contact_name"
                            type="emergency_contact_name"
                            :tabindex="4"
                            v-model="form.emergency_contact_name"
                        />
                        <InputError :message="form.errors.emergency_contact_name" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="emergency_contact_phone">
                            Phone *
                        </Label>
                        <Input
                            id="emergency_contact_phone"
                            type="emergency_contact_phone"
                            :tabindex="5"
                            v-model="form.emergency_contact_phone"
                        />
                        <InputError :message="form.errors.emergency_contact_phone" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="emergency_contact_relationship">
                            Relationship
                        </Label>
                        <Input
                            id="emergency_contact_relationship"
                            type="emergency_contact_relationship"
                            :tabindex="6"
                            v-model="form.emergency_contact_relationship"
                        />
                        <InputError :message="form.errors.emergency_contact_relationship" />
                    </div>

                </div>

                <DialogFooter class="gap-6 sm:gap-2 sm:justify-between">
                    <div class="grid grid-cols-2 gap-4">
                        <DeleteAttendee
                            :attendee="attendee"
                            @deleted="closeModal()"
                            />
                        <DialogClose as-child >
                            <Button variant="outline" @click="closeModal" :tabindex="8" class=""> Cancel </Button>
                        </DialogClose>
                    </div>

                    <div class="grid grid-cols-1">
                        <Button
                            variant="default"
                            :disabled="form.processing"
                            :tabindex="7"
                            >
                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                            <button type="submit">Save</button>
                        </Button>
                    </div>

                </DialogFooter>
        </form>

        </DialogContent>
    </Dialog>


</template>

<script setup lang="ts">
import DeleteAttendee from '@/pages/attendee/DeleteAttendee.vue';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { LoaderCircle, Plus } from 'lucide-vue-next';
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
    'open',
]);

const form = useForm(props.attendee)
const open = ref(false)

const isUpdating = computed( () => props.attendee.id !== null )

const save = () => {
    if (isUpdating.value === true) {
        form.post(route('attendee.update', props.attendee), {
            onSuccess: () =>  closeModal(),
        });
    } else {
        form.post(route('attendee.store'), {
            onSuccess: () =>  closeModal(),
        });
    }
};

const closeModal = () => {
    form.clearErrors()
    open.value = false
};
</script>
