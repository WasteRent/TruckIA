<template>
  <Transition name="fade">
    <div v-if="showing" @click.self="close" class="fixed inset-0 w-full h-screen flex items-center justify-center bg-semi-55">
      <div class="relative bg-white shadow-lg rounded-lg p-8">
        <button @click.prevent="close" aria-label="close" class="absolute top-0 right-0 text-xl text-gray-500 my-2 mx-4">
          <i class="fas fa-times"></i>
        </button>

        <header>
          <h1 class="text-xl font-medium text-gray-800">
            <slot name="header"></slot>
          </h1>
        </header>
        <main>
          <slot></slot>
        </main>
        <footer>
          <slot name="footer"></slot>
        </footer>

      </div>
    </div>
  </Transition>
</template>

<script>
export default {
  props: {
    showing: {
      required: true,
      type: Boolean
    }
  },
  watch: {
    showing(value) {
      if (value) {
        return document.querySelector('body').classList.add('overflow-hidden');
      }
      document.querySelector('body').classList.remove('overflow-hidden');
    }
  },
  methods: {
    close() {
      this.showing = false
    }
  }
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: all 0.4s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
