<template>
  <div class="h-screen flex overflow-hidden bg-gray-100">
    <!-- Off-canvas menu for mobile -->
    <div class="md:hidden">
      <div class="fixed inset-0 flex z-40" :class="showBar ? 'block' : 'hidden'">
        <!--
          Off-canvas menu overlay, show/hide based on off-canvas menu state.

          Entering: "transition-opacity ease-linear duration-300"
            From: "opacity-0"
            To: "opacity-100"
          Leaving: "transition-opacity ease-linear duration-300"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div class="fixed inset-0">
          <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
        </div>
        <!--
          Off-canvas menu, show/hide based on off-canvas menu state.

          Entering: "transition ease-in-out duration-300 transform"
            From: "-translate-x-full"
            To: "translate-x-0"
          Leaving: "transition ease-in-out duration-300 transform"
            From: "translate-x-0"
            To: "-translate-x-full"
        -->
        <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-indigo-800">
          <div class="absolute top-0 right-0 -mr-14 p-1">
            <button @click="showBar = !showBar" class="flex items-center justify-center h-12 w-12 rounded-full focus:outline-none focus:bg-gray-600" aria-label="Close sidebar">
              <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <div class="flex-shrink-0 flex items-center px-4">
            <a href="/"><img class="h-10 w-auto" :src="logo"/></a>
          </div>
          <div class="mt-5 flex-1 h-0 overflow-y-auto">
            <nav class="px-2">
              <span v-for="item in navItems">
                <a :href="item.link" class="group flex items-center px-2 py-2 text-sm leading-5 font-medium rounded-md focus:outline-none focus:bg-indigo-700 transition ease-in-out duration-150" :class="item.active ? 'text-white bg-indigo-900' : 'hover:text-white hover:bg-indigo-700 focus:text-white text-indigo-300'">
                  <i class="mr-3 text-indigo-400 group-focus:text-indigo-300 transition ease-in-out duration-150" v-html="item.icon"></i>
                  {{ item.name }} 

                  <span v-if="item.badge" class="ml-2 inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-white text-indigo-800">
                    {{ item.badge }}
                  </span>
                </a>
                <div v-if="item.end_section" class="mb-6"></div>
              </span>
              
            </nav>
          </div>
        </div>
        <div class="flex-shrink-0 w-14">
          <!-- Dummy element to force sidebar to shrink to fit close icon -->
        </div>
      </div>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden md:flex md:flex-shrink-0">
      <div class="flex flex-col w-64 bg-indigo-800 pt-5 pb-4">
        <div class="flex items-center flex-shrink-0 px-4">
          <a href="/"><img class="h-12 w-auto" :src="logo" /></a>
        </div>
        <div class="mt-5 h-0 flex-1 flex flex-col overflow-y-auto">
          <!-- Sidebar component, swap this element with another sidebar if you like -->
          <nav class="flex-1 px-2 bg-indigo-800">
            <span v-for="item in navItems">
              <a :href="item.link" class="group flex items-center px-2 py-2 text-sm leading-5 font-medium rounded-md focus:outline-none focus:bg-indigo-700 transition ease-in-out duration-150" :class="item.active ? 'text-white bg-indigo-900' : 'hover:text-white hover:bg-indigo-700 focus:text-white text-indigo-300'">
                <i :class="item.active ? 'text-white' : 'text-indigo-400 group-focus:text-indigo-300'" class="mr-3 transition ease-in-out duration-150" v-html="item.icon"></i>
                {{ item.name }} 

                <span v-if="item.badge" class="ml-2 inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-white text-indigo-800">
                  {{ item.badge }}
                </span>
              </a>
              <div v-if="item.end_section" class="mb-6"></div>
            </span>
          </nav>
        </div>
      </div>
    </div>
    <div class="flex flex-col w-0 flex-1 overflow-hidden">
      <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
        <button class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:bg-gray-100 focus:text-gray-600 md:hidden" aria-label="Open sidebar" @click="showBar = !showBar">
          <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
          </svg>
        </button>
        <div class="flex-1 px-4 flex justify-between">
          <div class="flex-1 flex">
            <div class="w-full flex items-center md:ml-0">
              <h1 class="text-2xl font-semibold text-gray-900" v-html="title"></h1>
            </div>
          </div>
          <div class="ml-4 flex items-center md:ml-6">
            <!-- Profile dropdown -->
            <div class="ml-3 relative">
              <div class="flex items-center" @click="showProfile = !showProfile">
                <span class="text-sm leading-5 font-medium text-gray-700 group-hover:text-gray-900 mr-3">{{ profile.name }}</span>
                <button class="max-w-xs flex items-center text-sm rounded-full focus:outline-none focus:shadow-outline" id="user-menu" aria-label="User menu" aria-haspopup="true">
                  <img class="h-10 w-10 rounded-full" :src="profile.avatar" />
                </button>
              </div>
              <!--
                Profile dropdown panel, show/hide based on dropdown state.

                Entering: "transition ease-out duration-100"
                  From: "transform opacity-0 scale-95"
                  To: "transform opacity-100 scale-100"
                Leaving: "transition ease-in duration-75"
                  From: "transform opacity-100 scale-100"
                  To: "transform opacity-0 scale-95"
              -->
              <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg" :class="showProfile ? 'block' : 'hidden'">
                <div class="py-1 rounded-md bg-white shadow-xs" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                  <a :href="profile.form_url" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150" role="menuitem">Perfil
                  </a>
                  <form class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150" action="/logout" method="POST">
                    <button>Salir</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <main class="flex-1 relative z-0 overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <div class="max-w-7xl mx-auto px-2 sm:px-6">
          <slot></slot>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['navItems', 'title', 'logo', 'profile'],
    data: () => ({
      showBar: false,
      showProfile: false
    })
  }
</script>