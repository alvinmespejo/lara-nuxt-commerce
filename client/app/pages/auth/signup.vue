<script setup lang="ts">
import SignupForm from '~/components/SignupForm.vue';

definePageMeta({
  layout: 'auth',
});
</script>

<template>
  <div class="container mx-auto w-sm mt-20">
    <SignupForm />
  </div>
</template>
