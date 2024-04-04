import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import { svelte } from '@sveltejs/vite-plugin-svelte'
import path from 'path'

const projectRootDir = path.resolve(__dirname)

export default defineConfig({
  server: {
    port: 3000
  },
  plugins: [
    laravel({
      input: ['resources/js/app.js'],
      refresh: true
    }),
    svelte({})
  ],
  resolve: {
    alias: {
      '~': path.resolve(projectRootDir, 'resources'),
      '@': path.resolve(projectRootDir, 'resources/js')
    }
  },
  build: {
    target: 'ES2022',
    outDir: 'dist'
  },
  root: './',
  publicDir: 'public'
})
