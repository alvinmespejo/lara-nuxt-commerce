<script setup lang="ts">
//**** Types ****// 
import type { ProductVariation as prodVariationType } from '../../../shared/types/product';

//**** Components ****// 
import ProductVariation from '@/components/products/ProductVariation.vue';

//**** Store ****// 
import { useCart } from '~/stores/cart'

const router = useRoute();
const cartStore = useCart();

type ProductDetailResponse = {
  data: ProductDetail;
};

type FormData = {
  quantity: number;
  variation: ProductVariation;
};

const cart = ref<FormData>({
  quantity: 1,
  variation: {} as prodVariationType,
});

const isCartProcessing = ref<boolean>(false)

const {
  data: productDetail,
  error,
  status,
} = await useFetchAPI<ProductDetailResponse>(`/products/${router.params.slug}`);

const productSlug = computed<string>(() => {
  return productDetail.value?.data.slug ?? '';
});

const productName = computed<string>(() => {
  return productDetail.value?.data.name ?? '';
});

const addToCart = async() => {
  isCartProcessing.value = true
  await cartStore.addCart([{
    id: cart.value.variation.id,
    quantity: cart.value.quantity
  }])

  // reset cart
  cart.value.quantity = 1
  cart.value.variation = {} as prodVariationType
  isCartProcessing.value = false
};

useHead({
  title: router.params.slug as string,
});
</script>

<template>
  <div class="container mx-auto mt-10">
    <div class="columns-2">
      <div>
        <div class="">
          <img src="https://placehold.co/620x620" :alt="productSlug" />
        </div>h
      </div>
      <div>
        <section>
          <h1 class="font-bold text-4xl">
            {{ productName }}
          </h1>
          <p class="mt-6 mb-6" v-if="productDetail?.data.description">
            {{ productDetail?.data.description }}
          </p>
          <hr />
          <div class="mt-6">
            <span
              v-if="!productDetail?.data.in_stock"
              class="inline-block bg-gray-100 rounded-full px-3 py-1 text-sm font-semibold text-gray-600 mr-2 mb-2"
            >
              Out of Stock
            </span>
            <span
              class="inline-block bg-gray-100 rounded-full px-3 py-1 text-sm font-semibold text-gray-600 mr-2 mb-2"
            >
              {{ productDetail?.data.price }}
            </span>
          </div>
        </section>

        <!-- Product variations -->
        <section v-if="productDetail?.data.variations">
          <form @submit.prevent="addToCart">
            <ProductVariation
              v-for="(items, key) in productDetail?.data.variations"
              :key="key"
              :type="key"
              :variations="items"
              v-model="cart.variation"
            />
            <div class="flex flex-row gap-2" v-if="cart.variation.stock_count">
              <select 
                id="car.quantity"
                name="cart.quantity"
                v-model="cart.quantity"
                class="border block pl-3 py-2 border-gray-300 text-sm rounded-md">
                <option v-for="x in cart.variation.stock_count" :key="x" :value="x">
                  {{ x }}
                </option>
              </select>
              <div>
                <Button
                  type="submit"
                  class="w-full rounded-sm cursor-pointer bg-sky-500 hover:bg-sky-600"
                  :class="{'cursor-not-allowed': isCartProcessing}"
                  :disabled="isCartProcessing" 
                >
                  Add to Cart
                </Button>
              </div>
            </div>
          </form>
        </section>
      </div>
    </div>
  </div>
</template>
