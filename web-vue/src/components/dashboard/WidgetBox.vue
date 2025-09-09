<template>
    <div
        class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden transition-all duration-200 hover:shadow-md relative"
    >
        <!-- Loading Overlay -->
        <div v-if="loading" class="absolute inset-0 bg-white bg-opacity-70 z-10 flex items-center justify-center">
            <div class="flex flex-col items-center">
                <svg class="animate-spin h-8 w-8 text-blue-500 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-sm text-gray-600">Đang tải...</span>
            </div>
        </div>
        <!-- Header Section -->
        <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
            <div class="flex justify-between items-center gap-3">
                <h3 class="font-medium text-gray-700 text-xs">
                    {{ title }}
                </h3>

                <!-- Action Controls -->
                <div class="flex items-center gap-2">
                    <!-- Filter Input -->
                    <div v-if="isMain" class="relative">
                        <input
                            v-model="filterKeyword"
                            type="text"
                            placeholder="Tìm kiếm..."
                            class="pl-7 pr-2 py-1 border border-gray-300 rounded text-xs focus:ring-1 focus:ring-gray-400 focus:border-gray-400 bg-white w-32"
                        />
                        <svg
                            class="absolute left-2 top-1.5 h-3 w-3 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            />
                        </svg>
                    </div>

                    <!-- Action Buttons - Only for Main Box -->
                    <div v-if="isMain" class="flex gap-1">
                        <button
                            @click.stop
                            class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white rounded px-2 py-1 text-xs"
                        >
                            <svg
                                class="w-3 h-3 mr-1"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                                />
                            </svg>
                            Thêm
                        </button>
                        <button
                            @click.stop="resetTable"
                            class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white rounded px-2 py-1 text-xs"
                        >
                            <svg
                                class="w-3 h-3 mr-1"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                                />
                            </svg>
                            Tải lại
                        </button>
                        <button
                            @click.stop
                            class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white rounded px-2 py-1 text-xs"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-3 w-3 mr-1"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"
                                />
                            </svg>
                            Bộ lọc
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th
                            v-for="col in columns"
                            :key="col"
                            class="text-left font-medium text-gray-600 px-3 py-2 text-xs"
                        >
                            {{ col }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr
                        v-for="(row, idx) in filteredData"
                        :key="idx"
                        class="hover:bg-gray-50 transition-colors duration-150"
                    >
                        <td
                            v-for="col in columns"
                            :key="col"
                            class="text-gray-700 px-3 py-2 text-xs cell-content"
                        >
                            <span class="font-normal line-clamp">{{ row[col] }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Empty State -->
            <div v-if="filteredData.length === 0" class="text-center py-6">
                <svg
                    class="mx-auto h-6 w-6 text-gray-300"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                    />
                </svg>
                <h3 class="mt-2 font-medium text-gray-600 text-xs">Không có dữ liệu</h3>
                <p class="mt-1 text-gray-400 text-xs">
                    {{
                        filterKeyword
                            ? 'Không tìm thấy kết quả phù hợp'
                            : 'Chưa có dữ liệu để hiển thị'
                    }}
                </p>
            </div>
        </div>

        <!-- Pagination Controls (bottom) -->
        <div
            v-if="pagination"
            class="px-3 py-2 border-t border-gray-200 bg-gray-50 flex items-center justify-between"
        >
            <div class="text-xs text-gray-500">
                {{ pagination.page }}/{{ pagination.lastPage }} · {{ pagination.total }} items
            </div>
            <div class="flex items-center gap-1">
                <select
                    class="border border-gray-300 rounded text-xs py-1 px-1 bg-white"
                    :value="pagination.perPage"
                    @change="(e) => emit('change:perPage', Number(e.target.value))"
                >
                    <option :value="5">5</option>
                    <option :value="10">10</option>
                    <option :value="20">20</option>
                    <option :value="50">50</option>
                </select>
                <button
                    class="px-2 py-1 text-xs border border-gray-300 rounded bg-white hover:bg-gray-50 disabled:opacity-50"
                    :disabled="pagination.page <= 1"
                    @click="emit('change:page', pagination.page - 1)"
                >
                    ←
                </button>
                <button
                    class="px-2 py-1 text-xs border border-gray-300 rounded bg-white hover:bg-gray-50 disabled:opacity-50"
                    :disabled="pagination.page >= pagination.lastPage"
                    @click="emit('change:page', pagination.page + 1)"
                >
                    →
                </button>
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
    isMain: Boolean,
    pagination: Object,
    loading: {
        type: Boolean,
        default: false
    },
})

const emit = defineEmits(['update:data', 'change:page', 'change:perPage'])

// Filter functionality
const filterKeyword = ref('')
const filteredData = computed(() => {
    if (!filterKeyword.value) return props.data
    return props.data.filter((row) =>
        Object.values(row).some((val) =>
            String(val).toLowerCase().includes(filterKeyword.value.toLowerCase()),
        ),
    )
})

// Reset table
const resetTable = () => {
    filterKeyword.value = ''
}
</script>

<style scoped>
    input, button, select, tr{
        cursor:pointer;
    }
    
    .cell-content {
        max-width: 200px;
    }
    
    .line-clamp {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
