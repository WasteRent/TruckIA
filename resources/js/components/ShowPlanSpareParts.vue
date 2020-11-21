<template>
  <div>
    <button @click="show()" type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 hover:bg-indigo-50 focus:outline-none focus:border-indigo-300 focus:ring-indigo active:bg-indigo-200 transition ease-in-out duration-150">
      Recambios asociados
    </button>
    
    <modal :name="modal_key" :adaptive="true" :scrollable="true" height="auto" :min-height="400" style="top: 3rem;">
      <div class="p-6 text-gray-700">
          <h1 class="font-bold text-lg">Recambios</h1>
          <br>
          
          <table v-if="parts.length > 0">
            <thead>
              <tr>
                <th>Descripción</th>
                <th>Marca</th>
                <th>Referencia</th>
                <th>Precio unitario</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="part in parts">
                <td>{{ part.description }}</td>
                <td>{{ part.manufacturer }}</td>
                <td>
                  {{ part.reference }}
                  <span v-if="part.quantity > 1" class="bg-indigo-600 rounded-full px-1 text-white text-xs">x{{ part.quantity }}</span>
                </td>
                <td>{{ part.unit_price }}&euro;</td>
              </tr>
            </tbody>
          </table>

          <div v-else>
            No hay recambios disponibles.
          </div>

      </div>
    </modal>
  </div>
</template>

<script>	
export default {
  props: ['parts'],
  data: function() {
    return {
       'modal_key': Math.random().toString(36)
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
    }
  }
};
</script>
