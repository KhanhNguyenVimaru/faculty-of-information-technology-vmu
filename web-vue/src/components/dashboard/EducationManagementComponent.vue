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
              @change:page="page => onChangePage(element, page)"
              @change:perPage="per => onChangePerPage(element, per)"
              @update:data="val => element.data = val"
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
              @change:page="page => onChangePage(element, page)"
              @change:perPage="per => onChangePerPage(element, per)"
              @update:data="val => element.data = val"
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
    { id: 1, title: 'Ngành', data: [], columns: ['mã ngành', 'tên ngành', 'thông tin'], pagination: null }
  ])

  const rightSections = ref([
    { id: 2, title: 'Bộ môn', data: [], columns: ['tên bộ môn', 'trưởng khoa'], pagination: null },
    { id: 3, title: 'Giảng viên', data: [], columns: ['mã giảng viên','tên giảng viên' ,'vị trí', 'năm sinh', 'học vị'], pagination: { page: 1, perPage: 5, total: 0, lastPage: 1 } }
  ])

  // Swap logic: keep only one widget in left; return displaced one to right at original index
  const lastRemovedIndex = ref(null)

  const handleLeftChange = (e) => {
    if (e && e.added && leftSection.value.length > 1) {
      const addedItem = e.added.element
      const originalRightIndex = lastRemovedIndex.value

      const displacedItem = leftSection.value.find(w => w.id !== addedItem.id)
      if (displacedItem) {
        leftSection.value = [addedItem]
        rightSections.value.splice(originalRightIndex ?? rightSections.value.length, 0, displacedItem)
        lastRemovedIndex.value = null
      }
    }
  }

  const handleRightChange = (e) => {
    if (e && e.removed) {
      lastRemovedIndex.value = e.removed.oldIndex
    }
  }

  // Helpers: CSRF token (if available)
  const getCookie = (name) => {
    const match = document.cookie.match(new RegExp('(?:^|; )' + name.replace(/([.$?*|{}()\[\]\\\/\+^])/g, '\\$1') + '=([^;]*)'))
    return match ? decodeURIComponent(match[1]) : ''
  }

  const getCsrfHeaders = () => {
    const metaToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
    const xsrfCookie = getCookie('XSRF-TOKEN')
    return {
      'X-CSRF-TOKEN': metaToken,
      'X-XSRF-TOKEN': xsrfCookie
    }
  }

  // Fetch professors and populate the Giảng viên widget (right or main)
  const loadProfessors = async () => {
    try {
      const professorsWidget = findWidget('Giảng viên')
      const page = professorsWidget?.pagination?.page || 1
      const perPage = professorsWidget?.pagination?.perPage || 5

      const { data: json } = await http.post('/professors-data', { perpage: perPage, page, user: true })
      const rows = Array.isArray(json?.data?.data)
        ? json.data.data
        : (Array.isArray(json?.data) ? json.data : [])

      const mapped = rows.map(p => ({
        'mã giảng viên': p?.user?.id ?? '',
        'tên giảng viên': p?.user?.name ?? '',
        'vị trí': p?.position ?? '',
        'năm sinh': p?.birthdate ? new Date(p.birthdate).getFullYear() : '',
        'học vị': p?.education_level ?? ''
      }))

      const setData = (arrRef) => {
        const i = arrRef.value.findIndex(w => w.title === 'Giảng viên')
        if (i !== -1) {
          arrRef.value[i].data = mapped
          const meta = json?.data
          const total = Number(meta?.total ?? mapped.length)
          const lastPage = Number(meta?.last_page ?? 1)
          arrRef.value[i].pagination = { page, perPage, total, lastPage }
        }
      }

      setData(rightSections)
      setData(leftSection)
    } catch (err) {
      // eslint-disable-next-line no-console
      console.error('Failed to load professors:', err)
    }
  }

  onMounted(() => {
    loadProfessors()
  })

  // Helpers to find widget by title
  function findWidget(title) {
    const inLeft = leftSection.value.find(w => w.title === title)
    if (inLeft) return inLeft
    return rightSections.value.find(w => w.title === title)
  }

  // Event handlers from WidgetBox pagination
  function onChangePage(element, page) {
    if (!element.pagination) return
    element.pagination.page = page
    loadProfessors()
  }

  function onChangePerPage(element, perPage) {
    if (!element.pagination) return
    element.pagination.perPage = perPage
    element.pagination.page = 1
    loadProfessors()
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
