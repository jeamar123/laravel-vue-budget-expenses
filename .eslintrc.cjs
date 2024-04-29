module.exports = {
  env: {
    'browser': true,
    'es2021': true
  },
  extends: [
    'eslint:recommended',
    'plugin:vue/vue3-recommended',
    'prettier'
  ],
  parserOptions: {
    'ecmaVersion': 13,
    'sourceType': 'module'
  },
  plugins: [
    'vue'
  ],
  rules: {
    'linebreak-style': [
      'error',
      'unix'
    ],
    quotes: [
      'error',
      'single'
    ],
    semi: [
      'error',
      'never'
    ],
    'no-undef': 'off',
    'vue/multi-word-component-names': 'off',
    'no-console': 'error'
  }
}
