<script setup lang="ts">
import type { UseFetchOptions } from '#app';
import { useOrder } from '~/stores/order';
import Order from '~/components/orders/Order.vue';
const orderStore = useOrder();

// onMounted(async() => {
// callOnce(async() => {
//     await orderStore.fetchOrders()
//     // console.log(orderStore.getOrders)
// })
// })

type OrderListResponse = {
  data: Order[] | undefined;
  links: Links | undefined;
  meta: Meta | undefined;
};

const { data, error, status } = await useFetchAPI<OrderListResponse>(
  `/orders`,
  {
    method: 'GET',
  }
);


const orders = computed<Array<Order> | []>(() => data.value?.data ?? []);
const meta = computed<Meta | null>(() => data.value?.meta ?? null);
const links = computed<Links | null>(() => data.value?.links ?? null);

useHead({
  title: 'Orders',
});

definePageMeta({
  auth: {
    unauthenticatedOnly: false,
    navigateAuthenticatedTo: '/auth/signin',
  },
});
</script>

<template>
  <div class="container mx-auto mt-10">
    <template v-if="orders.length">
      <div class="mb-4">
        <p class="font-bold text-2xl">Your Orders</p>
      </div>
      <div class="overflow-hidden bg-gray-100">
        <table class="table-fixed w-full">
          <tbody class="border-l-4 border-gray-300">
            <Order v-for="order in orders" :key="order.id" :order="order"/>
            <!-- <tr class="h-18">
              <td class="pl-6">The Sliding Mr. Bones (Next Stop, Pottersville)</td>
              <td>Malcolm Lockyer</td>
              <td>1961</td>
              <td>1961</td>
            </tr>
            <tr class="h-18">
              <td class="pl-6">Witchy Woman</td>
              <td>The Eagles</td>
              <td>1972</td>
              <td>1961</td>
            </tr>
            <tr class="h-18">
              <td class="pl-6">Shining Star</td>
              <td>Earth, Wind, and Fire</td>
              <td>1975</td>
              <td>1961</td>
            </tr>
            <tr class="h-18">
              <td class="pl-6"> 123r</td>
              <td>Earth, Wind, and dasdaFire</td>
              <td>1975</td>
              <td>1961</td>
            </tr> -->
          </tbody>
        </table>
      </div>
    </template>
    <template v-else>
      <div>You have no orders</div>
    </template>
  </div>
</template>
