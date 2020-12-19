<template>
  <div>
    <button @click="show()"><i class="fas fa-edit"></i></button>
    
    <modal :name="modal_key" :adaptive="true" :scrollable="true" height="auto" :min-height="400" style="top: 3rem;">
      <div class="p-6 text-gray-700">
          <h1 class="font-bold text-lg">Editar recambio</h1>
          <br>

          <form @submit.prevent="updatePart">
            
            <div class="flex flex-wrap mb-6">
                <div class="w-full px-3 mb-6 md:mb-0">
                  <label class="form-label">Descripción</label>
                  <input class="form-input" type="text" v-model="form.description">
                </div>
            </div>

            <div class="flex flex-wrap mb-6">
                <div class="w-1/2 px-3 mb-6 md:mb-0">
                    <label class="form-label">Marca</label>
                    <input class="form-input" type="text" v-model="form.manufacturer">
                </div>
                <div class="w-1/2 px-3 mb-6 md:mb-0">
                    <label class="form-label">Referencia</label>
                    <input class="form-input" type="text" v-model="form.reference">
                </div>
            </div>
            
            <div class="flex flex-wrap mb-6">
                <div class="w-1/2 px-3 mb-6 md:mb-0">
                    <label class="form-label">Cantidad</label>
                    <input class="form-input" type="number" min="1" v-model="form.quantity">
                </div>
                <div class="w-1/2 px-3 mb-6 md:mb-0">
                    <label class="form-label">Precio unitario</label>
                    <input class="form-input" type="number" step="any" v-model="form.unit_price">
                </div>
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
  props: ['endpoint', 'currentPart'],
  data: function() {
    return {
       'modal_key': Math.random().toString(36),
       form: {
         description: '',
         manufacturer: '',
         reference: '',
         unit_price: 0,
         quantity: 1
       }
    }
  },
  computed: {
  },
  methods: {
    show () {
      this.$modal.show(this.modal_key);
    },
    hide () {
      this.$modal.hide(this.modal_key);
    },
    updatePart () {
      if(!this.validateForm()) {
        alert('Debes completar todos los campos')
        return
      } 

      axios.put(this.endpoint, this.form)
        .then(response => window.location.reload())
        .catch(err => alert('Ha ocurrido un error'))
    },
    validateForm() {
      return this.form.description != '' && this.form.manufacturer != '' && this.form.reference != '' && this.form.unit_price > 0 && this.form.quantity > 0
    },
  },
  mounted: function() {
    this.form.description = this.currentPart.description
    this.form.manufacturer = this.currentPart.manufacturer
    this.form.reference = this.currentPart.reference
    this.form.unit_price = this.currentPart.unit_price
    this.form.quantity = this.currentPart.quantity
  }
};
</script>
