import { useCategories } from '~/stores/categories'

export default defineNuxtPlugin(async (nuxtApp) => {
    const { data } = useAuth();
    const categories = useCategories(useNuxtApp().$pinia);
    await categories.fetch()
    
    if (data.value) {
        
    }
})