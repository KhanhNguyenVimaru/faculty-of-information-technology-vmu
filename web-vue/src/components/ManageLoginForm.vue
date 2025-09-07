<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">
      <!-- Header Section -->
      <div class="text-center mb-8">
        <!-- Logo -->
        <div class="flex justify-center mb-4">
          <div class="w-22 h-22 items-center justify-center">
              <img src="../../public/vmu_logo.svg" alt="" class="w-22 h-22">
          </div>
        </div>

        <!-- Title -->
        <h1 class="text-2xl font-bold text-gray-800 mb-2">
          Đăng nhập
        </h1>
        <p class="text-sm text-gray-800">
          Hệ thống quản lý nội bộ khoa CNTT
        </p>
      </div>

      <!-- Login Form -->
      <form @submit.prevent="handleLogin" class="space-y-5">
        <!-- Account Code Input -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Mã sinh viên
          </label>
          <div class="relative">
            <input
              v-model="accountCode"
              type="text"
              placeholder="Nhập email"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all duration-200 text-gray-700 placeholder-gray-400 text-md"
              required
            />
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
              <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
            </div>
          </div>
        </div>

        <!-- Password Input -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Mật khẩu
          </label>
          <div class="relative">
            <input
              v-model="password"
              :type="showPassword ? 'text' : 'password'"
              placeholder="Nhập mật khẩu"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all duration-200 text-gray-700 placeholder-gray-400 text-md"
              required
            />
            <button
              type="button"
              @click="togglePasswordVisibility"
              class="absolute inset-y-0 right-0 pr-3 flex items-center"
            >
              <svg v-if="!showPassword" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
              </svg>
              <svg v-else class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
              </svg>
            </button>
          </div>
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between text-sm mb-4">
          <div class="flex items-center">
            <input
              id="remember-me"
              v-model="rememberMe"
              type="checkbox"
              class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
            />
            <label for="remember-me" class="ml-2 text-gray-700">
              Ghi nhớ
            </label>
          </div>

          <a
            href="#"
            @click.prevent="handleForgotPassword"
            class="text-blue-600 hover:text-blue-800 transition-colors duration-200"
          >
            Quên mật khẩu?
          </a>
        </div>

        <!-- Login Button -->
        <button
          type="submit"
          :disabled="isLoading"
          class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 outline-none"
        >
          <span v-if="!isLoading">Đăng nhập</span>
          <span v-else class="flex items-center justify-center">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Đang xử lý...
          </span>
        </button>

        <!-- Additional Options -->
        <div class="text-center mt-6 pt-4 border-t border-gray-200">
          <p class="text-xs text-gray-500">
            © 2025 Trường Đại học Hàng hải Việt Nam
          </p>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useAuthStore } from '../stores/auth'

const authStore = useAuthStore()
const accountCode = ref('')
const password = ref('')
const isLoading = ref(false)
const showPassword = ref(false)
const rememberMe = ref(false)

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value
}

const handleLogin = async () => {
  if (!accountCode.value || !password.value) {
    alert('Vui lòng nhập đầy đủ thông tin')
    return
  }

  isLoading.value = true

  try {
    const success = await authStore.login(accountCode.value, password.value)

    if (success) {
      // Chuyển hướng đến trang dashboard
      window.location.href = '/dashboard'
    } else {
      alert('Đăng nhập thất bại. Vui lòng thử lại.')
    }
  } catch (error) {
    console.error('Lỗi đăng nhập:', error)
    alert('Đăng nhập thất bại. Vui lòng thử lại.')
  } finally {
    isLoading.value = false
  }
}

const handleForgotPassword = () => {
  alert('Chức năng quên mật khẩu sẽ được triển khai sau')
}
</script>
