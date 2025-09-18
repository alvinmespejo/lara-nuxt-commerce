<script setup lang="ts">

import ShippingAddressSelector from '@/components/checkout/addresses/ShippingAddressSelector.vue'
import ShippingAddressCreator from '@/components/checkout/addresses/ShippingAddressCreator.vue'

const props = defineProps<{
  addresses: Address[];
  modelValue: any
}>();

const emit = defineEmits<{
  (e: 'update:modelValue', value: number): void
}>()

const creating = ref<boolean>(false);
const selecting = ref<boolean>(false);
const localAddresses = ref<Address[]>(props.addresses);
const selectedAddress = ref<Address | null>(null);

const defaultAddress = computed<Address | undefined>(() => localAddresses.value.find(address => address.default === true));

const addressSelected = (address: Address): void => {
  switchAddress(address);
  selecting.value = false;
};

const addressCreated = (address: Address) => {
  localAddresses.value.push(address);
  switchAddress(address)
  creating.value = false;
}

const switchAddress = (address: Address | undefined) => {
  selectedAddress.value = address ?? null;
}
watch(selectedAddress, (newAddress, oldAddress) => {
  console.log(newAddress?.id, oldAddress?.country)
  if (!newAddress) return

  emit('update:modelValue', newAddress.id)
})

onMounted(() => {
  if (props.addresses.length) {
    switchAddress(defaultAddress.value);
  }
})
</script>

<template>
  <article>
    <div class="p-5 border-l-4 border-gray-300">
      <h1 class="font-bold text-lg mb-4">Ship to</h1>
      <template v-if="selecting">
        <ShippingAddressSelector
          :addresses="addresses"
          :selectedAddress="selectedAddress"
          @switchAddress="addressSelected"
        />
      </template>

      <template v-else-if="creating">
         <ShippingAddressCreator @addressCreated="addressCreated" @cancelAddressShippingCreator="creating = false" />
      </template>

      <template v-else>
        <template v-if="selectedAddress">
          <p>
              {{ selectedAddress.name }} <br/>
              {{ selectedAddress.address_1 }} <br/>
              {{ selectedAddress.city }} <br/>
              {{ selectedAddress.postal_code }} <br/>
              {{ selectedAddress.country.name }} <br/>
            </p>
            <br/>
        </template>
        <div class="flex gap gap-4">
          <Button
            class="cursor-pointer bg-sky-500 hover:bg-sky-600"
            @click.prevent="selecting = true"
          >
            Change shipping address
          </Button>
          <Button
            class="cursor-pointer bg-sky-500 hover:bg-sky-600"
            @click.prevent="creating = true"
          >
            Add new address
          </Button>
        </div>
      </template>
    </div>
  </article>
</template>
