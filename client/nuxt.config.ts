import tailwindcss from "@tailwindcss/vite";

// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-07-15',
  devtools: { enabled: true },
  imports: {
    autoImport: true,
  },
  css: ['~/assets/css/main.css'],
  vite: {
    plugins: [tailwindcss()],
  },
  runtimeConfig: {
    public: {
      apiBaseURL: `${process.env.PUBLIC_API_BASE}`
    }
  },
  modules: ['shadcn-nuxt', '@nuxt/eslint', '@sidebase/nuxt-auth'],
  eslint: {
    config: {
      stylistic: {
        semi: true,
        indent: 2,
        quotes: 'single',
      },
    },
  },
  shadcn: {
    /**
     * Prefix for all the imported component
     */
    prefix: '',

    /**
     * Directory that the component lives in.
     * @default "./components/ui"
     */
    componentDir: '~/components/ui',
  },
  auth: {
    globalAppMiddleware: true,
    baseURL: process.env.PUBLIC_API_BASE,
    provider: {
      type: 'local',
      pages: '/auth/signin',
      endpoints: {
        signIn: { path: '/api/auth/signin', method: 'post' },
        signOut: { path: '/api/auth/signout', method: 'post' },
        signUp: { path: '/api/auth/signup', method: 'post' },
        getSession: { path: '/api/auth/me', method: 'get' },
      },
      token: {
        signInResponseTokenPointer: '/data/access_token',
        type: 'Bearer',
        cookieName: 'auth.token',
        headerName: 'Authorization',
        maxAgeInSeconds: 60 * 60 * 1, // 1hr need to update this to 15 mins in prod
      },
      // refresh: {
      //   isEnabled: true,
      //   refreshOnlyToken: true,
      //   endpoint: { path: '/api/auth/refresh', method: 'post' },
      //   token: {
      //     refreshResponseTokenPointer: '/data/access_token',
      //     signInResponseRefreshTokenPointer: '/data/access_token', // Add this line
      //   },
      // },
      session: {
        dataType: {
          id: 'string | number',
          name: 'string',
          email: 'string',
        },
        dataResponsePointer: '/data',
      },
    },
    sessionRefresh: {
      /**
       * JWT token is set to expire every 15 minues but for
       * security reason, send a refresh token every 10 minutes
       * to update the access token on the header.
       */
      enablePeriodically: 600000, // (10 mins)in milliseconds
      enableOnWindowFocus: true,
    },
  },
  plugins: ['~/plugins/ssr-width.ts'],
});