<template>
  <div>
    <button @click="show()" type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 hover:bg-indigo-50 focus:outline-none focus:border-indigo-300 focus:ring-indigo-100 active:bg-indigo-200 transition ease-in-out duration-150">
      ¿Necesitas asistencia para recambios?
    </button>
    
    <modal :name="modal_key" :adaptive="true" :scrollable="true" height="auto" :min-height="400" style="top: 3rem;">
      <div class="p-6 text-gray-700">
          <h1 class="font-bold text-xl">Ayuda</h1>
          <br>

          <p>
            Teléfono Departamento de Recambios Urban Trucks: <strong>697118757</strong>
          </p>

          <br>

          <h1 class="text-lg mb-4">{{ plate }}</h1>

          <div>
            <strong class="text-lg">Chasis</strong>
            <p>{{ chassis }}</p>
          </div>
          <br>
          <div>
            <strong class="text-lg">Equipos</strong>
            <ul>
              <li v-for="equipment in equipments">
                 {{ equipment.maker.name }} &middot; {{ equipment.model.name }} &middot; {{ equipment.version }}
              </li>
            </ul>
          </div>
          

      </div>
    </modal>
  </div>
</template>

<script>	
export default {
  props: ['plate', 'chassis', 'equipments'],
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
