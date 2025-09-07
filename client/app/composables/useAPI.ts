import { $fetch } from 'ofetch';
import type { FetchOptions } from 'ofetch';
import { useAsyncData, navigateTo } from '#app';
import querystring from 'query-string'

interface ApiResponse<T> {
  data: T | null;
  error: any | null; // eslint-disable-line  @typescript-eslint/no-explicit-any
  status: 'idle' | 'pending' | 'success' | 'error';
  execute: () => Promise<void>;
}

interface ApiOptions {
  headers?: Record<string, string>;
  query?: Record<string, string>;
  transform?: (data: any) => any; // eslint-disable-line  @typescript-eslint/no-explicit-any
}

interface GenericFormData {
  [key: string]: any; // eslint-disable-line  @typescript-eslint/no-explicit-any
}

export function useAPI() {
  // Create a custom $fetch instance with a 401 interceptor
  // and authorization header.
  const { token } = useAuth();
  const configEnv = useRuntimeConfig();

  const customFetch = $fetch.create({
    baseURL: `${configEnv.public.apiBaseURL}/api/v1`,
    onRequest({ options }) {
      if (token.value) {
        options.headers.set('Authorization', `Bearer ${token.value}`);
      }

      if (!options.headers.has('Content-Type') && options.body) {
        options.headers.set('Content-Type', 'application/json');
      }
    },
    async onResponseError({ response }) {
      if (response.status === 401) {
        await navigateTo('/auth/signin');
      }

      throw response;
    },
  });

  const getV1 = async <TResponse = unknown>(
    url: string,
    options: ApiOptions = {}
  ): Promise<ApiResponse<TResponse>> => {
    const { data, status, error, refresh } = await useAsyncData<TResponse>(
      `GET_${url}_${Date.now()}`,
      async () => {
        return await customFetch<TResponse>(url, {
          method: 'GET',
          headers: options.headers,
          query: options.query,
        });
      }
    );

    return {
      data: data.value as TResponse, // eslint-disable-line  @typescript-eslint/no-explicit-any
      error: error.value,
      status: status.value,
      execute: refresh,
    };
  };

  const get = async <TResponse = unknown>(
    url: string,
    options: FetchOptions = {}
  ): Promise<TResponse> => {
    return await customFetch<TResponse>(url, {
      method: 'GET',
      headers: options.headers,
      query: options.query,
      retry: options.retry,
    });
  };

  const post = async <
    TResponse = unknown,
    TBody extends GenericFormData = GenericFormData
  >(
    url: string,
    body: TBody,
    options: FetchOptions = {}
  ): Promise<TResponse> => {
    return await customFetch<TResponse>(url, {
      method: 'POST',
      body: body,
      headers: options.headers,
      query: options.query,
    });
  };

  const patch = async<
    TResponse = unknown,
    TBody extends GenericFormData = GenericFormData
  >(
    url: string,
    body: TBody,
    options: FetchOptions = {}
  ): Promise<TResponse> => {
    return await customFetch<TResponse>(url, {
      method: 'PATCH',
      body: body,
      headers: options.headers,
      query: options.query,
      // ...{ options },
    });
  };

  const put = async <
    TResponse = unknown,
    TBody extends GenericFormData = GenericFormData
  >(
    url: string,
    body: TBody,
    options: FetchOptions = {}
  ): Promise<TResponse> => {
    return await customFetch<TResponse>(url, {
      method: 'PUT',
      body: body,
      headers: options.headers,
      query: options.query,
      retry: options.retry,
      // ...{ options },
    });
  };

  const destroy = async <TResponse = unknown>(
    url: string,
    options: FetchOptions = {}
  ): Promise<TResponse> => {
    return await customFetch<TResponse>(url, {
      method: 'DELETE',
      headers: options.headers,
      query: options.query,
      retry: options.retry,
    });
  };

  return {
    getV1,
    get,
    post,
    patch,
    destroy,
    put,
  };
}
