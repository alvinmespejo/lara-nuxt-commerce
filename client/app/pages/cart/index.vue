<script setup lang="ts">

//**** Store ****// 
import { useCart } from '~/stores/cart'

const cartStore = useCart();

useHead({
  title: 'Cart',
});
</script>

<template>
  <div class="container mx-auto mt-10">
    <div class="flex">
      <div class="mx-auto w-3/4">
        <div class="mb-4">
          <div v-if="cartStore.getCartCount">
            <p class="font-bold text-2xl">Your Cart</p>
          </div>
          <div v-else>
            <p class="font-bold text-2xl">Your cart is empty</p>
          </div>
        </div>
        <div class="bg-gray-100" v-if="cartStore.getCartCount">
          <CartOverview />
        </div>
        <div class="mt-4">
          <NuxtLink :to="{ name: 'checkout' }" v-if="!cartStore.isEmpty">
            <Button
              class="bg-sky-500 hover:bg-sky-600 cursor-pointer w-full h-10"
              >Checkout</Button
            >
          </NuxtLink>
        </div>
      </div>
    </div>
  </div>
</template>
