import type { Order } from '../../shared/types/order';
import type { Links, Meta } from '../../shared/types/index';
import { toast } from 'vue-sonner';

type OrderListResponse = {
  data: Order[] | undefined;
  links: Links | undefined;
  meta: Meta | undefined;
};

type State = {
  orders: Order[] | null;
  links: Links | null;
  meta: Meta | null;
};

export const useOrder = defineStore('order', {
  state: (): State => ({
    orders: null as Order[] | null,
    links: null as Links | null,
    meta: null as Meta | null,
  }),
  actions: {
    async fetchOrders() {
      let api = useAPI();
      try {
        let response = await api.get<OrderListResponse>(`/orders`);
        this.orders = response.data ?? null
        this.meta = response.meta ?? null
        this.links = response.links ?? null
      } catch (error: any) {
        toast.error('Error', {
          description: 'An error occured while fetching record. Please try again.'
        })
      }
    },
  },
  getters: {
    getOrders(state: State): Order[] | null {
      return state.orders ?? null
    },
  },
});
