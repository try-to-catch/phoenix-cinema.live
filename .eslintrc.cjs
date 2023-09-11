/* eslint-env node */
module.exports = {
    extends: ['eslint:recommended', 'plugin:@typescript-eslint/recommended-type-checked', 'plugin:vue/vue3-recommended'],
    parser: 'vue-eslint-parser',
    plugins: ['@typescript-eslint'],
    parserOptions: {
        parser: '@typescript-eslint/parser',
        project: true,
        tsconfigRootDir: __dirname,
        extraFileExtensions: ['.vue'],
    },
    root: true,
};
