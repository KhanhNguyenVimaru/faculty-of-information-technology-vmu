<template>
  <Disclosure as="nav" class="relative bg-white shadow-sm border-b border-gray-200" v-slot="{ open }">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="relative flex h-16 items-center justify-between">
        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
          <!-- Mobile menu button-->
          <DisclosureButton class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:outline-2 focus:-outline-offset-1 focus:outline-indigo-500">
            <span class="absolute -inset-0.5" />
            <span class="sr-only">Open main menu</span>
            <Bars3Icon v-if="!open" class="block size-6" aria-hidden="true" />
            <XMarkIcon v-else class="block size-6" aria-hidden="true" />
          </DisclosureButton>
        </div>
        <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
          <div class="flex shrink-0 items-center">
            <router-link to="/dashboard"><img class="h-9 w-auto" src="../../public/vmu_logo.svg" alt="VMU Logo" /></router-link>
          </div>
          <div class="hidden sm:ml-6 sm:block">
            <div class="flex space-x-4">
              <router-link v-for="item in navigation" :key="item.name" :to="item.href" custom v-slot="{ navigate, isActive }">
                <a @click="navigate" :class="[isActive ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900', 'rounded-md px-3 py-2 text-sm font-medium']" :aria-current="isActive ? 'page' : undefined" style="cursor: pointer;">{{ item.name }}</a>
              </router-link>
            </div>
          </div>
        </div>
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
          <button type="button" class="relative rounded-full p-1 text-gray-600 hover:text-gray-900 focus:outline-2 focus:outline-offset-2 focus:outline-indigo-500">
            <span class="absolute -inset-1.5" />
            <span class="sr-only">View notifications</span>
            <BellIcon class="size-6" aria-hidden="true" />
          </button>

          <!-- Profile dropdown -->
          <Menu as="div" class="relative ml-3">
            <MenuButton class="relative flex rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
              <span class="absolute -inset-1.5" />
              <span class="sr-only">Open user menu</span>
              <img class="size-8 rounded-full bg-gray-50 outline -outline-offset-1 outline-gray-200" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
            </MenuButton>

            <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform scale-100" leave-to-class="transform opacity-0 scale-95">
              <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5">
                <MenuItem v-slot="{ active }">
                  <a href="#" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Tài khoản</a>
                </MenuItem>
                <MenuItem v-slot="{ active }">
                  <a href="#" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Đăng xuất</a>
                </MenuItem>
              </MenuItems>
            </transition>
          </Menu>
        </div>
      </div>
    </div>

    <DisclosurePanel class="sm:hidden">
      <div class="space-y-1 px-2 pt-2 pb-3 border-t border-gray-200">
        <router-link v-for="item in navigation" :key="item.name" :to="item.href" custom v-slot="{ navigate, isActive }">
          <DisclosureButton as="a" @click="navigate" :class="[isActive ? 'bg-indigo-100 text-indigo-700' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900', 'block rounded-md px-3 py-2 text-base font-medium']" :aria-current="isActive ? 'page' : undefined">{{ item.name }}</DisclosureButton>
        </router-link>
      </div>
    </DisclosurePanel>
  </Disclosure>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, BellIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import { useRoute } from 'vue-router'

const route = useRoute()

const navigation = [
  { name: 'Dashboard', href: '/dashboard', current: false },
  { name: 'Bài viết', href: '/posts', current: false },
  { name: 'Sinh viên', href: '/students', current: false },
  { name: 'Giảng viên', href: '/professors', current: false },
  { name: 'Quản lý đào tạo', href: '/education-management', current: false },
  { name: 'Tuyển sinh', href: '/admission', current: false },
  { name: 'Cài đặt', href: '/settings', current: false },
]
</script>
