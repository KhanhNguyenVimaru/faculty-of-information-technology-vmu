<template>
  <div class="relative w-full overflow-hidden shadow-lg">
    <!-- Slides Container -->
    <div
      class="flex transition-transform duration-500 ease-in-out"
      :style="{ transform: `translateX(-${currentSlide * 100}%)` }"
    >
      <div
        v-for="(slide, index) in slides"
        :key="index"
        class="w-full flex-shrink-0 relative"
      >
        <img
          v-if="slide.image"
          :src="slide.image"
          :alt="slide.title"
          class="w-full aspect-[3/1] object-cover"
        />
        <div v-else class="w-full aspect-[3/1] bg-black"></div>

        <div class="absolute inset-0 flex items-end">
          <div class="p-6 text-white w-full bg-gradient-to-r from-black/70 to-black/0">
            <h3 class="text-xl md:text-2xl font-bold mb-2">{{ slide.title }}</h3>
            <p class="text-sm md:text-base opacity-90">{{ slide.description }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Navigation Buttons -->
    <button
      @click="previousSlide"
      class="absolute left-4 top-1/2 transform -translate-y-1/2 rounded-full p-2 transition-all duration-200 shadow bg-black bg-opacity-50 hover:bg-opacity-70"
    >
      <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
      </svg>
    </button>

    <button
      @click="nextSlide"
      class="absolute right-4 top-1/2 transform -translate-y-1/2 rounded-full p-2 transition-all duration-200 shadow bg-black bg-opacity-50 hover:bg-opacity-70"
    >
      <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
      </svg>
    </button>

    <!-- Lines Indicator -->
    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2 w-32 justify-between">
      <div
        v-for="(slide, index) in slides"
        :key="index"
        @click="goToSlide(index)"
        class="h-1 flex-1 cursor-pointer transition-all duration-300 rounded"
        :class="currentSlide === index ? 'bg-white' : 'bg-white bg-opacity-50 hover:bg-opacity-80'"
      ></div>
    </div>

    <!-- Auto-play Toggle -->
    <button
      @click="toggleAutoPlay"
      class="absolute top-4 right-4 bg-black bg-opacity-50 hover:bg-opacity-70 text-white rounded-full p-2 transition-all duration-200"
    >
      <svg v-if="isAutoPlaying" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6"></path>
      </svg>
      <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 12l-6.518 3.764V8.236L14.752 12z" />
      </svg>
    </button>

    <!-- Language Toggle -->
    <div class="absolute top-4 left-4 flex space-x-2">
      <button
        @click="switchLanguage('vi')"
        class="px-2 py-1 text-sm font-medium rounded transition-all duration-200"
        :class="locale === 'vi' ? 'bg-white text-black' : 'bg-black bg-opacity-50 text-white hover:bg-opacity-70'"
      >
        {{ t('language.vn') }}
      </button>
      <button
        @click="switchLanguage('en')"
        class="px-2 py-1 text-sm font-medium rounded transition-all duration-200"
        :class="locale === 'en' ? 'bg-white text-black' : 'bg-black bg-opacity-50 text-white hover:bg-opacity-70'"
      >
        {{ t('language.en') }}
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { useI18n } from 'vue-i18n'

const { t, locale } = useI18n()

const currentSlide = ref(0)
const isAutoPlaying = ref(false)
let autoPlayInterval = null

const slides = computed(() => [
  { image: '/img/carousel1.png', title: t('carousel.slides.0.title'), description: t('carousel.slides.0.description') },
  { image: '/img/carousel2.jpg', title: t('carousel.slides.1.title'), description: t('carousel.slides.1.description') },
  { image: '/img/carousel3.jpg', title: t('carousel.slides.2.title'), description: t('carousel.slides.2.description') },
  { image: '/img/carousel4.jpg', title: t('carousel.slides.3.title'), description: t('carousel.slides.3.description') }
])

const nextSlide = () => {
  currentSlide.value = (currentSlide.value + 1) % slides.value.length
}

const previousSlide = () => {
  currentSlide.value = (currentSlide.value - 1 + slides.value.length) % slides.value.length
}

const goToSlide = (index) => {
  currentSlide.value = index
}

const startAutoPlay = () => {
  autoPlayInterval = setInterval(nextSlide, 4000)
}

const stopAutoPlay = () => {
  if (autoPlayInterval) {
    clearInterval(autoPlayInterval)
    autoPlayInterval = null
  }
}

const toggleAutoPlay = () => {
  isAutoPlaying.value = !isAutoPlaying.value
  if (isAutoPlaying.value) startAutoPlay()
  else stopAutoPlay()
}

const handleKeydown = (event) => {
  if (event.key === 'ArrowLeft') previousSlide()
  else if (event.key === 'ArrowRight') nextSlide()
  else if (event.key === ' ') {
    event.preventDefault()
    toggleAutoPlay()
  }
}

const switchLanguage = (lang) => {
  locale.value = lang
}

onMounted(() => {
  console.log('Slides loaded:', slides.value)
  document.addEventListener('keydown', handleKeydown)
  isAutoPlaying.value = true
  startAutoPlay()
})

onUnmounted(() => {
  document.removeEventListener('keydown', handleKeydown)
  stopAutoPlay()
})
</script>
