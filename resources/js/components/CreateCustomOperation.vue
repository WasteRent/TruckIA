<template>
  <div>
    <button class="btn btn-outline-gray" @click="show()">
      <i class="fas fa-plus mr-2"></i> Crear Operación
    </button>

    <modal :name="modal_key" :adaptive="true" :scrollable="true" height="auto" :min-height="400" style="top: 3rem;">
      <div class="p-6 text-gray-700">
          <h1 class="font-bold text-lg">Crear operación</h1>
          <br>

          <form @submit.prevent="createOperation">
            <div class="lg:px-3 lg:mb-0 mb-3">
                <label class="form-label">Nombre</label>
                <input class="form-input" type="text" v-model="form.name">
            </div>
            <div class="lg:px-3 lg:mb-0 mb-3 mt-3">
                <label class="form-label">Descripción</label>
                <textarea class="form-input" v-model="form.description"></textarea>
            </div>
            <div class="lg:px-3 lg:mb-0 mb-3 mt-3">
                <label class="form-label">Tiempo estimado (H)</label>
                <input class="form-input" type="number" v-model="form.time">
            </div>

            <div class="text-center">
              <button class="btn-indigo my-4">Guardar</button>
            </div>
          </form>
          
          
      </div>
    </modal>
  </div>
</template>

<script>	
export default {
  props: ['endpoint'],
  data: function() {
    return {
        modal_key: Math.random().toString(36),
        form: {
          name: '',
          description: '',
          time: 0
        }
    }
  },
  methods: {
    createOperation () {
      if(!this.validateForm()) {
        alert('Debes completar todos los campos')
        return
      } 

      axios.post(this.endpoint, this.form)
        .then(response => window.location.reload())
        .catch(err => alert('Ha ocurrido un error'))
    },
    validateForm() {
      return this.form.time != '' && this.form.name != '' && this.form.description != ''
    },
    show () {
      this.$modal.show(this.modal_key);
    },
    hide () {
      this.$modal.hide(this.modal_key);
    }
  }
};
</script>
