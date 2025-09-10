<script setup lang="ts">
import type { ProductVariation } from '../../../shared/types/product';

const props = defineProps<{
  variations: ProductVariation[];
  type: string | number;
  modelValue: any;
}>();

const emit = defineEmits<{
  (e: 'update:modelValue', value: ProductVariation | ''): void;
  (e: 'change', value: string): void;
}>();

const selectVariationId = computed<number | ''>(() => {
    if(findVariation(parseInt(props.modelValue))) {
        return ''
    }

    return props.modelValue.id
})

const handleSelectOnChange = (event: Event): void => {
  emit(
    'update:modelValue',
    findVariation(parseInt((event.target as HTMLSelectElement).value))
  );
};

const findVariation = (id: number): ProductVariation | ''  => {
  let variation = props.variations.find((variation) => variation.id == id);
  if (variation === undefined || variation === null) {
    return '';
  }

  return variation;
};

</script>

<template>
  <div class="mb-4 mt-6">
    <label for="variations" class="block text-xl font-medium text-gray-700">
      {{ type }}
    </label>

    <select
      id="variations"
      name="variations"
      class="border mt-1 block w-full pl-3 pr-10 py-2 border-gray-300 text-sm rounded-md"
      :value="selectVariationId"
      @change="handleSelectOnChange"
    >
      <option value="">Please choose</option>
      <option
        v-for="variation in variations"
        :key="variation.id"
        :value="variation.id"
      >
        {{ variation.name }}
        <template v-if="variation.price_varies">
            ({{ variation.price }})
        </template>
        <template v-if="!variation.in_stock">
            (Out of stock)
        </template>
      </option>
    </select>
  </div>
</template>
