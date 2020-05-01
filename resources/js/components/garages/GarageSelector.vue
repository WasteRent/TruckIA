<template>
  <div>
    <div class="bg-white hover:cursor-pointer px-6 py-4 shadow rounded flex mb-8" @click="show()">
      <div class="w-1/12"><i class="fas fa-warehouse fa-lg mr-3"></i></div>
      <div class="w-11/12">
        <span class="font-bold tracking-wid mr-3">2. Seleccionar Taller</span>
      </div>
      <div><i class="fas fa-chevron-right"></i></div>
    </div>

    <modal name="garage-selector-modal" :adaptive="true" :scrollable="true" height="auto" :min-height="400">
      <div class="pt-6">
          <div class="flex mb-4">
            <div class="px-3">
                <label class="form-label">Nombre</label>
                <input v-model="search.name" type="text" name="name" class="form-input">
            </div>
            <div>
                <button @click="fetchGarages()" class="mt-6 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                  <i class="fas fa-search"></i>
                </button>
            </div>
          </div>
          <table>
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Servicio Oficial</th>
                <th>Email</th>
                <th>Tel.</th>
                <th>Dirección</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="garage in garages">
                <td v-bind:class="{ 'bg-indigo-100 text-indigo-500': garage.featured }">{{ garage.name }}</td>
                <td v-bind:class="{ 'bg-indigo-100 text-indigo-500': garage.featured }">
                  {{ garage.official_service1 ? garage.official_service1.name:'' }}
                  {{ garage.official_service2 ? garage.official_service2.name:'' }}
                  {{ garage.official_service3 ? garage.official_service3.name:'' }}
                  {{ garage.official_service4 ? garage.official_service4.name:'' }}
                  {{ garage.official_service5 ? garage.official_service5.name:'' }}
                </td>
                <td v-bind:class="{ 'bg-indigo-100 text-indigo-500': garage.featured }">{{ garage.email }}</td>
                <td v-bind:class="{ 'bg-indigo-100 text-indigo-500': garage.featured }">{{ garage.phone }}</td>
                <td v-bind:class="{ 'bg-indigo-100 text-indigo-500': garage.featured }">{{ garage.address }}, {{ garage.state }}, {{ garage.province }}</td>
                <td v-bind:class="{ 'bg-indigo-100 text-indigo-500': garage.featured }">
                  <a :href="'/set-garage/'+garage.id">
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
    	garages: [],
      search: {
        name: ''
      }
    }
  },
  methods: {
    show () {
      this.$modal.show('garage-selector-modal');
    },
    hide () {
      this.$modal.hide('garage-selector-modal');
    },
   	fetchGarages: function() {
   		axios.get(this.endpoint, {
        params: this.search
      }).then(response => this.garages = response.data)
   	}
  }
};
</script>


