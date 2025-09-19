<script setup lang="ts">
import * as z from 'zod';
import { useForm } from 'vee-validate';
import { toTypedSchema } from '@vee-validate/zod';

import type { APIResponseError } from '~~/shared/types/index';
import CountryList from '~/components/country/CountryList.vue';
import { toast } from 'vue-sonner';

const errors = ref<APIResponseError>({});
const isCreatingAddress = ref<boolean>(false);
const api = useAPI();

const emit = defineEmits<{
  (e: 'cancelAddressShippingCreation', value: boolean): void;
  (e: 'addressCreated', value: Address): void;
}>();

const zodSchema = z.object({
  name: z.string().min(2, { message: 'Name is to short' }),
  city: z.string().min(2, { message: 'City name to short' }),
  address_1: z.string().min(2, { message: 'Address is to short' }),
  postal_code: z
    .string()
    .min(4, { message: 'Postal code must be at least 4 digits.' })
    .pipe(
      z.coerce.number({
        invalid_type_error: 'Input must be a valid postal code',
      })
    ),

  country_id: z.string(),
  default: z.boolean().optional().default(true),
});

const { handleSubmit, resetForm, defineField } = useForm({
  validationSchema: toTypedSchema(zodSchema),
});

const [countryId, countryIdProps] = defineField('country_id');

type AddressForm = {
  name: string;
  address_1: string;
  city: string;
  postal_code: string;
  country_id: string | number;
  default: boolean;
};

const addressForm = ref<AddressForm>({
  name: '',
  address_1: '',
  city: '',
  postal_code: '',
  country_id: '',
  default: true,
});

const onSubmit = handleSubmit(async (values) => {
  if (isCreatingAddress.value) {
    return;
  }

  errors.value = {};
  isCreatingAddress.value = true;
  try {
    let response = await api.post<ShippingAddressResponse>(
      `/addresses`,
      values
    );
    emit('addressCreated', response.data);
    resetForm();
    toast.success('Success', {
      description: 'Address was created successfully.',
    });

    setTimeout(() => {
      isCreatingAddress.value = false;
    }, 500);
  } catch (e: Error | any) {
    errors.value =
      e.statusCode === 422 ? e.data.errors : { general: e.message };

    if (e.statusCode === 500) {
      toast.error('Error', {
        description:
          'Error occured while processing request. Please try again!',
      });
    }
  }
});
</script>

<template>
  <div>
    <form @submit.prevent="onSubmit" class="space-y-3.5">
      <div class="grid gap-2">
        <FormField v-slot="{ componentField }" name="name">
          <FormItem>
            <FormLabel> Name </FormLabel>
            <FormControl>
              <Input
                class="bg-white"
                id="name"
                type="text"
                placeholder="Name"
                v-bind="componentField"
              />
            </FormControl>
            <FormMessage />
            <div v-if="errors.name">
              {{ errors.name }}
            </div>
          </FormItem>
        </FormField>
      </div>
      <div class="grid gap-2">
        <FormField v-slot="{ componentField }" name="address_1">
          <FormItem>
            <FormLabel> Address line 1 </FormLabel>
            <FormControl>
              <Input
                class="bg-white"
                id="address_1"
                v-bind="componentField"
                type="text"
                placeholder="Address line 1"
              />
            </FormControl>
            <FormMessage />
            <div v-if="errors.address_1">
              {{ errors.address_1 }}
            </div>
          </FormItem>
        </FormField>
      </div>
      <div class="grid gap-2">
        <FormField v-slot="{ componentField }" name="city">
          <FormItem>
            <FormLabel> City </FormLabel>
            <FormControl>
              <Input
                class="bg-white"
                id="city"
                type="text"
                placeholder="City"
                v-bind="componentField"
              />
            </FormControl>
            <FormMessage />
            <div v-if="errors.city">
              {{ errors.city }}
            </div>
          </FormItem>
        </FormField>
      </div>
      <div class="grid gap-2">
        <div class="flex gap-2">
          <FormField v-slot="{ componentField }" name="postal_code">
            <FormItem>
              <FormLabel> Postal Code </FormLabel>
              <FormControl>
                <Input
                  class="bg-white"
                  id="postal_code"
                  type="text"
                  placeholder="Postal Code"
                  v-bind="componentField"
                />
              </FormControl>
              <FormMessage />
              <div v-if="errors.postal_code">
                {{ errors.postal_code }}
              </div>
            </FormItem>
          </FormField>
          <FormField v-slot="{ componentField }" name="country">
            <FormItem class="w-full">
              <FormLabel> Country </FormLabel>
              <FormControl>
                <CountryList v-model="countryId" v-bind="countryIdProps" />
              </FormControl>
              <FormMessage />
              <div v-if="errors.country">
                {{ errors.country }}
              </div>
            </FormItem>
          </FormField>
        </div>
      </div>
      <div class="flex gap-2 justify-items-center">
        <Button
          type="submit"
          class="bg-sky-500 hover:bg-sky-600 cursor-pointer"
        >
          Add Address
        </Button>
        <a
          href="#"
          class="underline"
          @click.prevent="emit('cancelAddressShippingCreation', true)"
          >Cancel</a>
      </div>
    </form>
  </div>
</template>
