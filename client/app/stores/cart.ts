import queryString from "query-string";
import type {Product, ProductCartResponse, ProductMeta} from '../../shared/types/product'

type CartState = {
  empty: boolean | false;
  change: boolean | false;
  subtotal: string | null;
  total: string | null;
  shipping: Shipping | null;
  products: Product[] | null;
};

type Shipping = {
    id: string;
    name: string;
}

type CartResponse = {
  data: ProductCartResponse | undefined;
  meta: ProductMeta | undefined;
}

export const useCart = defineStore('cart', {
  state: (): CartState => ({
    empty: false,
    change: false,
    shipping: null,
    subtotal: null as string | null,
    total: null as string | null,
    products: <Product[] | null>[]
  }),
  actions: {
    async fetch() {
      const api = useAPI();
      let query: Record<string, string | number> = {};

      if (this.shipping) {
        query = {
          shipping_method_id: this.shipping.id,
        };
      }

      let cart = await api.get<CartResponse>(
        `/cart?${queryString.stringify(query)}`
      );

      this.change = cart.meta?.change ?? false;
      this.empty = cart.meta?.empty ?? false;
      this.products = cart.data?.products ?? null;
    },
    async delete(productId: string) {
      const api = useAPI();
      await api.destroy(`/cart/${productId}`);
    },
  },
  getters: {
    hasChange(state): boolean {
      return state.change;
    },
    isEmpty(state): boolean {
      return state.empty;
    },
    getTotal(state): string | null  {
      return state.total ?? null;
    },
    getSubTotal(state): string | null {
      return state.subtotal ?? null;
    },
  },
});
