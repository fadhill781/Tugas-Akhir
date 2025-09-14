<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import sidebar from '@/includes/Sidebar.vue';
import { computed } from 'vue';


const props = defineProps({
  settings: Array,
});

const sidebarOpen = ref(true);
const currentPage = ref(1);
const perPage = ref(10);
const searchQuery = ref('');

const filteredSetting = computed(() => {
    if (!searchQuery.value) return props.settings;

    return props.settings.filter(settings =>
        settings.nama.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const totalPages = computed(() => Math.ceil(filteredSetting.value.length / perPage.value));

const paginatedSetting = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;
    return filteredSetting.value.slice(start, end);
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

function goToCreate() {
  router.get('/CMS/Setting/AddSetting');
}

function goToEdit(id) {
  router.get(`/CMS/Setting/${id}/edit`);
}

function destroy(id) {
  if (confirm('Apakah Anda yakin ingin menghapus setting ini?')) {
    router.delete(`/CMS/Setting/${id}`, {
      preserveScroll: true,
    });
  }
}
</script>

<template>
  <div class="flex min-h-screen bg-gray-100 overflow-hidden">
    <sidebar :sidebarOpen="sidebarOpen" @toggle="sidebarOpen = !sidebarOpen" />

    <div
      :class="[
        'transition-all duration-300 ease-in-out overflow-y-auto',
        sidebarOpen ? 'pl-64' : 'pl-16',
        'flex-1 p-6 bg-white rounded-lg shadow-md max-w-7xl mx-auto mt-6',
      ]"
    >
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">CMS Settings</h1>
        <button
          @click="goToCreate"
          class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md transition duration-200"
        >
          Tambah Setting
        </button>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
          <thead class="bg-blue-500">
            <tr>
              <th class="text-left px-6 py-3 border-b border-gray-300">Nama</th>
              <th class="text-left px-6 py-3 border-b border-gray-300">Deskripsi</th>
              <th class="text-left px-6 py-3 border-b border-gray-300">Image</th>
              <th class="text-left px-6 py-3 border-b border-gray-300">Footer</th>
              <th class="text-center px-6 py-3 border-b border-gray-300">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="paginatedSetting.length === 0">
              <td colspan="5" class="text-center px-6 py-4 text-gray-500">
                Belum ada setting.
              </td>
            </tr>
            <tr
              v-for="setting in paginatedSetting"
              :key="setting.id"
              class="hover:bg-gray-50 transition-colors duration-150"
            >
              <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">
                {{ setting.nama }}
              </td>
              <td class="px-6 py-4 border-b border-gray-200 whitespace-normal max-w-xs">
                {{ setting.deskripsi }}
              </td>
              <td class="px-6 py-4 border-b border-gray-200 text-center">
                <img
                  v-if="setting.image"
                  :src="`/storage/${setting.image}`"
                  alt="Image"
                  class="mx-auto w-24 h-auto rounded-md object-cover"
                />
                <span v-else class="text-gray-400">-</span>
              </td>
              <td class="px-6 py-4 border-b border-gray-200 whitespace-normal max-w-xs">
                {{ setting.footer || '-' }}
              </td>
              <td class="px-6 py-4 border-b border-gray-200 text-center space-x-2">
                <button
                  @click="goToEdit(setting.id)"
                  class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md transition duration-150"
                >
                  Edit
                </button>
                <button
                  @click="destroy(setting.id)"
                  class="inline-block bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md transition duration-150"
                >
                  Hapus
                </button>
              </td>
            </tr>
           <tr>
  <td colspan="6" class="p-0">
    <div class="flex items-center justify-between px-4 py-3 bg-blue-500 rounded-b-2xl">
      <div class="flex items-center gap-4">
        <select v-model="perPage" @change="changePerPage($event.target.value)"
          class="bg-white border border-gray-300 rounded px-2 py-1 text-sm">
          <option :value="10">10 per page</option>
          <option :value="25">25 per page</option>
          <option :value="50">50 per page</option>
          <option :value="100">100 per page</option>
        </select>
        <span class="text-sm text-black">
          Showing {{ ((currentPage - 1) * perPage) + 1 }}-{{ Math.min(currentPage * perPage, filteredSetting.length) }} of {{ filteredSetting.length }} items
        </span>
      </div>

      <div class="flex items-center">
        <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1"
          class="p-1 rounded hover:bg-gray-200 disabled:opacity-50 disabled:hover:bg-transparent px-3">
          &lt;
        </button>

        <div class="flex items-center gap-1">
          <button v-for="page in totalPages" :key="page" @click="changePage(page)" :class="[
              'px-3 py-1 rounded',
              currentPage === page ? 'bg-white text-black' : 'hover:bg-gray-200 text-black'
            ]">
            {{ page }}
          </button>
        </div>

        <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages"
          class="p-1 rounded hover:bg-gray-200 disabled:opacity-50 disabled:hover:bg-transparent px-3">
          &gt;
        </button>
      </div>
    </div>
  </td>
</tr>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
