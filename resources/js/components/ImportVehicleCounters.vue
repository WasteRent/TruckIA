<template>
  <div>
    <button class="btn btn-outline-gray" @click="show()">
      <i class="fas fa-file-import mr-2"></i> Importar
    </button>

    <modal :name="modal_key" :styles="'overflow: auto'" :adaptive="true" :scrollable="true" height="600" style="top: 2rem;">
      <div class="px-6 py-2 text-gray-700 text-sm">
          <h1 class="font-bold">Mantenimientos</h1>

          <!-- Search Field -->
          <div class="my-4">
            <input
              type="text"
              v-model="searchQuery"
              placeholder="Buscar por nombre..."
              class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm"
            >
          </div>

          <!-- Select All Filtered Button -->
          <div v-if="searchQuery && filteredGroupedPlans && Object.keys(filteredGroupedPlans).length > 0" class="mb-3">
            <button
              @click="selectAllFiltered"
              class="btn btn-sm btn-outline-primary mr-2"
              :disabled="areAllFilteredPlansSelected"
            >
              {{ areAllFilteredPlansSelected ? 'Todos seleccionados' : 'Seleccionar todos los filtrados' }}
            </button>
            <button
              @click="deselectAllFiltered"
              class="btn btn-sm btn-outline-secondary"
              :disabled="!hasAnyFilteredPlanSelected"
            >
              Deseleccionar todos los filtrados
            </button>
          </div>

          <div v-for="(plans, groupKey) in filteredGroupedPlans">
            <div class="flex items-center pt-3">
              <input
                type="checkbox"
                :checked="isGroupFullySelected(plans)"
                :indeterminate.prop="isGroupPartiallySelected(plans)"
                @change="toggleGroupSelection(plans, $event.target.checked)"
                :disabled="areAllPlansInGroupDisabled(plans)"
                class="mr-2"
              >
              <h3 class="font-semibold">{{ plans[0].name.substring(0, 10) }} {{ plans[0].manufacturer ? plans[0].manufacturer.name : '' }} {{ plans[0].model ? plans[0].model.name : '' }}....</h3>
            </div>
            <ul class="ml-6">
              <li v-for="plan in plans">
                <input type="checkbox" :disabled="planHasCounter(plan.id)" name="plans" :value="plan.id" v-model="selected_plans">
                <span :class="{'line-through': planHasCounter(plan.id)}">{{ plan.name }}, {{ plan.euro }} {{ plan.power_kw }} <small>ID:{{plan.id}}</small></span>
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
        selected_plans: [],
        searchQuery: ''
    }
  },
  computed: {
    groupedPlans: function () {
      console.log(this.plans);
      return _.groupBy(this.plans, function(plan) {
        return plan.name.substring(0, 10) + plan.manufacturer_id + plan.model_id;
      });
    },
    filteredGroupedPlans: function () {
      if (!this.searchQuery) {
        return this.groupedPlans;
      }

      const filtered = {};
      const query = this.searchQuery.toLowerCase();

      Object.keys(this.groupedPlans).forEach(groupKey => {
        const filteredPlans = this.groupedPlans[groupKey].filter(plan =>
          plan.name.toLowerCase().includes(query)
        );

        if (filteredPlans.length > 0) {
          filtered[groupKey] = filteredPlans;
        }
      });

      return filtered;
    },
    areAllFilteredPlansSelected: function () {
      const allFilteredPlans = [];
      Object.values(this.filteredGroupedPlans).forEach(plans => {
        plans.forEach(plan => {
          if (!this.planHasCounter(plan.id)) {
            allFilteredPlans.push(plan.id);
          }
        });
      });

      return allFilteredPlans.length > 0 && allFilteredPlans.every(planId =>
        this.selected_plans.includes(planId)
      );
    },
    hasAnyFilteredPlanSelected: function () {
      const allFilteredPlans = [];
      Object.values(this.filteredGroupedPlans).forEach(plans => {
        plans.forEach(plan => {
          if (!this.planHasCounter(plan.id)) {
            allFilteredPlans.push(plan.id);
          }
        });
      });

      return allFilteredPlans.some(planId => this.selected_plans.includes(planId));
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
    },
    isGroupFullySelected (plans) {
      const enabledPlans = plans.filter(plan => !this.planHasCounter(plan.id));
      if (enabledPlans.length === 0) return false;
      return enabledPlans.every(plan => this.selected_plans.includes(plan.id));
    },
    isGroupPartiallySelected (plans) {
      const enabledPlans = plans.filter(plan => !this.planHasCounter(plan.id));
      if (enabledPlans.length === 0) return false;
      const selectedCount = enabledPlans.filter(plan => this.selected_plans.includes(plan.id)).length;
      return selectedCount > 0 && selectedCount < enabledPlans.length;
    },
    areAllPlansInGroupDisabled (plans) {
      return plans.every(plan => this.planHasCounter(plan.id));
    },
    toggleGroupSelection (plans, checked) {
      const enabledPlans = plans.filter(plan => !this.planHasCounter(plan.id));

      enabledPlans.forEach(plan => {
        const index = this.selected_plans.indexOf(plan.id);
        if (checked && index === -1) {
          this.selected_plans.push(plan.id);
        } else if (!checked && index !== -1) {
          this.selected_plans.splice(index, 1);
        }
      });
    },
    selectAllFiltered () {
      Object.values(this.filteredGroupedPlans).forEach(plans => {
        plans.forEach(plan => {
          if (!this.planHasCounter(plan.id) && !this.selected_plans.includes(plan.id)) {
            this.selected_plans.push(plan.id);
          }
        });
      });
    },
    deselectAllFiltered () {
      Object.values(this.filteredGroupedPlans).forEach(plans => {
        plans.forEach(plan => {
          const index = this.selected_plans.indexOf(plan.id);
          if (index !== -1) {
            this.selected_plans.splice(index, 1);
          }
        });
      });
    }
  }
};
</script>
