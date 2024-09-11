<template>
    <div>
        <button class="btn btn-outline-gray" @click="show()">
            <i class="fas fa-plus mr-2"></i> Asignar checklist
        </button>

        <modal
            :name="modal_key"
            :adaptive="true"
            :scrollable="true"
            height="auto"
            :min-height="400"
            style="top: 3rem"
        >
            <div class="p-6 text-gray-700">
                <h1 class="font-bold text-lg">Nueva checklist</h1>
                <br />

                <form @submit.prevent="assignChecklist">
                    <div class="lg:px-3 lg:mb-0 mb-3 mt-3">
                        <label class="form-label">Listado</label>
                        <select
                            class="form-input"
                            required
                            v-model="form.checklist_id"
                        >
                            <option
                                v-for="(item, index) in checklists"
                                :key="index"
                                :value="item.id"
                            >
                                {{ item.name }}
                            </option>
                        </select>
                    </div>
                    <div class="text-center">
                        <button class="btn-indigo my-4">Guardar</button>
                    </div>
                </form>
            </div>
        </modal>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: ["endpoint", "checklists"],
    data: function () {
        return {
            modal_key: Math.random().toString(36),
            form: {
                checklist_id: "",
            },
        };
    },
    methods: {
        assignChecklist() {
            if (!this.validateForm()) {
                alert("Debes completar todos los campos");
                return;
            }

            axios
                .post(this.endpoint, this.form)
                .then(
                    (response) =>
                        (window.location.href =
                            response.headers["x-redirect-url"])
                )
                .catch((err) => alert(err));
        },
        validateForm() {
            return this.form.checklist_id != "";
        },
        show() {
            this.$modal.show(this.modal_key);
        },
        hide() {
            this.$modal.hide(this.modal_key);
        },
    },
};
</script>
