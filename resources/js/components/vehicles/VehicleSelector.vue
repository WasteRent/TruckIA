<template>
  <div>
  	<table class="table-auto w-full">
  	  <thead class="uppercase text-xs font-bold tracking-wide">
  	    <tr class="bg-gray-100 border-t border-b">
  	      <td class="px-6 py-2">Nombre</td>
  	      <td class="px-6 py-2">Email</td>
  	      <td class="px-6 py-2">Tel.</td>
  	      <td class="px-6 py-2">Dirección</td>
  	      <td class="px-6 py-2"></td>
  	    </tr>
  	  </thead>
  	  <tbody>
  	  	<tr v-for="garage in garages" class="border-t border-b text-gray-700">
  	  	  <td class="px-6 py-2">{{ garage.name }}</td>
  	  	  <td class="px-6 py-2">{{ garage.email }}</td>
  	  	  <td class="px-6 py-2">{{ garage.phone }}</td>
  	  	  <td class="px-6 py-2">{{ garage.address }}, {{ garage.state }}, {{ garage.province }}</td>
  	  	  <td class="px-6 py-2">
  	  	  	<button @click="setGarage(garage.id)">Seleccionar</button>
  	  	  </td>  	  
  	  	</tr>
  	  </tbody>
  	</table>
  </div>
</template>

<script>	
export default {
  props: [],
  data: function() {
    return {
    	garages: []
    }
  },
  methods: {
   	fetchGarages: function() {
   		axios.get('/api/garage/search').then(response => this.garages = response.data)
   	},
   	setGarage: function(id) {
   		axios.post('/api/set-garage', {'id': id}).then(response => location.reload())
   	}
  },
  created: function() {
  	this.fetchGarages()
  } 
};
</script>

