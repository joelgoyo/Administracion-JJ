<template>
    <div class="container-content">
        <div class="content-title">
            <h2>Salida de dinero</h2>
            <p>Pagos y gastos administrativos</p>
        </div>

        <div class="data-clients">
            <div class="inputs-content">
                <form action="" @submit.prevent="handleSubmit">
                    <div class="inputs">
                        <div class="input">
                            <input
                                type="text"
                                placeholder="Motivo del gasto"
                                class="form-control"
                                v-model="expenses.description_expenses"
                            />
                            <!-- <p v-if="errors.name" class="text-danger">
                                {{ errors.name }}
                            </p> -->
                        </div>
                        <div class="input">
                            <select
                                name=""
                                aria-placeholder="Tipo de entrega"
                                class="form-control"
                                v-model="expenses.payment_type"
                            >
                                <option value="" class="option-default">
                                    Tipo de Gasto
                                </option>
                                <option value="pago de empleado">
                                    Pago de Empleado
                                </option>
                                <option value="Pago de Proveedor">
                                    Pago de Proveedor
                                </option>
                                <option value="Pago de comprar">
                                    Pago de Compra
                                </option>
                                <option value="Pago de comprar">
                                    Pago de impuestos
                                </option>
                                <option value="otro">Otro</option>
                            </select>

                            <!-- <p v-if="errors.dni" class="text-danger">
                                {{ errors.dni }}
                            </p> -->
                        </div>
                        <div class="input">
                            <input
                                type="text"
                                placeholder="Monto ($)"
                                class="form-control"
                                v-model="expenses.payment_amount"
                            />
                            <!-- <p v-if="errors.email" class="text-danger">
                                {{ errors.email }}
                            </p> -->
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i>
                        GUARDAR NUEVO EGRESO
                    </button>
                </form>
            </div>
        </div>

        <!-- GRÁFICA DE VENTAS
        <Datepicker
            v-model="filterByWeek"
            @update:model-value="filterBillsBySelectedWeek"
            :enable-time-picker="false"
            class="mb-3"
            placeholder="Selecciona una fecha"
        />

        <div class="content-grafics" style="height: 350px; width: 100%">
            <h2>Gastos por semana</h2>
            <Line :data="chartData" :options="chartOptions" />
        </div> -->
        <div class="table-container">
            <h2>Últimos Egresos</h2>
            <div class="d-flex justify-content-between align-items-end">
                <div class="filters">
                    <label>Filtros de búsqueda</label>
                    <div class="inputs">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Descripción"
                            v-model="filters.description"
                        />
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Tipo de pago"
                            v-model="filters.payment_type"
                        />
                    </div>
                </div>
            </div>

            <div class="content-table">
                <table class="table mt-3 table-add-bill">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Descripción</th>
                            <th>Tipo de Gasto</th>
                            <th>Monto ($)</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(expense, index) in paginatedExpenses">
                            <td>
                                <strong>{{
                                    (currentPage - 1) * pageSize + index + 1
                                }}</strong>
                            </td>
                            <td>
                                <strong>{{
                                    expense.description_expenses || "N/A"
                                }}</strong>
                            </td>
                            <td>
                                <strong>{{
                                    expense.payment_type || "N/A"
                                }}</strong>
                            </td>
                            <td>
                                <strong class="text-success"
                                    >{{
                                        expense.payment_amount || "0"
                                    }}
                                    $</strong
                                >
                            </td>
                            <td>
                                <strong>{{
                                    formatDateWithTime(expense.created_at) ||
                                    "N/A"
                                }}</strong>
                            </td>
                            <td>
                                <i
                                    class="fa-solid fa-trash"
                                    @click="deleteExpense(expense.id)"
                                    title="Eliminar"
                                ></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <span>Página {{ currentPage }} de {{ totalPages }}</span>
                <div>
                    <button
                        class="btn btn-sm btn-primary me-2 mr-2"
                        :disabled="currentPage === 1"
                        @click="currentPage--"
                    >
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button
                        class="btn btn-sm btn-primary ms-2"
                        :disabled="currentPage === totalPages"
                        @click="currentPage++"
                    >
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
import * as yup from "yup";

const validationSchema = yup.object({
    description_expenses: yup
        .string()
        .required("El motivo del gasto es requerido"),
    payment_type: yup.string().required("El tipo de gasto es requerido"),
    payment_amount: yup
        .number()
        .required("El monto es requerido")
        .positive("El monto debe ser positivo")
        .typeError("El monto debe ser un número válido"),
});

export default {
    data() {
        return {
            expenses: {
                description_expenses: "",
                payment_type: "",
                payment_amount: null,
            },
            allExpenses: [],
            filteredExpenses: [],
            currentPage: 1,
            pageSize: 10,
            filters: {
                description: "",
                payment_type: "",
            },
            errors: {},
        };
    },

    computed: {
        paginatedExpenses() {
            const start = (this.currentPage - 1) * this.pageSize;
            const end = start + this.pageSize;
            return this.filteredExpenses.slice(start, end);
        },
        totalPages() {
            return Math.ceil(this.filteredExpenses.length / this.pageSize);
        },
    },

    watch: {
        filters: {
            deep: true,
            handler() {
                this.currentPage = 1;
                this.applyFilters();
            },
        },
    },

    mounted() {
        this.fetchExpenses();
    },

    methods: {
        formatDateWithTime(dateString) {
            if (!dateString) return "";
            const date = new Date(dateString);
            return date.toLocaleString();
        },

        async fetchExpenses() {
            try {
                const response = await axios.get("/api/expenses/list");
                this.allExpenses = response.data.expenses.reverse(); // Invertir para mostrar los más recientes primero
                this.applyFilters();
            } catch (error) {
                console.error("Error al obtener los gastos:", error);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No se pudieron cargar los gastos",
                });
            }
        },

        applyFilters() {
            this.filteredExpenses = this.allExpenses.filter((expense) => {
                const descriptionMatch =
                    expense.description_expenses
                        ?.toLowerCase()
                        .includes(this.filters.description.toLowerCase()) ??
                    true;
                const paymentTypeMatch =
                    expense.payment_type
                        ?.toLowerCase()
                        .includes(this.filters.payment_type.toLowerCase()) ??
                    true;
                return descriptionMatch && paymentTypeMatch;
            });
        },

        async handleSubmit() {
            try {
                // Validar los datos
                await validationSchema.validate(this.expenses, {
                    abortEarly: false,
                });
                this.errors = {};

                // Enviar datos al servidor
                await axios.post("/api/expenses/save", this.expenses);

                // Mostrar mensaje de éxito
                await Swal.fire({
                    title: "Éxito",
                    text: "Gasto registrado correctamente",
                    icon: "success",
                    confirmButtonText: "Aceptar",
                });

                // Resetear formulario y recargar gastos
                this.expenses = {
                    description_expenses: "",
                    payment_type: "",
                    payment_amount: null,
                };
                await this.fetchExpenses();
            } catch (error) {
                this.errors = {};

                if (error.name === "ValidationError") {
                    // Manejar errores de validación
                    error.inner.forEach((err) => {
                        this.errors[err.path] = err.message;
                    });
                } else {
                    // Manejar errores del servidor
                    console.error("Error al registrar el gasto:", error);
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "No se pudo registrar el gasto",
                    });
                }
            }
        },

        async deleteExpense(id) {
            const result = await Swal.fire({
                title: "¿Estás seguro?",
                text: "No podrás revertir esto.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminarlo!",
            });

            if (result.isConfirmed) {
                try {
                    await axios.delete(`/api/expenses/delete/${id}`);
                    Swal.fire("Eliminado correctamente", "", "success");
                    await this.fetchExpenses();
                } catch (error) {
                    console.error("Error al eliminar el gasto:", error);
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "No se pudo eliminar el gasto",
                    });
                }
            }
        },
    },
};
</script>

<style>
.content-table {
    overflow-x: auto;
    width: 100%;
}
.table-add-bill {
    width: 1600px;
}
@media (max-width: 1229px) {
    .table-add-product {
        width: 1600px !important;
    }
}
@media (max-width: 675px) {
    .inputs {
        flex-wrap: wrap;
    }
    .modal-y {
        width: 80%;
    }
}
</style>
