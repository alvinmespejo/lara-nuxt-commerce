<script setup lang="ts">
import OrderCompleted from '~/components/orders/statuses/OrderCompleted.vue';
import OrderPaymentFailed from './statuses/OrderPaymentFailed.vue';
import OrderProcessing from './statuses/OrderProcessing.vue';
import OrderPending from './statuses/OrderPending.vue';
import { OrderStatuses } from '~~/shared/types/order';
import type { Component } from 'vue';

const maxProducts = ref<number>(4);
const products = computed<Array<ProductVariation>>(() => {
  return props.order.products.slice(0, maxProducts.value);
});

const productsMore = computed<number>(() => {
  return props.order.products.length - maxProducts.value;
});

const orderStatusComponent = computed<Component | undefined>(() => {
  if (props.order.status === OrderStatuses.completed) {
    return OrderCompleted;
  }

  if (props.order.status === OrderStatuses.payment_failed) {
    return OrderPaymentFailed;
  }

  if (props.order.status === OrderStatuses.pending) {
    return OrderPending;
  }

  if (props.order.status === OrderStatuses.processing) {
    return OrderProcessing;
  }
});

const props = defineProps<{
  order: Order;
}>();
</script>

<template>
  <tr class="h-18">
    <td class="pl-6">#{{ order.id }}</td>
    <td>{{ order.created_at }}</td>
    <td>
      <div v-for="variation in products" :key="variation.id">
        <NuxtLink
          :to="{
            name: 'products-slug',
            params: { slug: variation.product.slug },
          }"
        >
          {{ variation.product.name }} {{ variation.name }} -
          {{ variation.type }}
        </NuxtLink>
      </div>
      <!-- <template v-if="productsMore"> and {{ productsMore }} more</template> -->
    </td>
    <td>
      {{ order.substotal }}
    </td>
    <td>
      <component :is="orderStatusComponent" />
    </td>
  </tr>
</template>
