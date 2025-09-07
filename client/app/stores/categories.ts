import type { Category } from '../../shared/types/category'
// export const useCategories = defineStore('categories', {
//     state: (): IStateCategories => ({
//       categories: undefined
//     })
// })

// type UserState = {
//   login: string
//   isPremium: boolean
// }

// const useUserStore = defineStore<string, UserState>('user', {
//   state: () => ({
//     login: 'test',
//     isPremium: false,
//   }),
// })
// https://stackoverflow.com/questions/69833591/how-to-set-the-type-for-the-state-object-in-pinia

type ICategoryResponse = {
    data: Category[] | undefined
}

type State = {
  categories: Category[] | undefined
}

export const useCategories = defineStore('categories', {
  state: (): State => ({
    // categories: <Category[] | undefined>[]
    categories: undefined as Category[] | undefined
  }),
  actions: {
    async fetch() {
      const api = useAPI();
      let resp = await api.get<ICategoryResponse>('/categories');
      this.categories = resp.data ?? []
      // console.log(this.categories);
    }
  },
  getters: {
    getCategories (state): Category[] | null {
      return state.categories ?? null;
    } 
  }
});