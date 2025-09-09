<template>
  <div class="container mx-auto px-8 py-4 max-w-[1800px]">
    <div class="grid grid-cols-12 gap-4 h-[800px]">
      <!-- Main section -->
      <draggable
        v-model="leftSection"
        item-key="id"
        class="col-span-8 min-h-[300px]"
        group="widgets"
        :animation="200"
        ghost-class="drag-ghost"
        chosen-class="drag-chosen"
        :sort="false"
        @change="handleLeftChange"
      >
        <template #item="{ element }">
          <WidgetBox
            :title="element.title"
            :data="element.data"
            :columns="element.columns"
            :isMain="true"
            :pagination="element.pagination"
            :loading="element.loading"
            @change:page="(page) => onChangePage(element, page)"
            @change:perPage="(per) => onChangePerPage(element, per)"
            @update:data="(val) => (element.data = val)"
          />
        </template>
      </draggable>

      <!-- Right sections -->
      <draggable
        v-model="rightSections"
        item-key="id"
        class="col-span-4 flex flex-col gap-4"
        group="widgets"
        :animation="200"
        ghost-class="drag-ghost"
        chosen-class="drag-chosen"
        @change="handleRightChange"
      >
        <template #item="{ element }">
          <WidgetBox
            :title="element.title"
            :data="element.data"
            :columns="element.columns"
            :isMain="false"
            :pagination="element.pagination"
            :loading="element.loading"
            @change:page="(page) => onChangePage(element, page)"
            @change:perPage="(per) => onChangePerPage(element, per)"
            @update:data="(val) => (element.data = val)"
          />
        </template>
      </draggable>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { http } from '@/lib/http'
import draggable from 'vuedraggable'
import WidgetBox from './WidgetBox.vue'

// config widgets với dữ liệu rỗng
const leftSection = ref([
  {
    id: 3,
    title: 'Giảng viên',
    data: [],
    columns: ['mã giảng viên', 'tên giảng viên', 'email', 'vị trí', 'năm sinh', 'học vị'],
    pagination: { page: 1, perPage: 10, total: 0, lastPage: 1 },
    loading: false,
  },
])

const rightSections = ref([
  {
    id: 2,
    title: 'Bộ môn',
    data: [],
    columns: ['tên bộ môn', 'trưởng khoa', 'email'],
    pagination: { page: 1, perPage: 5, total: 0, lastPage: 1 },
    loading: false,
  },
  {
    id: 1,
    title: 'Ngành',
    data: [],
    columns: ['mã ngành', 'tên ngành', 'thông tin'],
    pagination: { page: 1, perPage: 5, total: 0, lastPage: 1 },
    loading: false,
  },
])

// Swap logic: keep only one widget in left; return displaced one to right at original index
const lastRemovedIndex = ref(null)

const handleLeftChange = (e) => {
  if (e && e.added && leftSection.value.length > 1) {
    const addedItem = e.added.element
    const originalRightIndex = lastRemovedIndex.value

    const displacedItem = leftSection.value.find((w) => w.id !== addedItem.id)
    if (displacedItem) {
      // Đảm bảo dữ liệu của box được kéo lên main section được giữ nguyên
      const addedItemData = addedItem.data
      const addedItemPagination = addedItem.pagination

      leftSection.value = [addedItem]
      rightSections.value.splice(originalRightIndex ?? rightSections.value.length, 0, displacedItem)
      lastRemovedIndex.value = null

      // Cập nhật lại dữ liệu cho box trong main section
      if (addedItemData && addedItemData.length > 0) {
        leftSection.value[0].data = addedItemData
        leftSection.value[0].pagination = addedItemPagination
      } else {
        // Nếu box chưa có dữ liệu, tải lại dữ liệu tương ứng
        if (addedItem.title === 'Giảng viên') loadProfessors()
        else if (addedItem.title === 'Bộ môn') loadDepartments()
        else if (addedItem.title === 'Ngành') loadMajors()
      }
    }
  }
}

const handleRightChange = (e) => {
  if (e && e.removed) {
    lastRemovedIndex.value = e.removed.oldIndex
  }

  // Nếu có box được thêm vào rightSections, đảm bảo dữ liệu được giữ nguyên
  if (e && e.added) {
    const addedItem = e.added.element
    const addedIndex = e.added.newIndex

    // Đảm bảo dữ liệu của box được giữ nguyên
    if (addedItem && addedItem.data && addedItem.data.length > 0) {
      rightSections.value[addedIndex].data = addedItem.data
      rightSections.value[addedIndex].pagination = addedItem.pagination
    } else {
      // Nếu box chưa có dữ liệu, tải lại dữ liệu tương ứng
      if (addedItem.title === 'Giảng viên') loadProfessors()
      else if (addedItem.title === 'Bộ môn') loadDepartments()
      else if (addedItem.title === 'Ngành') loadMajors()
    }
  }
}

// Helpers: CSRF token (if available)
const getCookie = (name) => {
  const match = document.cookie.match(
    new RegExp('(?:^|; )' + name.replace(/([.$?*|{}()\[\]\\\/\+^])/g, '\\$1') + '=([^;]*)')
  )
  return match ? decodeURIComponent(match[1]) : ''
}

const getCsrfHeaders = () => {
  const metaToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
  const xsrfCookie = getCookie('XSRF-TOKEN')
  return {
    'X-CSRF-TOKEN': metaToken,
    'X-XSRF-TOKEN': xsrfCookie,
  }
}

// Fetch professors and populate the Giảng viên widget (right or main)
const loadProfessors = async () => {
  try {
    const professorsWidget = findWidget('Giảng viên')
    const page = professorsWidget?.pagination?.page || 1
    const perPage = professorsWidget?.pagination?.perPage || 5

    // Set loading state
    const setLoading = (arrRef, isLoading) => {
      const i = arrRef.value.findIndex((w) => w.title === 'Giảng viên')
      if (i !== -1) {
        arrRef.value[i].loading = isLoading
      }
    }

    // Set loading to true
    setLoading(rightSections, true)
    setLoading(leftSection, true)

    const { data: json } = await http.post('/professors-data', {
      perpage: perPage,
      page,
      user: true,
    })
    const rows = Array.isArray(json?.data?.data)
      ? json.data.data
      : Array.isArray(json?.data)
      ? json.data
      : []

    const mapped = rows.map((p) => ({
      'mã giảng viên': p?.user?.id ?? '',
      'tên giảng viên': p?.user?.name ?? '',
      email: p?.user?.email ?? '',
      'vị trí': p?.position ?? '',
      'năm sinh': p?.birthdate ? new Date(p.birthdate).getFullYear() : '',
      'học vị': p?.education_level ?? '',
    }))

    const setData = (arrRef) => {
      const i = arrRef.value.findIndex((w) => w.title === 'Giảng viên')
      if (i !== -1) {
        arrRef.value[i].data = mapped
        const meta = json?.data
        const total = Number(meta?.total ?? mapped.length)
        const lastPage = Number(meta?.last_page ?? 1)
        arrRef.value[i].pagination = { page, perPage, total, lastPage }
        // Set loading to false after data is loaded
        arrRef.value[i].loading = false
      }
    }

    setData(rightSections)
    setData(leftSection)
  } catch (err) {
    // eslint-disable-next-line no-console
    console.error('Failed to load professors:', err)

    // Set loading to false on error
    const setLoading = (arrRef, isLoading) => {
      const i = arrRef.value.findIndex((w) => w.title === 'Giảng viên')
      if (i !== -1) {
        arrRef.value[i].loading = isLoading
      }
    }
    setLoading(rightSections, false)
    setLoading(leftSection, false)
  }
}

const loadDepartments = async () => {
  try {
    const departmentsWidget = findWidget('Bộ môn')
    const page = departmentsWidget?.pagination?.page || 1
    const perPage = departmentsWidget?.pagination?.perPage || 5

    // Set loading state
    const setLoading = (arrRef, isLoading) => {
      const i = arrRef.value.findIndex((w) => w.title === 'Bộ môn')
      if (i !== -1) {
        arrRef.value[i].loading = isLoading
      }
    }

    // Set loading to true
    setLoading(rightSections, true)
    setLoading(leftSection, true)

    const { data: json } = await http.post('/departments-data', {
      perpage: perPage,
      page,
    }, { headers: getCsrfHeaders() })

    const rows = Array.isArray(json?.data?.data)
      ? json.data.data
      : Array.isArray(json?.data)
      ? json.data
      : []

    const mapped = rows.map((d) => ({
      'tên bộ môn': d?.name ?? '',
      'trưởng khoa': d?.head_user?.name ?? '',
      email: d?.head_user?.email ?? '',
    }))

    // Cập nhật dữ liệu cho cả leftSection và rightSections
    const setData = (arrRef) => {
      const i = arrRef.value.findIndex((w) => w.title === 'Bộ môn')
      if (i !== -1) {
        arrRef.value[i].data = mapped
        const meta = json?.data
        const total = Number(meta?.total ?? mapped.length)
        const lastPage = Number(meta?.last_page ?? 1)
        arrRef.value[i].pagination = { page, perPage, total, lastPage }
        // Set loading to false after data is loaded
        arrRef.value[i].loading = false
      }
    }

    setData(rightSections)
    setData(leftSection)
  } catch (err) {
    // eslint-disable-next-line no-console
    console.error('Failed to load departments:', err)

    // Set loading to false on error
    const setLoading = (arrRef, isLoading) => {
      const i = arrRef.value.findIndex((w) => w.title === 'Bộ môn')
      if (i !== -1) {
        arrRef.value[i].loading = isLoading
      }
    }
    setLoading(rightSections, false)
    setLoading(leftSection, false)
  }
}

const loadMajors = async () => {
  try {
    const majorsWidget = findWidget('Ngành')
    const page = majorsWidget?.pagination?.page || 1
    const perPage = majorsWidget?.pagination?.perPage || 5

    // Set loading state
    const setLoading = (arrRef, isLoading) => {
      const i = arrRef.value.findIndex((w) => w.title === 'Ngành')
      if (i !== -1) {
        arrRef.value[i].loading = isLoading
      }
    }
    
    // Set loading to true
    setLoading(rightSections, true)
    setLoading(leftSection, true)

    const { data: json } = await http.post('/majors-data', {
      perpage: perPage,
      page,
    }, { headers: getCsrfHeaders() })

    const rows = Array.isArray(json?.data?.data)
      ? json.data.data
      : Array.isArray(json?.data)
      ? json.data
      : []

    const mapped = rows.map((m) => ({
      'mã ngành': m?.id ?? '',
      'tên ngành': m?.major_name ?? '',
      'thông tin': m?.major_information ?? '',
    }))

    // Cập nhật dữ liệu cho cả leftSection và rightSections
    const setData = (arrRef) => {
      const i = arrRef.value.findIndex((w) => w.title === 'Ngành')
      if (i !== -1) {
        arrRef.value[i].data = mapped
        const meta = json?.data
        const total = Number(meta?.total ?? mapped.length)
        const lastPage = Number(meta?.last_page ?? 1)
        arrRef.value[i].pagination = { page, perPage, total, lastPage }
        // Set loading to false after data is loaded
        arrRef.value[i].loading = false
      }
    }

    setData(rightSections)
    setData(leftSection)
  } catch (err) {
    // eslint-disable-next-line no-console
    console.error('Failed to load majors:', err)
    
    // Set loading to false on error
    const setLoading = (arrRef, isLoading) => {
      const i = arrRef.value.findIndex((w) => w.title === 'Ngành')
      if (i !== -1) {
        arrRef.value[i].loading = isLoading
      }
    }
    setLoading(rightSections, false)
    setLoading(leftSection, false)
  }
}

async function loadAllWidgets() {
  await Promise.all([loadProfessors(), loadDepartments(), loadMajors()])
}
onMounted(() => {
  loadAllWidgets()
})

// Helpers to find widget by title
function findWidget(title) {
  const inLeft = leftSection.value.find((w) => w.title === title)
  if (inLeft) return inLeft
  return rightSections.value.find((w) => w.title === title)
}

// Event handlers from WidgetBox pagination
function onChangePage(element, page) {
  if (!element.pagination) return
  element.pagination.page = page

  // Tải dữ liệu tương ứng với loại widget
  if (element.title === 'Giảng viên') loadProfessors()
  else if (element.title === 'Bộ môn') loadDepartments()
  else if (element.title === 'Ngành') loadMajors()
}

function onChangePerPage(element, perPage) {
  if (!element.pagination) return
  element.pagination.perPage = perPage
  element.pagination.page = 1

  // Tải dữ liệu tương ứng với loại widget
  if (element.title === 'Giảng viên') loadProfessors()
  else if (element.title === 'Bộ môn') loadDepartments()
  else if (element.title === 'Ngành') loadMajors()
}
</script>

<style scoped>
.container {
  max-width: 1600px;
}

/* hiệu ứng kéo */
.drag-ghost {
  opacity: 0.5;
  background: #f0f0f0;
}
.drag-chosen {
  background: #d1e7ff !important;
}
</style>
