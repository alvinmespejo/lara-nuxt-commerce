<script setup lang="ts">
import ShippingAddress from '@/components/checkout/addresses/ShippingAddress.vue';
import PaymentMethods from '@/components/checkout/payments/PaymentMethods.vue';
import CartOverview from '@/components/cart/CartOverview.vue';

import type { ShippingAddressesResponse } from '~~/shared/types/shippingAddress';

type checkoutForm = {
  address_id?: number;
  shipping_method_id?: number;
  payment_method_id?: number;
};

const cartStore = useCart();
const shippingMethods = ref([]);
const isEempty = ref<boolean>(true);
const isSubmitting = ref<boolean>(false);
const checkoutForm = ref<checkoutForm>({});

const {
  data: response,
  error,
  status,
} = useAsyncData('cart-checkout', async () => {
  const [addresses, paymentMethods] = await Promise.all([
    useFetchAPI<ShippingAddressesResponse>(`/addresses`, { method: 'GET' }),
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

// watch(checkoutForm.value, (val, old) => {
//   if (val.shipping_method_id !== old.shipping_method_id) {

//   }
// }, {deep: true})

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
  <div class="container w-3/5 mx-auto mt-10 mb-10">
    <div class="flex gap gap-5">
      <div class="w-2/3">
        <div class="flex-row">
          <ShippingAddress
            :addresses="addresses"
            v-model="checkoutForm.address_id"
          />
          <PaymentMethods
            :payments="paymentMethods"
            v-model="checkoutForm.payment_method_id"
          />

          <!-- Shipping  -->
          <div class="p-5 mt-8 border-l-4 border-gray-300 bg-gray-100">
            <h1 class="font-bold text-lg mb-4">Shipping</h1>
            <!-- <div class=""> -->
            <!-- <select v-model="shippingMethodId">
                <option
                  v-for="shipping in shippingMethods"
                  :key="shipping.id"
                  :value="shipping.id"
                >
                  {{ shipping.name }} ({{ shipping.price }})
                </option>
              </select> -->
            <!-- </div> -->
          </div>

          <!-- Cart Overview -->

          <div class="p-5 mt-8 border-l-4 border-gray-300 bg-gray-100" v-if="!cartStore.empty">
            <h1 class="font-bold text-lg mb-4">Cart Summary</h1>
            <CartOverview>
              <template #rows>
                <tr class="h-18">
                  <td></td>
                  <td></td>
                  <td class="has-text-weight-bold">Shipping</td>
                  <!-- <td>{{ shipping.price }}</td> -->
                  <td>$123</td>
                </tr>
                <tr class="h-18">
                  <td></td>
                  <td></td>
                  <td class="has-text-weight-bold">Total</td>
                  <td>{{ cartStore.total }}</td>
                </tr>
              </template>
            </CartOverview>
          </div>

          <!-- Order Button  -->
          <div class="mt-5">
            <Button
              :disabled="cartStore.empty || isSubmitting"
              @click.prevent="placeOrder"
              type="submit"
              class="w-full rounded-sm cursor-pointer bg-sky-500 hover:bg-sky-600"
            >
              Place Order
            </Button>
          </div>
        </div>
      </div>

      <!-- Right sidebar  -->
      <div class="w-1/3">
        <article class="bg-gray-100">
          <div class="p-5 border-l-4 border-gray-300">
            <Button
              :disabled="cartStore.empty || isSubmitting"
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
