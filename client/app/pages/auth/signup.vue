<script setup lang="ts">
import SignupForm from '~/components/SignupForm.vue';

useHead({
    title: 'Sign Up'
})

definePageMeta({
  layout: 'auth',
  auth: {
    unauthenticatedOnly: true,
    navigateAuthenticatedTo: '/dashboard'
  }
});
</script>

<template>
  <div class="min-h-svh flex flex-col items-center justify-center gap-6 p-6 md:p-10">
    <div class="flex w-full max-w-sm flex-col gap-6">
      <NuxtLink to="/" class="flex items-center gap-2 self-center text-3xl font-extrabold text-sky-500">
        DevShop
      </NuxtLink>
      <SignupForm/>
    </div>
  </div>
</template>
