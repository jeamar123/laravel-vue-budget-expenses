import store from '../store'

export const formatNumber = (number, currency_code) => {
  let user_currency_code = store.state.auth.user?.currency_code || 'USD'
  // ₱
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: currency_code
      ? currency_code
      : user_currency_code
        ? user_currency_code
        : 'USD',
  }).format(number)
}
