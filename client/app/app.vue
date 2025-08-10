<script setup lang="ts">
import { Toaster } from 'vue-sonner';

</script>

<template>
  <div>
    <NuxtLoadingIndicator />
    <Toaster
      rich-colors
      close-button
      :expand="true"
    />
    <NuxtLayout>
      <NuxtPage />
    </NuxtLayout>
  </div>
</template>
