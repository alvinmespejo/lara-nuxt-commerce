<script setup lang="ts">
import type { Country, CountryResponse } from '~~/shared/types';

const countries = ref<Country[]>([]);

const emit = defineEmits<{
  (e: 'update:modelValue', value: string | number): void;
}>();

const getCountries = async () => {
  let { data: list } = await useFetchAPI<CountryResponse>(`countries`);
  countries.value = list.value?.data ?? [];
};

const selectChange = (evt: Event) => {
  emit('update:modelValue', (evt.target as HTMLSelectElement).value);
};

onBeforeMount(() => {
  getCountries();
});
</script>

<template>
  <div>
    <select
      name="countries"
      id="countries"
      class="border border-gray-200 w-full p-1.5 text-sm rounded-md bg-white"
      @change="selectChange"
    >
      <option value="" selected>Select a country</option>
      <option
        v-for="country in countries"
        :key="country.id"
        :value="country.id"
      >
        {{ country.name }} ({{ country.code }})
      </option>
    </select>
  </div>
</template>
