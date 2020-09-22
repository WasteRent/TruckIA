<template>
  <div>
    <div>
      <slot name="head"></slot>
    </div>
    
    <div v-show="!collapsed">
      <slot name="body"></slot>
    </div>

    <div class="text-center">
      <button @click="collapsed = !collapsed">
        <i class="text-lg text-gray-600" :class="{ 'fas fa-chevron-down': collapsed, 'fas fa-chevron-up': !collapsed }"></i>
      </button>
    </div>
  </div>
</template>

<script>	
export default {
  data: function() {
    return {
      collapsed: true
    }
  }
};
</script>
