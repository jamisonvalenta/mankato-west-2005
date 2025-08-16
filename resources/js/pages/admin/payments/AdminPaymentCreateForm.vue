<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button
                variant="outline"
                size="sm"
                >
                <Plus class="w-4 h-4"/>
                <Receipt class="w-4 h-4"/>
            </Button>
        </DialogTrigger>
        <DialogContent>
            <form class="space-y-6"
                @submit.prevent="submit"
                >
                <DialogHeader class="space-y-3">
                    <DialogDescription>
                        Let's add a payment for  <span class="font-semibold">{{ user.registration.name }}</span>:
                    </DialogDescription>
                </DialogHeader>

                <div class="grid grid-cols-1 gap-12 mt-12">

                    <div class="grid gap-2">
                        <Label for="amount">Payment Amount</Label>
                        <Input
                            id="amount"
                            type="number"
                            step=".01"
                            :tabindex="1"
                            autofocus
                            v-model="form.amount"
                        />
                        <InputError :message="form.errors.amount" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="admin_notes">
                            Admin Notes
                       </Label>
                        <Textarea
                            id="admin_notes"
                            type="text"
                            :tabindex="3"p
                            v-model="form.admin_notes"
                        />
                        <InputError :message="form.errors.admin_notes" />
                    </div>
                </div>

                <DialogFooter class="gap-2 sm:justify-between">
                    <div class="grid grid-cols-2 gap-4">
                        <DialogClose as-child>
                            <Button variant="outline"  :tab-index="5"> Cancel </Button>
                        </DialogClose>
                    </div>

                    <Button
                        type="submit"
                        variant="default"
                        :disabled="form.processing"
                        :tab-index="4">
                        Create
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>

<script setup lang="ts">
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
import { Plus, Receipt } from 'lucide-vue-next';

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
    'user',
    'payment',
]);

const page = usePage<SharedData>();
const user = page.props.auth.user as User;


const open = ref(false)
const form = useForm({...props.payment, received:true, amount: null, admin_notes: '',  })

const submit = () => {
    form.post(route('admin.payments.store', props.payment), {
        preserveScroll: true,
        onSuccess: open.value = false,
    });
};
</script>
