import { defineConfig } from 'vite'

export default defineConfig({
  root: 'resources',
  base: '/',
  build: {
    outDir: '../public/build',
    emptyOutDir: true,
  }
})
