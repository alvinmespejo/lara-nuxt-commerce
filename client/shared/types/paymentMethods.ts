export type PaymentMethod = {
    id: number;
    card_type: string;
    last_four: string;
    default: boolean;
}


export type PaymentMethodsResponse = {
    data: PaymentMethod[] | undefined
}