<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    pesanan: Object,
});

const form = useForm({
    _method: 'put',
    nama: props.pesanan.nama,
    waktu: props.pesanan.waktu,
    total: props.pesanan.total,
    aksi: props.pesanan.aksi,
});

function submit(id) {
    form.post(`/pesanan/${id}`, {
        preserveScroll: true,
        preserveState: true,
        onError: (errors) => {
            console.error(errors);
        },
    });
}
</script>

<template>
    <div class="flex min-h-screen bg-gray-100 overflow-hidden">
        <div class="flex-1 overflow-y-auto">
            <div class="container mx-auto p-4 md:p-5">
                <div class="bg-white rounded-lg p-3">
                    <h1 class="mb-3 text-xl font-bold">Edit Pesanan</h1>
                    <hr class="mb-4">
                    <form @submit.prevent="submit(pesanan.id)">
                        <div class="mb-3">
                            <label class="block text-gray-700 font-medium mb-1">Nama</label>
                            <input type="text" v-model="form.nama"
                                class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm" />
                        </div>

                        <div class="mb-3">
                            <label class="block text-gray-700 font-medium mb-1">Waktu</label>
                            <input type="date" v-model="form.waktu"
                                class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm" />
                        </div>

                        <div class="mb-3">
                            <label class="block text-gray-700 font-medium mb-1">Total</label>
                            <input type="number" v-model="form.total"
                                class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm" />
                        </div>

                        <div class="mb-3">
                            <label class="block text-gray-700 font-medium mb-1">Aksi</label>
                            <input type="text" v-model="form.aksi"
                                class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 shadow-sm" />
                        </div>

                        <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
