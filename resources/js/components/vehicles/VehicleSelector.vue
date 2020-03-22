<template>
  <div>
  	<table class="table-auto w-full">
  	  <thead class="uppercase text-xs font-bold tracking-wide">
  	    <tr class="bg-gray-100 border-t border-b">
  	      <td class="px-6 py-2">Matrícula</td>
  	      <td class="px-6 py-2">Chasis</td>
  	      <td class="px-6 py-2">Equipo</td>
  	      <td class="px-6 py-2"></td>
  	    </tr>
  	  </thead>
  	  <tbody>
  	  	<tr v-for="vehicle in vehicles" class="border-t border-b text-gray-700">
  	  	  <td class="px-6 py-2">{{ vehicle.plate }}</td>
  	  	  <td class="px-6 py-2">{{ vehicle.chassis }}</td>
  	  	  <td class="px-6 py-2">{{ vehicle.equipment }}</td>
  	  	  <td class="px-6 py-2">
  	  	  	<a :href="'/set-vehicle/'+vehicle.id">Seleccionar</a>
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
    	vehicles: []
    }
  },
  methods: {
   	fetchVehicles: function() {
   		axios.get('/api/vehicle/search').then(response => this.vehicles = response.data)
   	}
  },
  created: function() {
  	this.fetchVehicles()
  } 
};
</script>


