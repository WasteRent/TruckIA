<template>
  <div>
    <button class="btn btn-outline-gray" @click="show()"><i class="fas fa-plus mr-2"></i> Añadir recambio</button>
    
    <modal :name="modal_key" :adaptive="true" :scrollable="true" height="auto" :min-height="400" style="top: 3rem;">
      <div class="p-6 text-gray-700">
          <h1 class="font-bold text-lg">Añadir recambio</h1>
          <br>

          <form @submit.prevent="addPart">
            


            <div class="flex flex-wrap mb-6">
              <div class="w-1/2 px-3 mb-6 md:mb-0">
                  <label class="form-label">Referencia</label>
                  <input @blur="autoFillPart()" class="form-input" type="text" v-model="form.reference">
              </div>
                <div class="w-1/2 px-3 mb-6 md:mb-0">
                    <label class="form-label">Marca</label>
                    <input class="form-input" type="text" v-model="form.manufacturer">
                </div>
            </div>

            <div class="flex flex-wrap mb-6">
                <div class="w-full px-3 mb-6 md:mb-0">
                  <label class="form-label">Descripción</label>
                  <input class="form-input" type="text" v-model="form.description">
                </div>
            </div>
            
            <div class="flex flex-wrap mb-6">
                <div class="w-1/2 px-3 mb-6 md:mb-0">
                    <label class="form-label">Cantidad</label>
                    <input class="form-input" type="number" min="1" step="any" v-model="form.quantity">
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
  props: ['endpoint', 'repairOrderId', 'operationId'],
  data: function() {
    return {
       'modal_key': Math.random().toString(36),
       form: {
         repair_order_id: this.repairOrderId,
         operation_id: this.operationId,
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
    autoFillPart: function() {
      axios.get(`/fleet/spare-parts/search?term=`+this.form.reference)
        .then(response => {
          if (response.data) {
            this.form.description = response.data.description
            this.form.manufacturer = response.data.manufacturer
            this.form.reference = response.data.reference
            this.form.unit_price = response.data.unit_price
          }
        })
    },
    addPart () {
      if(!this.validateForm()) {
        alert('Debes completar todos los campos')
        return
      } 

      axios.post(this.endpoint, this.form)
        .then(response => window.location.reload())
        .catch(err => alert('Ha ocurrido un error'))
    },
    validateForm() {
      return this.form.description != ''
    },
  }
};
</script>
