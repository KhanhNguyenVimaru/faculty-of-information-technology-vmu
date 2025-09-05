<template>
  <header class="university-header">
    <!-- Top Section with Logo, Search, and Language -->
    <div class="bg-white border-b border-gray-200">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-24">
          <!-- Logo and University Info -->
          <div class="flex items-center space-x-4">
            <img src="https://upload.wikimedia.org/wikipedia/vi/1/11/Bi%E1%BB%83u_tr%C6%B0ng_Tr%C6%B0%E1%BB%9Dng_%C4%91%E1%BA%A1i_h%E1%BB%8Dc_H%C3%A0ng_h%E1%BA%A3i_Vi%E1%BB%87t_Nam.svg" alt="VMU Logo" class="h-14 w-14">
            <div class="hidden md:block">
              <h1 class="text-md font-semibold text-gray-900 leading-tight tracking-[0.02em]">
                {{ $t('university_name') }}
              </h1>
              <h1 class="text-md font-semibold text-gray-900 leading-tight mt-0.5 tracking-[0.02em]">
                {{ $t('faculty_name') }}
              </h1>
            </div>
          </div>

          <!-- Search and Language -->
          <div class="flex items-center space-x-4">
            <!-- Language Switcher -->
            <div class="hidden sm:flex items-center space-x-2">
              <button class="flex items-center space-x-1 px-2 py-1 rounded hover:bg-gray-100 transition-colors cursor-pointer" @click="changeLang('vi')">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/21/Flag_of_Vietnam.svg/1200px-Flag_of_Vietnam.svg.png" alt="VN" class="w-6 h-4 rounded-sm">
                <span class="text-sm text-gray-700">{{ $t('language.vn') }}</span>
              </button>
              <button class="flex items-center space-x-1 px-2 py-1 rounded hover:bg-gray-100 transition-colors cursor-pointer" @click="changeLang('en')">
                <img src="https://img.freepik.com/free-vector/illustration-uk-flag_53876-18166.jpg?semt=ais_hybrid&w=740&q=80" alt="EN" class="w-6 h-4 rounded-sm">
                <span class="text-sm text-gray-700">{{ $t('language.en') }}</span>
              </button>
            </div>

            <!-- Search Box -->
            <div class="relative">
              <input
                type="text"
                :placeholder="$t('search_placeholder')"
                class="w-64 px-4 py-2 pr-10 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent"
                v-model="searchQuery"
              >
              <button class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Navigation Bar -->
    <nav class="shadow-sm" style="background-color: #27304D;">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-10">
          <!-- Desktop Navigation -->
          <div class="hidden md:flex items-center space-x-8 mx-auto">
            <div
              v-for="item in navigationItems"
              :key="item.name"
              class="relative group"
            >
              <button
                class="nav-link flex items-center px-3 py-0 text-sm font-medium text-gray-100 hover:text-white transition-colors duration-200 cursor-pointer"
                @click="toggleDropdown(item.name)"
              >
                {{ item.name }}
                <svg v-if="item.children" class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
              </button>

              <!--  Added hover underline transition -->
              <div class="absolute -bottom-2 left-1 w-full h-0.5 bg-white transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>


              <!-- Dropdown Menu -->
              <div
                v-if="item.children && activeDropdown === item.name"
                class="absolute top-7 left-0 mt-1 w-64 bg-white rounded-md shadow-lg border border-gray-200 z-50"
              >
                <div class="py-2">
                  <a
                    v-for="(value, key) in item.children"
                    :key="key"
                    href="#"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors"
                  >
                    {{ value }}
                  </a>
                </div>
              </div>
            </div>
          </div>

          <!-- Mobile Menu Button -->
          <div class="md:hidden flex items-center">
            <button
              @click="mobileMenuOpen = !mobileMenuOpen"
              class="text-gray-300 hover:text-white focus:outline-none focus:text-white transition-colors"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>
        </div>

        <!-- Mobile Navigation -->
        <div v-if="mobileMenuOpen" class="md:hidden border-t border-gray-700 pt-4 pb-3">
          <div class="space-y-1">
            <div v-for="item in navigationItems" :key="item.name">
              <button
                @click="toggleMobileDropdown(item.name)"
                class="w-full text-left px-3 py-2 text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition-colors"
              >
                {{ item.name }}
              </button>
              <div v-if="item.children && activeMobileDropdown === item.name" class="pl-6 space-y-1">
                <a
                  v-for="(value, key) in item.children"
                  :key="key"
                  href="#"
                  class="block px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-700 transition-colors"
                >
                  {{ value }}
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </header>
</template>

<script>
export default {
  name: 'UniversityHeader',
  data() {
    return {
      searchQuery: '',
      mobileMenuOpen: false,
      activeDropdown: null,
      activeMobileDropdown: null,
    }
  },
  methods: {
    toggleDropdown(itemName) {
      this.activeDropdown = this.activeDropdown === itemName ? null : itemName
    },
    toggleMobileDropdown(itemName) {
      this.activeMobileDropdown = this.activeMobileDropdown === itemName ? null : itemName
    },
    changeLang(lang) {
      this.$i18n.locale = lang
    }
  },
  computed: {
    navigationItems() {
      return [
        {
          name: this.$t('navigation.gioi_thieu.title'),
          children: {
            history: this.$t('navigation.gioi_thieu.children.history'),
            structure: this.$t('navigation.gioi_thieu.children.structure'),
            staff: this.$t('navigation.gioi_thieu.children.staff'),
            address: this.$t('navigation.gioi_thieu.children.address')
          }
        },
        {
          name: this.$t('navigation.dao_tao.title'),
          children: {
            undergraduate: this.$t('navigation.dao_tao.children.undergraduate'),
            postgraduate: this.$t('navigation.dao_tao.children.postgraduate'),
            results: this.$t('navigation.dao_tao.children.department'),
          }
        },
        {
          name: this.$t('navigation.tin_tuc.title'),
          children: {
            announcements: this.$t('navigation.tin_tuc.children.announcements'),
            faculty_news: this.$t('navigation.tin_tuc.children.news')
          }
        },
        {
          name: this.$t('navigation.sinh_vien.title'),
          children: {
            scholarships: this.$t('navigation.sinh_vien.children.scholarships'),
            youth_union: this.$t('navigation.sinh_vien.children.youth_union')
          }
        },
        {
          name: this.$t('navigation.tuyen_sinh.title'),
          children: {
            info: this.$t('navigation.tuyen_sinh.children.info'),
            majors: this.$t('navigation.tuyen_sinh.children.majors'),
            scores: this.$t('navigation.tuyen_sinh.children.scores')
          }
        },
        {
          name: this.$t('navigation.tuyen_dung.title'),
          children: {
            lecturers: this.$t('navigation.tuyen_dung.children.lecturer'),
            staff: this.$t('navigation.tuyen_dung.children.staff')
          }
        },
        {
          name: this.$t('navigation.tai_lieu.title'),
          children: {
            materials: this.$t('navigation.tai_lieu.children.materials'),
            excellent: this.$t('navigation.tai_lieu.children.excellent'),
            research: this.$t('navigation.tai_lieu.children.research')
          }
        }
      ]
    }
  },
  mounted() {
    document.addEventListener('click', (e) => {
      if (!e.target.closest('.group')) {
        this.activeDropdown = null
      }
    })
  }
}
</script>

<style scoped>

.nav-link {
  position: relative;
}
.university-header{
    font-family: Verdana;
}
</style>
