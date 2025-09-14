<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import sidebar from '@/includes/Sidebar.vue';

const props = defineProps({
    pesanan: Array,
});

const sidebarOpen = ref(true);
const currentPage = ref(1);
const perPage = ref(10);
const searchQuery = ref('');

const filteredPesanan = computed(() => {
    if (!searchQuery.value) return props.pesanan;

    return props.pesanan.filter(p =>
        p.nama.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const totalPages = computed(() => Math.ceil(filteredPesanan.value.length / perPage.value));

const paginatedPesanan = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;
    return filteredPesanan.value.slice(start, end);
});

function handleSearch(event) {
    searchQuery.value = event.target.value;
    currentPage.value = 1;
}

function changePage(page) {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
}

function changePerPage(value) {
    perPage.value = value;
    currentPage.value = 1;
}

function show(id) {
    router.get(`/pesanan/${id}/edit`);
}

function destroy(id) {
    if (confirm('Yakin ingin menghapus pesanan ini?')) {
        router.delete(`/pesanan/${id}`);
    }
}
</script>

<template>
    <div class="flex min-h-screen bg-gray-100 overflow-hidden">
        <sidebar :sidebarOpen="sidebarOpen" @toggle="sidebarOpen = !sidebarOpen" />

        <div :class="['transition-all duration-300 ease-in-out overflow-y-auto', sidebarOpen ? 'pl-64' : 'pl-16', 'flex-1']">
            <div class="container mx-auto px-2 md:p-5">
                <h1 class="text-2xl font-bold mb-5">Pesanan</h1>

                <div class="bg-white rounded-lg p-5 shadow">
                    <div class="flex justify-between items-center mb-4">
                        <input type="text" v-model="searchQuery" @input="handleSearch" placeholder="Cari nama pesanan..."
                            class="border border-gray-300 rounded px-4 py-2 w-80" />
                        <button class="bg-blue-600 text-white px-5 py-2 rounded"
                            @click="() => router.get('/add-pesanan')">
                            Tambah Pesanan
                        </button>
                    </div>

                    <table class="min-w-full border-collapse text-center">
                        <thead>
                            <tr class="bg-blue-600 text-black">
                                <th class="px-4 py-3 rounded-tl-2xl">No</th>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Waktu</th>
                                <th class="px-4 py-3">Total</th>
                                <th class="px-4 py-3">Aksi</th>
                                <th class="px-4 py-3 rounded-tr-2xl">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="filteredPesanan.length === 0">
                                <td colspan="6" class="py-4">Tidak ada data pesanan.</td>
                            </tr>
                            <tr v-for="(p, index) in paginatedPesanan" :key="p.id" class="border-t border-gray-300">
                                <td class="py-3">{{ (currentPage - 1) * perPage + index + 1 }}</td>
                                <td class="py-3">{{ p.nama }}</td>
                                <td class="py-3">{{ p.waktu }}</td>
                                <td class="py-3">Rp{{ p.total.toLocaleString('id-ID') }}</td>
                                <td class="py-3">{{ p.aksi || '-' }}</td>
                                <td class="py-3 space-x-2">
                                    <button class="bg-blue-500 text-white px-4 py-1 rounded" @click="() => show(p.id)">Edit</button>
                                    <button class="bg-red-500 text-white px-4 py-1 rounded" @click="() => destroy(p.id)">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="flex items-center justify-between px-4 py-3 bg-blue-600 rounded-b-2xl">
                        <div class="flex items-center gap-4">
                            <select v-model="perPage" @change="changePerPage($event.target.value)"
                                class="bg-white border border-gray-300 rounded px-2 py-1 text-sm">
                                <option :value="10">10 per page</option>
                                <option :value="25">25 per page</option>
                                <option :value="50">50 per page</option>
                                <option :value="100">100 per page</option>
                            </select>
                            <span class="text-sm text-black">
                                Menampilkan {{ ((currentPage - 1) * perPage) + 1 }} - {{ Math.min(currentPage * perPage, props.pesanan.length) }}
                                dari {{ props.pesanan.length }} data
                            </span>
                        </div>

                        <div class="flex items-center space-x-1">
                            <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1"
                                class="px-3 py-1 rounded hover:bg-gray-200 disabled:opacity-50">
                                &lt;
                            </button>
                            <button v-for="page in totalPages" :key="page" @click="changePage(page)"
                                :class="['px-3 py-1 rounded', currentPage === page ? 'bg-white text-black' : 'hover:bg-gray-200 text-black']">
                                {{ page }}
                            </button>
                            <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages"
                                class="px-3 py-1 rounded hover:bg-gray-200 disabled:opacity-50">
                                &gt;
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
