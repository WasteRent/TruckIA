<template>
  <div>
    <div @click="show()">
      <slot name="head"></slot>
    </div>

    <modal :name="modal_key" :styles="'overflow: auto'" :adaptive="true" :scrollable="true" height="600" style="top: 2rem;">
      <div class="p-6 text-gray-700">
        <slot name="body"></slot>
      </div>
    </modal>
  </div>
</template>

<script>	
export default {
  data: function() {
    return {
       'modal_key': Math.random().toString(36)
    }
  },
  methods: {
    show () {
      this.$modal.show(this.modal_key);
    },
    hide () {
      this.$modal.hide(this.modal_key);
    }
  }
};
</script>