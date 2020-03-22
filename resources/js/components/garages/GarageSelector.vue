<template>
  <div>
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
  	  	  	<a :href="'/set-garage/'+garage.id">
              <i class="fas fa-hand-pointer"></i>   
            </a>
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
    	garages: [],
      search: {
        name: ''
      }
    }
  },
  methods: {
   	fetchGarages: function() {
   		axios.get('/api/garage/search', {
        params: this.search
      }).then(response => this.garages = response.data)
   	}
  },
  created: function() {
  	this.fetchGarages()
  } 
};
</script>


