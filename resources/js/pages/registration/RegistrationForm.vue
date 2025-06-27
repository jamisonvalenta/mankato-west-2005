<template>
    <div class="p-4 max-w-[800px]">
        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <p class="my-4"> This form will be used to collect information about you to help us verify you graduated with our class.</p>

        <p class="my-4">After completing this form, a committee member will review your submission and will be able to mark your registration as complete. You will then be able to fill out your attendance form and pay.</p>

        <p>You do not need to plan to attend in order to register and be verified. We're hoping this site can be a place where you can reconnect and know where your classmates are now, separate from social media.</p>

        <p class="my-4"><span class="font-bold">We value your privacy.</span> We will not reveal your contact information (phone, email) to anyone other than the reunion committee. If we need additional information to verify your identity, we will use this information to contact you.</p>

        <p class="my-4">You are welcome to modify these details after submission.</p>

        <form @submit.prevent="submit" class="flex flex-col gap-6 mt-24">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">

                <div class="grid gap-2">
                    <Label for="name">Full Name</Label>
                    <Input
                        id="name"
                        type="text"
                        disabled
                        v-model="form.name"
                    />
                    <span class="text-sm italic text-gray-500">to modify go to
                        <TextLink
                            :href="route('profile.edit')"
                        >user settings</TextLink>
                    </span>
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="original_name">2005 Full Name <span class="italic">(if different from current name)</span></Label>
                    <Input
                        id="original_name"
                        type="text"
                        :tabindex="1"
                        autocomplete="name"
                        v-model="form.original_name"
                    />
                    <InputError :message="form.errors.original_name" />
                </div>

                <div class="grid gap-2">
                    <Label for="phone">Phone Number (not published)</Label>
                    <Input
                        id="phone"
                        type="phone"
                        :tabindex="2"
                        autocomplete="name"
                        v-model="form.phone"
                    />
                    <InputError :message="form.errors.phone" />
                </div>

                <div class="grid gap-2">
                    <Label for="city">City</Label>
                    <Input
                        id="city"
                        type="city"
                        :tabindex="3"
                        autocomplete="city"
                        v-model="form.city"
                    />
                    <InputError :message="form.errors.city" />
                </div>

                <div class="grid gap-2">
                    <Label for="state">State</Label>
                    <Input
                        id="state"
                        type="state"
                        :tabindex="4"
                        autocomplete="state"
                        v-model="form.state"
                    />
                    <InputError :message="form.errors.state" />
                </div>

                <div class="grid gap-2">
                    <Label for="country">Country</Label>
                    <Input
                        id="country"
                        type="country"
                        :tabindex="5"
                        autocomplete="country"
                        v-model="form.country"
                    />
                    <InputError :message="form.errors.country" />
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 mt-8">
                <div class="grid gap-2">
                    <Label for="bio">Bio (a few sentences, what have you been up to?)</Label>
                    <Textarea
                        id="bio"
                        :tabindex="5"
                        autocomplete="bio"
                        v-model="form.bio"
                        class=""
                    />
                    <InputError :message="form.errors.bio" />
                </div>

                <div class="flex items-center justify-between " >
                    <Label for="show_attendance" class="flex items-center space-x-3 text-gray-600">
                        <Checkbox id="show_attendance" v-model:checked="form.show_attendance" :tabindex="6" />
                        <span>I give my permission to publish my name, original name, and bio to other verified registrants</span>
                    </Label>
                </div>
            </div>

            <Button type="submit" class="mt-4 w-full md:max-w-[30em]" :disabled="form.processing" :tabindex="7">
                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                Save
            </Button>
        </form>
    </div>
</template>

<script setup lang="ts">
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

const props = defineProps([
    'registration',
    'postRoute',
    '_method',
    'successMessage',
    'status',
]);

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

const formData = {
    original_name: props.registration.original_name,
}

const form = useForm({
    name: user.name,
    original_name: props.registration.original_name,
    show_attendance: props.registration.show_attendance,
    phone: props.registration.phone,
    city: props.registration.city,
    state: props.registration.state,
    country: props.registration.country,
    bio: props.registration.bio,
});

const submit = () => {
    form.post(route('registration.store'), {
        // onFinish: () => form.reset('password'),
    });
};
</script>
