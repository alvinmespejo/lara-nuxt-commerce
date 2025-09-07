import type { Meta, Links } from './index.ts';

export type Product = {
  id: string | number;
  name: string | null;
  slug: string | null;
  price: string;
  description: string | null;
  stock_count: number | null;
  in_stock: boolean;
  total?: string;
  quantity?: number;
  product?: Product;
};

export type ProductMeta = {
  total: string | null;
  subtotal: string | null;
  change: boolean;
  empty: boolean;
};

export type ProductVariation = {
  id: number;
  name: string;
  price: string;
  type: string;
  in_stock: boolean;
  price_varies: boolean;
  stock_count: number | null;
  product: Product;
};

type Variations = Record<string, ProductVariation[]>;

export type ProductDetail = {
  id: string | number;
  name: string | null;
  slug: string | null;
  price: string;
  description: string | null;
  stock_count: number | null;
  in_stock: boolean;
  variations: Variations[];
};

export type ProductIndexResponse = {
  data: Product[];
  link: Links;
  meta: Meta;
};

export type ProductCartResponse = {
  products: Product[];
};
