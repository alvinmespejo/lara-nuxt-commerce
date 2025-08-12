import { useCategories } from '~/stores/categories'

export default defineNuxtPlugin(async (nuxtApp) => {
    const categories = useCategories(useNuxtApp().$pinia);
    await categories.fetch()
})