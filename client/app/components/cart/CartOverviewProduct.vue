<script setup lang="ts">
const cartStore = useCart();

const quantity = computed<number>({
  set(quantity: number) {
    updateCartItem(props.product.id, quantity);
  },
  get() {
    return props.product.quantity ?? 0;
  },
});

const updateCartItem = async (id: number, quantity: number) => {
  await cartStore.updateCart(id, quantity);
};

const removeCartItem = async (id: number) => {
  if (confirm('Are you sure you want to delete this product?')) {
    await cartStore.removeCart(id);
  }
};

const props = defineProps<{
  product: Product;
}>();
</script>

<template>
  <tr class="h-18 hover:bg-gray-200">
    <td>
      <img src="https://placehold.co/60x60" />
    </td>
    <td>
      {{ product?.product?.name }} / {{ product?.type }} {{ product.name }}
    </td>
    <td>
      <div class="field">
        <div class="control">
          <div class="select">
            <select
              v-model="quantity"
              class="border block pl-3 py-2 border-gray-300 text-sm rounded-md"
            >
              <option value="0" v-if="product.quantity == 0">0</option>
              <option
                v-else
                v-for="count in product.stock_count"
                :value="count"
                :key="count"
                :selected="count == product.quantity"
              >
                {{ count }}
              </option>
            </select>
          </div>
        </div>
      </div>
    </td>
    <td>
      {{ product.total }}
    </td>
    <td>
      <!-- <a href="#" @click.prevent="removeCartItem(product.id)" class="hover:underline">Remove</a> -->
      <Button
        class="bg-red-500 hover:bg-red-600 cursor-pointer"
        @click.prevent="removeCartItem(product.id)"
        >Remove</Button
      >
    </td>
  </tr>
</template>
