
import type { UseFetchOptions } from '#app';
import type { Category, IStateCategories } from '../../shared/types/index'
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


interface ICategoryResponse {
    data: Category[] | undefined | null
}

export const useCategories = defineStore('categories', {
  state: () => {
    return {
        categories: <Category[] | undefined | null>[]
    }
  },
  actions: {
    async fetch() {
      const api = useAPI();
      let response = await api.get<ICategoryResponse>('/categories')
      this.categories = response.data ? response.data?.data : []
    }
  },
  getters: {
    categoryLists: (state) => state.categories
  }
});