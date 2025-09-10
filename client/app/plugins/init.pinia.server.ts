import { useCategories } from '~/stores/categories'
import { useCart } from '~/stores/cart';

export default defineNuxtPlugin(async (nuxtApp) => {
    const { data, token } = useAuth();
    const categories = useCategories(useNuxtApp().$pinia);
    const cart = useCart(useNuxtApp().$pinia)
    
    await categories.fetch()
    if (token.value) {
        await cart.fetch()
    }
})