import { defineConfig, splitVendorChunkPlugin  } from "vite";
import symfony from "vite-plugin-symfony";
import react from '@vitejs/plugin-react'
// import reactRefresh from "@vitejs/plugin-react-refresh";

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    react(),
    symfony({
      refresh: ['templates/**/*.twig']
    }),
    splitVendorChunkPlugin(),
  ],

  build: {
      rollupOptions: {
          input: {
            app: "./assets/main.tsx", /* relative to the root option */
            theme: "./assets/index.css" 
          },
      },
  },
  resolve: {
    extensions: ['.js', '.ts', '.jsx', '.tsx', '.json', '.vue', '.mjs']
  },
  server: {
    //Set to true to force dependency pre-bundling.
    // force: true,
  },  
  optimizeDeps: {
    include: [
      '@api-platform/admin'
    ]
  }
})
