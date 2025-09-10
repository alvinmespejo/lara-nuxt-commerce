<script setup lang="ts">
import { useCart } from '~/stores/cart';

const { data: user, status, signOut } = useAuth();
const cartStore = useCart()

const isAuthenticated = computed(() => {
  return status.value === 'authenticated' || status.value === 'loading';
});

const name = computed(() => user.value?.name);

const signout = () => {
  signOut({ callbackUrl: '/' });
};
</script>

<template>
  <header class="bg-white text-gray-800 shadow-md sticky top-0 z-50 border-b border-gray-200">
    <div class="container mx-auto flex p-3 justify-between items-center flex-wrap">
      <NuxtLink to="/" class="text-3xl font-extrabold tracking-tight text-sky-500 rounded-lg">
        DevShop
      </NuxtLink>

      <div
        class="hidden md:flex md:flex-grow md:justify-between md:items-center w-full md:w-auto mt-4 md:mt-0 space-y-4 md:space-y-0 md:space-x-8 ml-6 h-full">
        <nav>
          <ul class="flex flex-col md:flex-row md:space-x-6 space-y-2 md:space-y-0 font-medium text-lg text-gray-700">
            <li>
              <NuxtLink to="#">Home One</NuxtLink>
            </li>
            <li>
              <NuxtLink to="#">Home Two</NuxtLink>
            </li>
            <li>
              <NuxtLink to="#">Home Three</NuxtLink>
            </li>
          </ul>
        </nav>
        <!-- Search Bar -->
        <!-- <div class="relative w-full md:w-64">
                <input type="text" placeholder="Search..." class="w-full pl-10 pr-4 py-2 rounded-full bg-gray-100 text-gray-800 placeholder-gray-500 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div> -->
        <!-- Auth Buttons -->
        <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
          <template v-if="!isAuthenticated">
            <button class="btn-primary">
              <NuxtLink :to="{ name: 'auth-signin' }">Sign In</NuxtLink>
            </button>
            <button class="btn-secondary">
              <NuxtLink :to="{ name: 'auth-signup' }">Sign Up</NuxtLink>
            </button>
          </template>
          <template v-else>
            <nav>
              <ul
                class="flex flex-col md:flex-row md:space-x-6 space-y-2 md:space-y-0 font-medium text-lg text-gray-700">
                <li>
                  {{ name }}
                </li>
                <li>
                  <NuxtLink to="/orders">Orders</NuxtLink>
                </li>
                <li>
                  <NuxtLink to="/cart">Cart ({{ cartStore.getCartCount }})</NuxtLink>
                </li>
                <li>
                  <button class="hover:cursor-pointer" @click.prevent="signout">
                    Signout
                  </button>
                </li>
              </ul>
            </nav>
          </template>
        </div>
      </div>
    </div>
  </header>
</template>
