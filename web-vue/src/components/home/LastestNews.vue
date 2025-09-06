<template>
  <div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="text-center mb-10">
        <h2 class="text-lg font-bold text-gray-900 mb-2">TIN MỚI NHẤT</h2>
        <div class="w-20 h-1 bg-blue-600 mx-auto"></div>
      </div>

      <!-- News Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div
          v-for="article in articles"
          :key="article.id"
          class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300"
        >
          <!-- Image with Category Badge -->
          <div class="relative">
            <img
              :src="article.image"
              :alt="article.title"
              class="w-full h-48 object-cover"
            >
            <div
              class="absolute top-3 left-3 px-3 py-1 text-white text-xs font-semibold rounded"
              :class="getCategoryColor(article.category)"
            >
              {{ article.category }}
            </div>
          </div>

          <!-- Content -->
          <div class="p-4">
            <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 leading-tight">
              {{ article.title }}
            </h3>
            <p class="text-gray-600 text-sm line-clamp-3 leading-relaxed">
              {{ article.description }}
            </p>
            <div class="mt-3 text-xs text-gray-500">
              {{ formatDate(article.date) }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const articles = ref([
  {
    id: 1,
    category: 'MỞ ĐĂNG KÝ',
    title: 'Tuyển Hỗ trợ giảng dạy cho các lớp Đại tập',
    description: 'Để nâng cao chất lượng học tập và hỗ trợ sinh viên trong các môn học, Trường Công nghệ Thông tin và...',
    image: '/placeholder.svg?height=200&width=300',
    date: new Date('2025-01-15')
  },
  {
    id: 2,
    category: 'TIN BÀI',
    title: 'Seminar khoa học về những phương pháp hiện đại trong phân cụm mạng của PGS ĐH California',
    description: 'Trong ngày 21/08/2025, buổi seminar với chủ đề "Optimization-based Methods for Network Clustering" do PGS. Lê Minh Can (University of California, Davis)...',
    image: '/placeholder.svg?height=200&width=300',
    date: new Date('2025-01-10')
  },
  {
    id: 3,
    category: 'TIN BÀI',
    title: 'Seminar khoa học về mô rộng quy mô học đa phương thức tại trường CNTT&TT',
    description: 'Sáng 15/08/2025, Trường Công nghệ Thông tin và Truyền thông (SoICT) – ĐH Bách khoa Hà Nội đã tổ chức thành công...',
    image: '/placeholder.svg?height=200&width=300',
    date: new Date('2025-01-08')
  },
  {
    id: 4,
    category: 'THÔNG BÁO',
    title: 'Thông báo về Thực tập doanh nghiệp kỳ 2025.1',
    description: 'Trường CNTT&TT thông báo quy trình đăng ký Thực tập Doanh nghiệp (TTDN) kỳ 2025.1 như sau: Các học phần thực tập...',
    image: '/placeholder.svg?height=200&width=300',
    date: new Date('2025-01-05')
  }
])

const getCategoryColor = (category) => {
  const colors = {
    'MỞ ĐĂNG KÝ': 'bg-red-600',
    'TIN BÀI': 'bg-blue-600',
    'THÔNG BÁO': 'bg-orange-600'
  }
  return colors[category] || 'bg-gray-600'
}

const formatDate = (date) => {
  return date.toLocaleDateString('vi-VN', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
  })
}

const viewMore = () => {
  console.log('Navigating to more news...')
  // Add navigation logic here
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
