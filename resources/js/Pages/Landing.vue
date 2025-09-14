<script setup>
import Navbar from '../includes/Navbar.vue';
import Footer from '../includes/Footer.vue';
import { ref, computed } from 'vue';


const packages = [
  { id: 1, name: "Bali, Indonesia", price: "Rp 5.000.000", image: "/img/pecel.jpg" },
  { id: 2, name: "Tokyo, Jepang", price: "Rp 12.000.000", image: "/img/pantai.jpg" },
  { id: 3, name: "Paris, Prancis", price: "Rp 15.000.000", image: "/img/sore.jpg" },
  { id: 4, name: "New York, Amerika Serikat", price: "Rp 20.000.000", image: "/img/hutan.jpg" },
  { id: 5, name: "Sydney, Australia", price: "Rp 10.000.000", image: "/img/hutan.jpg" },
  { id: 6, name: "Seoul, Korea Selatan", price: "Rp 8.000.000", image: "/img/sore.jpg" },
  { id: 7, name: "Bangkok, Thailand", price: "Rp 6.000.000", image: "/img/pantai.jpg" },
  { id: 8, name: "Roma, Italia", price: "Rp 18.000.000", image: "/img/pecel.jpg"},
];

const currentIndex = ref(0);
const itemsPerSlide = 3;

const props = defineProps({
  setting: Object,  // atau Array, tergantung struktur data
});

const groupedPackages = computed(() => {
  return packages.reduce((acc, cur, index) => {
    if (index % itemsPerSlide === 0) acc.push([]);
    acc[acc.length - 1].push(cur);
    return acc;
  }, []);
});

const totalSlides = computed(() => groupedPackages.value.length);


const nextSlide = () => {
  currentIndex.value = (currentIndex.value + 1) % totalSlides.value;
};

const prevSlide = () => {
  currentIndex.value = (currentIndex.value - 1 + totalSlides.value) % totalSlides.value;
};
</script>


<template>
  <Navbar />
  <div class="min-h-screen bg-white flex flex-col items-center">
    <!-- Hero Section -->
    <section 
    class="relative w-screen h-screen flex flex-col items-center justify-center text-black text-center px-6 bg-cover bg-center" 
    style="background-image: url('/img/pacitanpantai.jpg');"
  >
    <h1 class="text-4xl text-white font-bold p-2 m-2">Liburan Bersama Iconic</h1>
    <p class="mt-3 text-white text-lg p-2 m-2">Liburan menyenangkan bersama iconic .
       Promo tersedia untuk paket wisata ke bromo.
        bisa bersama keluarga ataupun rekan kerja</p>
    <button class="px-4 py-2 my-2 flex cursor-pointer items-center rounded-md
      border-2 border-black bg-white font-bold text-black
      shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transition-all hover:translate-x-[4px]
      hover:translate-y-[4px] hover:shadow-none">
      Cek Paket Wisata
    </button>
  </section>


  <section>
    <!-- Carousel -->
    <div class="relative w-[80%] h-screen max-w-screen mx-auto overflow-hidden py-4">
      <!-- Carousel Wrapper -->
      <div class="flex transition-transform duration-500 ease-in-out w-full"
           :style="{ transform: `translateX(-${currentIndex * 100}%)` }">
        <div v-for="group in groupedPackages" :key="group[0].id" class="flex min-w-full">
          <div v-for="pkg in group" :key="pkg.id" class="w-1/3 px-5 py-4">
            <div class="bg-[#3B93D6] text-white border-2 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]
                        px-4 py-2 my-2 flex flex-col items-center rounded-md transition-all
                        hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none">
              <img :src="pkg.image" :alt="pkg.name" class="w-full h-64 object-cover rounded-lg">
              <h3 class="text-lg font-bold mt-2">{{ pkg.name }}</h3>
              <p class="text-gray-200">{{ pkg.price }}</p>
              <button class="px-4 py-2 my-2 flex cursor-pointer items-center rounded-md
              border-3 border-black bg-white font-bold text-black
              shadow-[5px_5px_0px_0px_rgba(0,0,0,1)] transition-all hover:translate-x-[4px]
              hover:translate-y-[4px] hover:shadow-none">
                Lihat Detail
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Navigation Buttons -->
      <button @click="prevSlide" class="absolute left-5 top-1/3 transform -translate-y-1/2 bg-black text-white px-3 py-1 rounded-full">❮</button>
      <button @click="nextSlide" class="absolute right-5 top-1/3 transform -translate-y-1/2 bg-black text-white px-3 py-1 rounded-full">❯</button>
    </div>

    <!-- Testimoni -->
     <div class="h-screen w-screen">
      <h2 class="text-3xl font-bold text-center mb-8">Testimoni Pelanggan</h2>
      <div class="container mx-auto px-6 text-center">
        <p class="text-lg italic">"Layanan sangat profesional, perjalanan jadi lebih menyenangkan!"</p>
        <p class="mt-3 font-bold">- Rina, Jakarta</p>
      </div>
    </div>
    </section>
  </div>
  <Footer />
</template>

