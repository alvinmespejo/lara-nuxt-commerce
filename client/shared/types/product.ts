import type { Meta, Links } from './index.ts';

export type Product = {
  id: number;
  name: string;
  slug: string;
  price: string;
  description: string | null;
  stock_count: number | null;
  in_stock: boolean;
  total?: string;
  type: string;
  quantity?: number;
  product?: Product;
};

export type ProductMeta = {
  total: string;
  subtotal: string;
  change: boolean;
  empty: boolean;
};

export type ProductVariation = {
  id: number;
  name: string;
  slug: string;
  description: string;
  price: string;
  type: string;
  in_stock: boolean;
  price_varies: boolean;
  stock_count: number;
  product: Product;
};

export type Variations = Record<string, ProductVariation[]>;

export type ProductDetail = {
  id: string | number;
  name: string | null;
  slug: string | null;
  price: string;
  description: string | null;
  stock_count: number | null;
  in_stock: boolean;
  variations: {[key: string]: ProductVariation[]};
};

export type ProductIndexResponse = {
  data: Product[];
  link: Links;
  meta: Meta;
};

export type ProductCartResponse = {
  products: Product[];
};
