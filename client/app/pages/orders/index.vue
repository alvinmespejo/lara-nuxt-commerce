<script setup lang="ts">
import type { UseFetchOptions } from '#app';
import { useOrder } from '~/stores/order';
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

const orders = computed(() => data.value?.data ?? []);
const meta = computed(() => data.value?.meta ?? null);
const links = computed(() => data.value?.links ?? null);

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
      Your orders
      <div class="table w-full mt-4">
        <div class="table-header-group">
          <div class="table-row">
            <div class="table-cell text-left">Song</div>
            <div class="table-cell text-left">Artist</div>
            <div class="table-cell text-left">Year</div>
          </div>
        </div>
        <div class="table-row-group">
          <div class="table-row">
            <div class="table-cell">
              The Sliding Mr. Bones (Next Stop, Pottersville)
            </div>
            <div class="table-cell">Malcolm Lockyer</div>
            <div class="table-cell">1961</div>
          </div>
          <div class="table-row">
            <div class="table-cell">Witchy Woman</div>
            <div class="table-cell">The Eagles</div>
            <div class="table-cell">1972</div>
          </div>
          <div class="table-row">
            <div class="table-cell">Shining Star</div>
            <div class="table-cell">Earth, Wind, and Fire</div>
            <div class="table-cell">1975</div>
          </div>
        </div>
      </div>
    </template>
    <template v-else>
      <div>You have no orders</div>
    </template>
  </div>
</template>
