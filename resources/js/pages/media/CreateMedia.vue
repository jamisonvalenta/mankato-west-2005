<template>
    <Head title="Upload Media"/>

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col rounded-xl p-4">
            <Heading
                    class="mt-4 md:mt-8"
                    title="Upload Photos"
                />

            <fieldset class="">
                <legend class="text-base font-semibold text-gray-500 capitalize">Select a gallery</legend>
                <div class="mt-6 grid grid-cols-1 gap-y-6 sm:grid-cols-3 sm:gap-x-4">
                    <label
                        v-for="gallery in galleries"
                        :key="gallery.key"
                        :aria-label="gallery.title"
                        :aria-description="`${gallery.description}`"
                        class="group relative flex rounded-lg border border-gray-300 bg-white p-4 has-[:checked]:outline has-[:focus-visible]:outline has-[:checked]:outline-2 has-[:focus-visible]:outline-[3px] has-[:checked]:-outline-offset-2 has-[:focus-visible]:-outline-offset-1 has-[:checked]:outline-indigo-600 has-[:checked]:bg-indigo-50"
                        >
                    <input
                        type="radio"
                        name="gallery"
                        v-model="galleryModel"
                        :value="gallery.key"
                        :checked="gallery === galleries[0]"
                        class="absolute inset-0 appearance-none focus:outline focus:outline-0"
                        />
                    <div class="flex-1">
                        <span class="block text-sm font-medium text-gray-900">{{ gallery.title }}</span>
                        <span class="mt-1 block text-sm text-gray-600">{{ gallery.description }}</span>
                        <span class="mt-6 block text-sm font-medium text-gray-900">{{ gallery.users }}</span>
                    </div>
                    <CircleCheck class="invisible size-5 text-indigo-600 group-has-[:checked]:visible" aria-hidden="true" />
                    </label>
                </div>
            </fieldset>


            <div class="my-8" >
                <Toast />
                <FileUpload
                    name="files[]"
                    :url="route('media-batch.store')"
                    @upload="onTemplatedUpload($event)"
                    @before-send="setHeadersAndFormData"
                    @error="setError"
                    :multiple="true"
                    accept="image/*"
                    :maxFileSize="10000000"
                    @select="onSelectedFiles"
                    >
                    <template #header="{ chooseCallback, uploadCallback, clearCallback, files, messages }">
                        <div class="flex flex-wrap justify-between items-center flex-1 gap-4">
                            <div class="flex gap-2">
                                <Button @click="chooseCallback()" rounded outlined severity="secondary">
                                    Choose Files
                                    <Images class=" text-gray-700"/>
                                </Button>
                                <Button @click="uploadEvent(uploadCallback)" rounded outlined severity="success" :disabled="!files || files.length === 0">
                                    Upload
                                    <CloudUpload class=" text-green-700"/>
                                </Button>
                                <Button @click="clearCallback()" rounded outlined severity="danger" :disabled="!files || files.length === 0">
                                    Clear
                                    <X class=" text-red-500"/>
                                </Button>
                            </div>
                            <div
                                v-if="messages && messages.length"
                                class="flex items-center justify-center flex-col"
                                >
                                <p
                                    v-for="message in messages"
                                    class="text-red-600"
                                    >
                                    {{ message }}
                                </p>

                            </div>
                            <ProgressBar :value="totalSizePercent" :showValue="false" class="md:w-20rem h-1 w-full md:ml-auto">
                                <span class="whitespace-nowrap">{{ totalSize }}B / 1Mb</span>
                            </ProgressBar>
                        </div>
                    </template>
                    <template #content="{ files, uploadedFiles, removeUploadedFileCallback, removeFileCallback }">
                        <div class="flex flex-col gap-8 pt-4">
                            <div v-if="files.length > 0">
                                <h5>Pending</h5>
                                <div class="flex flex-wrap gap-4">
                                    <div v-for="(file, index) of files" :key="file.name + file.type + file.size" class="p-8 rounded-border flex flex-col border border-surface items-center gap-4">
                                        <div>
                                            <img role="presentation" :alt="file.name" :src="file.objectURL" width="100" height="50" />
                                        </div>
                                        <span class="font-semibold text-ellipsis max-w-60 whitespace-nowrap overflow-hidden">{{ file.name }}</span>
                                        <div>{{ formatSize(file.size) }}</div>
                                        <Badge value="Pending" severity="warn" />
                                        <Button icon="pi pi-times" @click="onRemoveTemplatingFile(file, removeFileCallback, index)" outlined rounded severity="danger" >
                                            <X class=" text-red-500"/>
                                        </Button>
                                    </div>
                                </div>
                            </div>

                            <div v-if="uploadedFiles.length > 0">
                                <h5>Completed</h5>
                                <div class="flex flex-wrap gap-4">
                                    <div v-for="(file, index) of uploadedFiles" :key="file.name + file.type + file.size" class="p-8 rounded-border flex flex-col border border-surface items-center gap-4">
                                        <div>
                                            <img role="presentation" :alt="file.name" :src="file.objectURL" width="100" height="50" />
                                        </div>
                                        <span class="font-semibold text-ellipsis max-w-60 whitespace-nowrap overflow-hidden">{{ file.name }}</span>
                                        <div>{{ formatSize(file.size) }}</div>
                                        <Badge value="Completed" class="mt-4" severity="success" />
                                        <Button @click="removeUploadedFileCallback(index)" outlined rounded severity="danger">
                                            <X class=" text-red-500"/>
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template #empty>
                        <div class="flex items-center justify-center flex-col">
                            <CloudUpload class="rounded-full border-2 text-gray-300 h-24 w-24 p-4"/>
                            <p class="mt-6 mb-0">Drag and drop files here</p>
                        </div>
                    </template>

                </FileUpload>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3'
import { usePrimeVue } from 'primevue/config';
import Toast from 'primevue/toast';
import Badge from 'primevue/badge';
import ProgressBar from 'primevue/progressbar';
import { useToast } from "primevue/usetoast";
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import RegistrationForm from "./RegistrationForm.vue";
import Button from "primevue/button"
import FileUpload from 'primevue/fileupload';
import { CloudUpload, Images, X, CircleCheck } from 'lucide-vue-next';

const $primevue = usePrimeVue();
const toast = useToast();

const totalSize = ref(0);
const totalSizePercent = ref(0);
const files = ref([]);


const props = defineProps([
    'galleries',
])

const galleryModel = ref('archive');

const page = usePage()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
    },
    {
        title: 'Your Photos',
        href: route('media.index'),
    },
    {
        title: 'Upload Photos',
        href: route('media.create'),
    },
];

const onRemoveTemplatingFile = (file, removeFileCallback, index) => {
    removeFileCallback(index);
    totalSize.value -= parseInt(formatSize(file.size));
    totalSizePercent.value = totalSize.value / 10;
};

const onClearTemplatingUpload = (clear) => {
    clear();
    totalSize.value = 0;
    totalSizePercent.value = 0;
};

const onSelectedFiles = (event) => {
    files.value = event.files;
    files.value.forEach((file) => {
        totalSize.value += parseInt(formatSize(file.size));
    });
};

const setHeadersAndFormData = (event) => {
    event.xhr.setRequestHeader('X-CSRF-TOKEN', page.props.auth.csrfToken)
    event.formData.append('gallery', galleryModel.value)
}

const uploadEvent = (callback) => {
    totalSizePercent.value = totalSize.value / 10;
    callback();
};

const setError = (event) => {
    totalSizePercent.value = totalSize.value / 10;
    callback();
};

const updateGallery = (event) => {
    console.log(event.target.value)
};

const onTemplatedUpload = () => {
    toast.add({ severity: "info", summary: "Success", detail: "File Uploaded", life: 3000 });
};

const formatSize = (bytes) => {
    const k = 1024;
    const dm = 3;
    const sizes = $primevue.config.locale.fileSizeTypes;

    if (bytes === 0) {
        return `0 ${sizes[0]}`;
    }

    const i = Math.floor(Math.log(bytes) / Math.log(k));
    const formattedSize = parseFloat((bytes / Math.pow(k, i)).toFixed(dm));

    return `${formattedSize} ${sizes[i]}`;
};
</script>
