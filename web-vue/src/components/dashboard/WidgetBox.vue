<template>
    <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden transition-all duration-200 hover:shadow-md">
      <!-- Header Section -->
      <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
        <div class="flex justify-between items-center gap-3">
          <h3 :class="[
            'font-medium text-gray-700',
            isMain ? 'text-base' : 'text-sm'
          ]">
            {{ title }}
          </h3>

          <!-- Action Controls -->
          <div class="flex items-center gap-2">
            <!-- Filter Input -->
            <div class="relative">
              <input
                v-model="filterKeyword"
                type="text"
                placeholder="Tìm kiếm..."
                :class="[
                  'pl-7 pr-2 py-1.5 border border-gray-300 rounded-md text-xs focus:ring-1 focus:ring-blue-400 focus:border-blue-400 transition-colors bg-white',
                  isMain ? 'w-40' : 'w-32'
                ]"
              />
              <svg class="absolute left-2 top-2 h-3 w-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>

            <!-- Action Buttons - Only for Main Box -->
            <div v-if="isMain" class="flex gap-1">
              <button
                @click.stop="addRow"
                class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white rounded-md font-medium transition-colors duration-200 px-2.5 py-1.5 text-xs"
              >
                <svg class="fill-current w-3 h-3 mr-1" viewBox="0 0 24 24">
                  <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                </svg>
                <span>Thêm</span>
              </button>
              <button
                @click.stop="resetTable"
                class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white rounded-md font-medium transition-colors duration-200 px-2.5 py-1.5 text-xs"
              >
                <svg class="fill-current w-3 h-3 mr-1" viewBox="0 0 24 24">
                  <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                </svg>
                <span>Reset</span>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Table Section -->
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
              <th
                v-for="col in columns"
                :key="col"
                :class="[
                  'text-left font-medium text-gray-600 normal-case tracking-wide',
                  isMain ? 'px-6 py-2.5 text-xs' : 'px-4 py-2 text-xs'
                ]"
              >
                {{ col }}
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <tr
              v-for="(row, idx) in filteredData"
              :key="idx"
              class="hover:bg-gray-25 transition-colors duration-150"
            >
              <td
                v-for="col in columns"
                :key="col"
                :class="[
                  'text-gray-700',
                  isMain ? 'px-4 py-2.5 text-sm' : 'px-3 py-2 text-xs'
                ]"
              >
                <span class="font-normal">{{ row[col] }}</span>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Empty State -->
        <div v-if="filteredData.length === 0" :class="['text-center', isMain ? 'py-8' : 'py-6']">
          <svg :class="['mx-auto text-gray-300', isMain ? 'h-10 w-10' : 'h-8 w-8']" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          <h3 :class="['mt-2 font-medium text-gray-600', isMain ? 'text-sm' : 'text-xs']">Không có dữ liệu</h3>
          <p :class="['mt-1 text-gray-400', isMain ? 'text-xs' : 'text-xs']">
            {{ filterKeyword ? 'Không tìm thấy kết quả phù hợp' : 'Chưa có dữ liệu để hiển thị' }}
          </p>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, computed } from 'vue'

  const props = defineProps({
    title: String,
    data: Array,
    columns: Array,
    isMain: Boolean
  })

  const emit = defineEmits(['update:data'])

  // Filter functionality
  const filterKeyword = ref('')
  const filteredData = computed(() => {
    if (!filterKeyword.value) return props.data
    return props.data.filter(row =>
      Object.values(row).some(val =>
        String(val).toLowerCase().includes(filterKeyword.value.toLowerCase())
      )
    )
  })

  // Reset filter
  const resetFilter = () => {
    filterKeyword.value = ''
  }
  </script>
