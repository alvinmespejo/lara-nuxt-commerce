<script setup lang="ts">
import SigninForm from '~/components/SigninForm.vue';

definePageMeta({
  layout: 'auth',
});
</script>

<template>
  <div class="container mx-auto w-sm mt-20">
    <SigninForm />
  </div>
</template>
