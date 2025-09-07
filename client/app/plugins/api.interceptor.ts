export default defineNuxtPlugin(async (nuxtApp) => {
  const { token, signOut } = useAuth();
  const configEnv = useRuntimeConfig();

  const api = $fetch.create({
    baseURL: `${configEnv.public.apiBaseURL}/api/v1`,
    onRequest({ options }) {
      if (token.value) {
        options.headers.set('Authorization', `Bearer ${token.value}`);
      }

      if (
        options.body &&
        !options.headers.has('Content-Type') &&
        ['PUT', 'PATCH', 'POST'].includes(
          options.method?.toUpperCase() as string
        )
      ) {
        options.headers.set('Content-Type', 'application/json');
      }
    },
    async onResponseError({ response }) {
      if (response.status === 401) {
        await signOut();
        await nuxtApp.runWithContext(() => navigateTo({ path: 'auth-signin' }));
      }

      throw response;
    },
  });

  return {
    provide: { api }
  }
});
