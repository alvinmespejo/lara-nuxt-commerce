
type Link = {
  url: string | null;
  label: string;
  active: boolean;
}

export type Links = {
  first: string;
  prev: string;
  last: string | null;
  next: string | null;
}

export type Meta = {
  current_page?: string | number;
  from: string | number;
  last_page?: string | number;
  links: Link[];
  path: string;
  per_page?: string | number;
  to?: string | number;
  total?: string | number;
};

export type Country = {
  id: number;
  code: string;
  name: string;
}

export type CountryResponse = {
  data: Country[]
}

export interface APIResponseError {
  [key: string]: string | string[];
}

// export interface User {
//   id: number;
//   name: string;
//   email: string;
// }

// export interface RegistrationPayload {
//   name: string;
//   email: string;
//   password: string;
//   password_confirmation: string;
//   remember_me?: boolean;
// }

// export interface Step {
//   uuid: string;
//   title: string;
//   body: string;
//   order: number;
// }

// export interface Snippet {
//   uuid: string;
//   title: string;
//   step_counts: number;
//   is_public: boolean;
//   owner?: boolean;
//   steps?: Step[];
//   author: User;
// }

// export interface SnippetResponse {
//   uuid: string;
//   title: string | null;
//   step_counts: number;
//   is_public: boolean;
//   owner?: boolean;
//   steps?: Step[];
//   author: User;
// }

// export type Country = {
//   id: string | number;
//   name: string;
//   code: string;
// };

// export type Category = {
//   id: string | number;
//   name: string;
//   slug: string;
// };

// export interface IStateCategories {
//   categories: Category | undefined;
// }

