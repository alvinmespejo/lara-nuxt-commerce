export interface APIResponseError {
  [key: string]: string | string[];
}

export interface User {
  id: number;
  name: string;
  email: string;
}

export interface RegistrationPayload {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
  remember_me?: boolean;
}

export interface Step {
  uuid: string;
  title: string;
  body: string;
  order: number;
}

export interface Snippet {
  uuid: string;
  title: string;
  step_counts: number;
  is_public: boolean;
  owner?: boolean;
  steps?: Step[];
  author: User;
}

export interface SnippetResponse {
  uuid: string;
  title: string | null;
  step_counts: number;
  is_public: boolean;
  owner?: boolean;
  steps?: Step[];
  author: User;
}

