<script setup lang="ts">
const cartStore = useCart();
</script>

<template>
    <table class="w-full">
        <tbody>
            <CartOverviewProduct v-for="product in cartStore.getProducts" :key="product.id" :product="product" />
            <tr class="h-18 hover:bg-gray-200">
                <td></td>
                <td></td>
                <td>
                    <p class="has-text-weight-bold">Subtotal</p>
                </td>
                <td>{{ cartStore.getSubTotal }}</td>
                <td></td>
            </tr>
            <slot name="rows"></slot>
        </tbody>
    </table>
</template>