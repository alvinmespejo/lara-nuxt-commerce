<script setup lang="ts">

const props = defineProps<{
  addresses: Address[];
  selectedAddress: Address | null;
}>();

const emit = defineEmits<{
  (e: 'switchAddress', value: Address): void
}>();

const handleSwitchAddress = (address: Address): void => {
  emit('switchAddress', address)
}
</script>

<template>
  <table class="table-fixed w-full border-separate border-spacing-4">
    <tbody>
      <tr v-for="(address, idx) in addresses" :key="address.id">
        <td>
          <p :class="{ 'font-bold': address.id === selectedAddress?.id }">
            {{ address.name }} <br />
            {{ address.address_1 }} <br />
            {{ address.city }} <br />
            {{ address.postal_code }} <br />
            {{ address.country.name }} <br />
          </p>
        </td>
        <td class="text-center">
          <Button
            class="bg-sky-500 hover:bg-sky-600 cursor-pointer"
            @click.prevent="handleSwitchAddress(address)"
          >
            Set default
          </Button>
        </td>
      </tr>
    </tbody>
  </table>
</template>
