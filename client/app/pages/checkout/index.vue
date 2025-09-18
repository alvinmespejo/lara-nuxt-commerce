<script setup lang="ts">
import ShippingAddress from '@/components/checkout/addresses/ShippingAddress.vue';
import PaymentMethods from '@/components/checkout/payments/PaymentMethods.vue';

type checkoutForm = {
  address_id?: number,
  shipping_method_id?: number,
  payment_method_id?: number,
}

const shippingMethods = ref([])
const isEempty = ref<boolean>(true);
const isSubmitting = ref<boolean>(false);
const checkoutForm = ref<checkoutForm>({})

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
    addressesErrors: addresses.error?.value,
    paymentMethodsErrors: paymentMethods.error?.value,
  };
});

const paymentMethods = computed<PaymentMethod[]>(
  () => response.value?.paymentMethods?.data ?? []
);
const addresses = computed<Address[]>(
  () => response.value?.addresses?.data ?? []
);

const placeOrder = async () => {};

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
  <div class="container w-3/5 mx-auto mt-10">
    <div class="flex gap gap-5">
      <div class="w-2/3 bg-gray-100">
        <ShippingAddress :addresses="addresses" v-model="checkoutForm.address_id" v-if="addresses.length" />
        <PaymentMethods :payments="paymentMethods" v-model="checkoutForm.payment_method_id" v-if="paymentMethods.length"/>
      </div>
      <div class="w-1/3">
        <article class="bg-gray-100">
          <div class="p-5 border-l-4 border-gray-300">
            <Button
              @click.prevent="placeOrder"
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
