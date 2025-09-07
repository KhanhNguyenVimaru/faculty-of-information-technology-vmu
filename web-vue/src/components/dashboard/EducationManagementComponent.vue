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
              @update:data="val => element.data = val"
            />
          </template>
        </draggable>
      </div>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue'
  import draggable from 'vuedraggable'
  import WidgetBox from './WidgetBox.vue'

  // config widgets với dữ liệu rỗng
  const leftSection = ref([
    { id: 1, title: 'Ngành', data: [], columns: ['mã ngành', 'tên ngành', 'thông tin'] }
  ])

  const rightSections = ref([
    { id: 2, title: 'Bộ môn', data: [], columns: ['tên bộ môn', 'trưởng khoa'] },
    { id: 3, title: 'Giảng viên', data: [], columns: ['mã giảng viên','tên giảng viên' ,'vị trí', 'năm sinh', 'học vị'] }
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
