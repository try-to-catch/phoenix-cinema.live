/* eslint-env node */
module.exports = {
    root: true,
    extends: [
        "eslint:recommended",
        "plugin:@typescript-eslint/recommended-type-checked",
        "plugin:vue/vue3-recommended",
        "plugin:prettier/recommended"
    ],
    parser: 'vue-eslint-parser',
    plugins: ['@typescript-eslint'],
    parserOptions: {
        sourceType: "module",
        ecmaVersion: "latest",
        project: true,
        tsconfigRootDir: __dirname,
        extraFileExtensions: [".vue"],
        parser: "@typescript-eslint/parser",
        semi: false,
        singeQuote: true
    },
    globals: {
        route: true
    },
    rules: {
        "prettier/prettier": [
            "error",
            {
                singleQuote: true,
                semi: false,
                printWidth: 120
            },
            {
                usePrettierrc: true
            }
        ],
        "vue/multi-word-component-names": "off",
        "@typescript-eslint/no-redundant-type-constituents": "error"
    }
};
