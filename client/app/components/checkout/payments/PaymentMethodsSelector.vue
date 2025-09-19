<script setup lang="ts">
const props = defineProps<{
  payments: PaymentMethod[] | undefined;
  selectedPaymentMethod?: PaymentMethod
}>()

const emit = defineEmits<{
  (e: 'switchPaymentMethod', value: PaymentMethod): void
}>()

const handleSwitchPayment = (payment: PaymentMethod) => {
  emit('switchPaymentMethod', payment)
}
</script>

<template>
  <table class="table-fixed w-full border-separate border-spacing-4">
    <tbody>
      <tr v-for="(payment, idx) in payments" :key="idx">
        <td>
          <p :class="{ 'font-bold': payment.id === selectedPaymentMethod?.id }">
            {{ payment.card_type }} ({{ payment.last_four }})
          </p>
        </td>
        <td class="text-center">
          <Button
            class="bg-sky-500 hover:bg-sky-600 cursor-pointer"
            @click.prevent="handleSwitchPayment(payment)"
          >
            Pay with this
          </Button>
        </td>
      </tr>
    </tbody>
  </table>
</template>
