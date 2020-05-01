<template>
  <div>
    <div class="bg-white hover:cursor-pointer px-6 py-4 shadow rounded flex mb-8" @click="show()">
      <div class="w-1/12"><i class="fas fa-bus fa-lg mr-3"></i></div>
      <div class="w-11/12">
        <span class="font-bold tracking-wid mr-3">1. Seleccionar Vehículo</span>
      </div>
      <div><i class="fas fa-chevron-right"></i></div>
    </div>

    <modal name="vehicle-selector-modal" :adaptive="true" :scrollable="true" height="auto" :min-height="400">
      <div class="pt-6">
        <div class="flex mb-4">
          <div class="px-3">
              <label class="form-label">Matrícula</label>
              <input v-model="search.plate" type="text" name="plate" class="form-input" placeholder="Ej: 9820JVP">
          </div>
          <div>
              <button @click="fetchVehicles()" class="mt-6 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-search"></i>
              </button>
          </div>
        </div>
        <table>
          <thead>
            <tr>
              <th>Matrícula</th>
              <th>Chasis</th>
              <th>Tipo</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="vehicle in vehicles">
              <td>{{ vehicle.plate }}</td>
              <td>{{ vehicle.chassis }}</td>
              <td>{{ vehicle.type }}</td>
              <td>
                <a :href="'/set-vehicle/'+vehicle.id">
                  <i class="fas fa-hand-pointer"></i>   
                </a>
              </td>     
            </tr>
          </tbody>
        </table>
      </div>
    </modal>
  </div>
</template>

<script>	
export default {
  props: ['endpoint'],
  data: function() {
    return {
    	vehicles: [],
      search: {
        plate: ''
      }
    }
  },
  methods: {
    show () {
      this.$modal.show('vehicle-selector-modal');
    },
    hide () {
      this.$modal.hide('vehicle-selector-modal');
    },
   	fetchVehicles: function() {
   		axios.get(this.endpoint, {
        params: this.search
      }).then(response => this.vehicles = response.data)
   	}
  }
};
</script>


