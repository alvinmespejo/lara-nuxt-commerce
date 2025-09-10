<script setup lang="ts">
const empty = ref<boolean>(true);
const isSubmitting = ref<boolean>(false);

const {
  data: response,
  error,
  status,
} = useAsyncData('cart-checkout', async () => {
  const [addresses, paymentMethods] = await Promise.all([
    useFetchAPI<ShippingAddressResponse>(`/addresses`, { method: 'GET' }),
    useFetchAPI<PaymentMethodsResponse>(`/payment-methods`, { method: 'GET' }),
  ]);

  return {
    addresses: addresses.data.value,
    paymentMethods: paymentMethods.data.value,
    addressesErrors: addresses.error.value,
    paymentMethodsErrors: paymentMethods.error.value,
  };
});

const paymentMethods = computed<PaymentMethod[]>(
  () => response.value?.paymentMethods?.data ?? []
);
const addresses = computed<Address[]>(
  () => response.value?.addresses?.data ?? []
);

const order = async () => {};

useHead({
  title: 'Checkout',
});

definePageMeta({
  auth: {
    unauthenticatedOnly: false,
    navigateAuthenticatedTo: '/auth/signin',
  },
});
</script>

<template>
  <div class="container w-3/5 mx-auto mt-10 border-2 border-amber-300">
    <div class="flex gap gap-5">
      <div class="border-2 border-red-400 w-2/3">Main</div>
      <div class="border-2 border-red-400 w-1/3">
        <article class="">
          <div class="">
            <Button
              @click.prevent="order"
              type="submit"
              class="w-full rounded-sm cursor-pointer bg-sky-500 hover:bg-sky-600"
            >
              Place Order
            </Button>
          </div>
        </article>
      </div>
    </div>
  </div>
</template>
