import type { ShippingMethod } from './shipping-method';
import type { ProductVariation } from './product';

export enum OrderStatuses {
  completed = 'completed',
  processing = 'processing',
  cancelled = 'cancelled',
  payment_failed = 'payment_failed',
  pending = 'pending',
}

type AddressDetail = {
  id: string | number;
  name: string;
  city: string;
  default: boolean;
  address_1: string;
  postal_code: string;
};

export type Order = {
  id: string | number;
  status: string;
  substotal: string | undefined;
  total: string | undefined;
  created_at: string;
  address: AddressDetail;
  shippingMethod: ShippingMethod;
  products: ProductVariation[];
};
