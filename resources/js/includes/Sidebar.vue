<template>
  <div 
    class="bg-white h-screen border-r shadow-md fixed z-50 transition-all duration-300 ease-in-out"
    :class="sidebarOpen ? 'w-64' : 'w-20'"
  >
    <div class="flex justify-center items-center py-6 px-4 relative">
      <img 
        src="/img/logorill.png" 
        class="h-16 w-16 transition-all duration-300" 
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 h-0 w-0'" 
        alt="Logo" 
      />
      <button 
        @click="toggleSidebar" 
        class="text-gray-800 absolute top-6"
        :class="sidebarOpen ? 'right-4' : 'right-8'"
      >
        <i class="las la-bars text-2xl"></i>
      </button>
    </div>

    <nav class="px-4 space-y-2 font-semibold text-gray-800 overflow-hidden mt-2">
      <SidebarLink 
        href="/dashboard" 
        label="Dashboard" 
        icon="las la-home"
        :active="$page.url === '/dashboard'" 
        :collapsed="!sidebarOpen"
      />
      <SidebarLink 
        href="/cms-setting" 
        label="CMS" 
        icon="las la-file-alt"
        :active="$page.url === '/cms'" 
        :collapsed="!sidebarOpen"
      />
      <SidebarLink 
        href="/produk" 
        label="Produk" 
        icon="las la-box-open"
        :active="$page.url === '/produk'" 
        :collapsed="!sidebarOpen"
      />
      <SidebarLink 
        href="/paket-wisata" 
        label="Paket Wisata" 
        icon="las la-umbrella-beach"
        :active="$page.url === '/paket'" 
        :collapsed="!sidebarOpen"
      />
      <SidebarLink 
        href="/mobil" 
        label="Mobil" 
        icon="las la-car"
        :active="$page.url === '/mobil'" 
        :collapsed="!sidebarOpen"
      />
      <SidebarLink 
        href="/pesanan" 
        label="Pesanan" 
        icon="las la-clipboard-list"
        :active="$page.url === '/pesanan'" 
        :collapsed="!sidebarOpen"
      />

      <div>
        <SidebarLink
          href="#"
          label="Transaksi"
          icon="las la-exchange-alt"
          :active="$page.url.startsWith('/transaksi')"
          :collapsed="!sidebarOpen"
        />
        <ul class="ml-4 space-y-1" v-if="sidebarOpen">
          <li>
            <SidebarLink
              href="/admin/transaksi"
              label="Riwayat Transaksi"
              :active="$page.url === '/admin/transaksi'"
              :collapsed="!sidebarOpen"
            />
          </li>
          <li>
            <SidebarLink
              href="/transaksi/tambahtransaksi"
              label="Transaksi Baru"
              :active="$page.url === '/transaksi/tambahtransaksi'"
              :collapsed="!sidebarOpen"
            />
          </li>
        </ul>
      </div>
    </nav>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import SidebarLink from "./SidebarLink.vue";

const props = defineProps({
  sidebarOpen: Boolean
});

const emit = defineEmits(['toggle']);

const toggleSidebar = () => {
  emit('toggle'); 
};


</script>