<template>
  <div>
    <button class="btn btn-outline-gray" @click="show()">
      <i class="fas fa-file-import mr-2"></i> Importar
    </button>

    <modal :name="modal_key" :adaptive="true" :scrollable="true" height="auto" :min-height="400" style="top: 3rem;">
      <div class="p-6 text-gray-700">
          <h1 class="font-bold text-lg">Operaciones</h1>
          
          <div v-for="plans in groupedPlans">
            <h3 class="font-semibold pt-3">{{ plans[0].manufacturer.name }} {{ plans[0].model.name }}</h3>
            <ul>
              <li v-for="plan in plans">
                <input type="checkbox" :disabled="planHasCounter(plan.id)" name="plans" :value="plan.id" v-model="selected_plans">
                <span :class="{'line-through': planHasCounter(plan.id)}">{{ plan.name }}</span>
              </li>
            </ul>
          </div>

          <div class="text-center">
            <button class="btn-indigo my-4" :disabled="selected_plans.length == 0" @click="importCounters">Importar</button>
          </div>
          <br>
      </div>
    </modal>
  </div>
</template>

<script>	
export default {
  props: ['plans', 'currentCounters', 'vehicleId'],
  data: function() {
    return {
        modal_key: Math.random().toString(36),
        selected_plans: []
    }
  },
  computed: {
    groupedPlans: function () {
      return _.groupBy(this.plans, function(plan) {
        return plan.manufacturer_id;
      });
    }
  },
  methods: {
    importCounters () {
      axios.post(`/fleet/vehicles/${this.vehicleId}/plans/counters`, {
        plans: this.selected_plans
      }).then(response => window.location.reload())
    },
    planHasCounter (plan_id) {
      return this.currentCounters.map(counter => counter.plan_id).includes(plan_id)
    },
    show () {
      this.$modal.show(this.modal_key);
    },
    hide () {
      this.$modal.hide(this.modal_key);
    }
  }
};
</script>
