import tailwindcss from "@tailwindcss/vite";

// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-07-15',
  devtools: { enabled: process.env.PUBLIC_APP_DEBUG == 'true' ? true : false },
  debug: process.env.PUBLIC_APP_DEBUG == 'true' ? true : false,
  imports: {
    autoImport: true,
  },
  css: ['~/assets/css/main.css'],
  vite: {
    plugins: [tailwindcss()],
  },
  runtimeConfig: {
    public: {
      apiBaseURL: `${process.env.PUBLIC_API_BASE}`,
    },
  },
  app: {
    head: {
      titleTemplate: '%s - DevShop',
      meta: [
        { charset: 'utf-8' },
        { name: 'viewport', content: 'width=device-width, initial-scale=1' },
        {
          name: 'description',
          content: process.env.npm_package_description || '',
        },
      ],
      link: [{ rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }],
    },
  },
  modules: [
    'shadcn-nuxt',
    '@nuxt/eslint',
    '@sidebase/nuxt-auth',
    '@pinia/nuxt',
  ],
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
      pages: { login: '/' },
      endpoints: {
        signIn: { path: '/api/v1/auth/signin', method: 'post' },
        signOut: { path: '/api/v1/auth/signout', method: 'post' },
        signUp: { path: '/api/v1/auth/signup', method: 'post' },
        getSession: { path: '/api/v1/auth/me', method: 'get' },
      },
      token: {
        signInResponseTokenPointer: '/data/access_token',
        type: 'Bearer',
        cookieName: 'auth.token',
        headerName: 'Authorization',
        maxAgeInSeconds: 60 * 15, // 1hr need to update this to 15 mins in prod
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