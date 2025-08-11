<script setup lang="ts">
import { Toaster } from '@/components/ui/sonner';
import 'vue-sonner/style.css'

</script>

<template>
  <div>
    <NuxtLoadingIndicator />
    <Toaster :expand="true" close-button rich-colors class="pointer-events-auto" />
    <NuxtLayout>
      <NuxtPage />
    </NuxtLayout>
  </div>
</template>
