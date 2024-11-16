/**
 * Compiler configuration
 *
 * @see {@link https://roots.io/sage/docs sage documentation}
 * @see {@link https://bud.js.org/learn/config bud.js configuration guide}
 *
 * @type {import('@roots/bud').Config}
 */
export default async (app) => {
    /**
     * @see {@link https://bud.js.org/reference/bud.setPath}
     */
    app.setPath('@scripts', './src/scripts')
    app.setPath('@styles', './src/styles')
    app.setPath('@src', '@scripts');
    app.setPath('@dist', './dist');

    const entries = {
        app: ['@scripts/app.js', '@styles/app'],
        dashboard: ['@scripts/vue/pages/settings/main.js']
    }

    /**
     * Application assets & entrypoints.
     *
     * @see {@link https://bud.js.org/reference/bud.entry}
     * @see {@link https://bud.js.org/reference/bud.assets}
     */
    app
        .entry(entries)
        .assets(['images']);

    /**
     * Development server settings
     *
     * @see {@link https://bud.js.org/reference/bud.setUrl}
     * @see {@link https://bud.js.org/reference/bud.setProxyUrl}
     * @see {@link https://bud.js.org/reference/bud.watch}
     */
    app
        .setUrl('http://localhost:3030')
        .setProxyUrl('http://localhost.wordpressplugins')
};