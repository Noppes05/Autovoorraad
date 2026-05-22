import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '');
    const appUrl = new URL(env.APP_URL || 'http://localhost');
    const appHost = appUrl.hostname;
    const isHttps = appUrl.protocol === 'https:';
    const escapedAppHost = appHost.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    const tenantOriginPattern = new RegExp(`^https?:\\/\\/(?:[a-z0-9-]+\\.)*${escapedAppHost}(?::\\d+)?$`, 'i');

    return {
        server: {
            host: '0.0.0.0',
            port: 5173,
            strictPort: true,
            cors: {
                origin: [appUrl.origin, tenantOriginPattern],
                credentials: true,
            },
            hmr: {
                host: appHost,
                protocol: isHttps ? 'wss' : 'ws',
                port: 5173,
            },
        },
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true,
                detectTls: appHost.endsWith('.test') ? appHost : undefined,
            }),
        ],
    };
});
