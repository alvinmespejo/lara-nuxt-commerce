<script setup lang="ts">
import PaymentMethodsCreator from './PaymentMethodsCreator.vue';
import PaymentMethodsSelector from './PaymentMethodsSelector.vue';

const props = defineProps<{
  payments: PaymentMethod[] | undefined;
  modelValue: any;
}>();

const creating = ref<boolean>(false);
const selecting = ref<boolean>(false);
const localPaymentMethods = ref<PaymentMethod[]>(props.payments ?? []);
const selectedPaymentMethod = ref<PaymentMethod>();

const emit = defineEmits<{
  (e: 'update:modelValue', value: string | number): void;
}>();

const defaultPaymentMethod = computed<PaymentMethod | undefined>(() => {
  return localPaymentMethods.value?.find((pm) => pm.default === true);
});

const paymentMethodSelected = (payment: PaymentMethod) => {
  switchPaymentMethod(payment);
  selecting.value = false;
};

const paymentMethodCreated = (payment: PaymentMethod | undefined) => {
  if (payment === undefined || payment === null) {
    return;
  }

  localPaymentMethods.value?.push(payment);
  switchPaymentMethod(payment);
  creating.value = false;
};

const switchPaymentMethod = (pm: PaymentMethod | undefined) => {
  selectedPaymentMethod.value = pm
};

watch(selectedPaymentMethod, (val) => {
  if (!val) return;

  emit('update:modelValue', val.id);
});

onMounted(() => {
  if (props.payments?.length) {
    switchPaymentMethod(defaultPaymentMethod.value);
  }
});
</script>

<template>
  <div class="mt-8 p-5 border-l-4 border-gray-300 bg-gray-100">
    <h1 class="font-bold text-lg mb-4">Payment method</h1>
    <template v-if="selecting">
      <PaymentMethodsSelector
        :payments="payments"
        :selectedPaymentMethod="selectedPaymentMethod"
        @switchPaymentMethod="paymentMethodSelected"
      />
    </template>
    <template v-else-if="creating">
      <PaymentMethodsCreator
        @paymentMethodCreated="paymentMethodCreated"
        @cancelPaymentMethodCreation="creating = false"
      />
    </template>
    <template v-else>
      <div v-if="selectedPaymentMethod">
        <p>
          {{ selectedPaymentMethod.card_type }} ending
          {{ selectedPaymentMethod.last_four }}
        </p>
        <br />
      </div>
      <div class="flex gap-4">
        <Button
          class="cursor-pointer bg-sky-500 hover:bg-sky-600"
          @click.prevent="selecting = true"
        >
          Change payment method
        </Button>
        <Button
          class="cursor-pointer bg-sky-500 hover:bg-sky-600"
          @click.prevent="creating = true"
        >
          Add new payment method
        </Button>
      </div>
    </template>
  </div>
</template>
