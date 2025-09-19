<script setup lang="ts">
import type { PaymentMethodResponse } from '~~/shared/types/paymentMethods';

const card = ref<any>(null)
const stripe = ref<any>(null)
const creating = ref<boolean>(false)

const api = useAPI()
const config = useRuntimeConfig();

const emit = defineEmits<{
  (e: 'paymentMethodCreated', value: PaymentMethod | undefined): void;
  (e: 'cancelPaymentMethodCreation', value: boolean) :void;
}>()

const storePayment = async () => {
  const {token, error} = await stripe.value.createToken(card.value)
  if (token && !error) {
    let response = await api.post<PaymentMethodResponse>(`/payment-methods`, {token: token.id})
    emit('paymentMethodCreated', response.data)
  }
}

onMounted(() => {
  if (window.Stripe === undefined || window.Stripe === null) {
    alert('Error loading stripe');
    return;
  }

  stripe.value = window.Stripe(config.public.stripeKey);
  card.value = stripe.value.elements().create('card', {
    style: {
      base: {
        fontSize: '16px'
      }
    }
  });

  card.value.mount('#card-element');
})
</script>

<template>
  <div>
    <form @submit.prevent="storePayment" class="space-y-6">
      <div id="card-element"></div>
      <div class="flex gap-2 justify-items-center">
        <Button
          type="submit"
          class="bg-sky-500 hover:bg-sky-600"
          :class="{'cursor-not-allowed': creating, 'cursor-pointer': !creating}"
          :disabled="creating"
        >          
          {{ creating ? 'Saving...' : 'Create new payment' }}
        </Button>
        <a
          href="#"
          class="underline"
          @click.prevent="emit('cancelPaymentMethodCreation', true)"
          >Cancel</a>
      </div>
    </form>
  </div>
</template>
