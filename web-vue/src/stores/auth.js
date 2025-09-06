import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const isAuthenticated = ref(false)

  function login(accountCode, password) {
    // Giả lập đăng nhập thành công
    // Trong thực tế, đây sẽ là một API call đến backend
    return new Promise((resolve) => {
      setTimeout(() => {
        // Giả lập đăng nhập thành công với tài khoản admin
        if (accountCode === 'admin' && password === 'admin') {
          user.value = {
            id: 1,
            name: 'Admin',
            accountCode: accountCode,
            role: 'admin'
          }
          isAuthenticated.value = true
          resolve(true)
        } else {
          resolve(false)
        }
      }, 1000)
    })
  }

  function logout() {
    user.value = null
    isAuthenticated.value = false
  }

  return { user, isAuthenticated, login, logout }
})