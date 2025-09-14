<template>
  <a
    :href="href"
    class="flex items-center space-x-3 px-4 py-2 rounded-md hover:bg-blue-600 transition-all duration-200"
    :class="[
      active ? activeClass : 'text-gray-800',
      collapsed ? 'justify-center' : ''
    ]"
  >
    <span v-if="!collapsed">{{ label }}</span>
  </a>
</template>

<script setup>
defineProps({
  href: String,
  label: String,
  active: Boolean,
  collapsed: Boolean,
  activeClass: {
    type: String,
    default: 'bg-blue-600 text-white'
  }
});
</script>
