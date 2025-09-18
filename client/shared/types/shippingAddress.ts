type Country = {
    id: number;
    name: string;
    code: string;
}

export type Address = {
    id:number;
    name: string;
    city: string; 
    postal_code: string;
    address_1: string; 
    default: boolean;
    country: Country;
}

export type ShippingAddressesResponse = {
    data: Address[] | undefined
}

export type ShippingAddressResponse = {
  data: Address;
};