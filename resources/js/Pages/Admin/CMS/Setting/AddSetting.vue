<script setup>
import { ref, reactive } from 'vue';
import { router } from '@inertiajs/vue3';

const form = reactive({
    nama: '',
    deskripsi: '',
    footer: '',
    image: null,
});

function submit() {
    const formData = new FormData();
    formData.append('nama', form.nama);
    formData.append('deskripsi', form.deskripsi);
    formData.append('footer', form.footer);

    if (form.image) {
        formData.append('image', form.image);
    }

    router.post('/cms-setting', formData);
}
</script>

<template>
    <div class="flex min-h-screen bg-gray-100 overflow-hidden">
        <div class="flex-1 overflow-y-auto">
            <div class="container mx-auto p-4 md:p-5">
                <div class="bg-white rounded-lg p-3">
                    <h1 class="mb-1 text-xl font-semibold">Tambah CMS Setting</h1>
                    <hr class="mb-4">
                    <form @submit.prevent="submit">
                        <div class="flex justify-between items-center mb-3">
                            <label class="w-1/3 font-medium text-gray-700">Nama</label>
                            <input type="text" v-model="form.nama"
                                class="w-2/3 border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-500 shadow-sm" />
                        </div>
                        <div class="flex justify-between items-center mb-3">
                            <label class="w-1/3 font-medium text-gray-700">Deskripsi</label>
                            <textarea v-model="form.deskripsi"
                                class="w-2/3 border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-500 shadow-sm"></textarea>
                        </div>
                        <div class="flex justify-between items-center mb-3">
                            <label class="w-1/3 font-medium text-gray-700">Footer</label>
                            <input type="text" v-model="form.footer"
                                class="w-2/3 border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-500 shadow-sm" />
                        </div>
                        <div class="flex justify-between items-center mb-3">
                            <label class="w-1/3 font-medium text-gray-700">Image</label>
                            <input type="file" @change="event => form.image = event.target.files[0]"
                                class="w-2/3 border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-green-500 shadow-sm" />
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
