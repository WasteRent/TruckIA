<template>
  <div>
    <button class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline" @click="show()">
      Ver todas las operaciones
    </button>

    <modal :name="modal_key" :styles="'overflow: auto'" :adaptive="true" :scrollable="true" height="600" style="top: 2rem;">
      <div class="p-6 text-gray-700">
          <h1 class="font-bold text-lg">Operaciones</h1>
          <div v-for="operations in groupedOperations">
            <h3 class="font-semibold pt-3">{{ operations[0].maintenance_plan_name }}</h3>
            <ul>
              <li v-for="operation in operations">
                <span class="text-sm">
                  - {{ operation.operation_name }}
                </span>    
              </li>
            </ul>
          </div>
      </div>
    </modal>
  </div>
</template>

<script>	
export default {
  props: ['operations'],
  data: function() {
    return {
       'modal_key': Math.random().toString(36)
    }
  },
  computed: {
      groupedOperations: function () {
        return _.groupBy(this.operations, function(car) {
          return car.maintenance_plan_name;
        });
      }
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