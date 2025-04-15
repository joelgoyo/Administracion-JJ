<template>
    <div class="container-content">
        <div class="content-title">
            <h2>Estadísticas de ventas</h2>
            <p>Estadísticas</p>
        </div>

        <!-- GRÁFICA DE VENTAS -->

        <Datepicker
            v-model="filterByWeek"
            @update:model-value="filterBillsBySelectedWeek"
            :enable-time-picker="false"
            class="mb-3"
            placeholder="Selecciona una fecha"
        />

        <div class="content-grafics" style="height: 350px; width: 100%">
            <h2>Ventas semanles</h2>
            <Line :data="chartData" :options="chartOptions" />
        </div>

        <!-- FILTROS Y TABLA DE FACTURAS -->
        <div class="table-container">
            <h2>Ultimas facturas</h2>
            <div class="d-flex justify-content-between align-items-end">
                <div class="filters">
                    <label for="">Filtros de búsqueda</label>
                    <div class="inputs">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="RIF/C.I"
                            v-model="filters.dni"
                        />
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Nombre y apellido"
                            v-model="filters.name"
                        />
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Nro de orden"
                            v-model="filters.order"
                        />
                    </div>
                </div>
            </div>

            <div class="content-table">
                <table class="table mt-3 table-add-bill">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Facturado</th>
                            <th>Nro - Factura</th>
                            <th>C.I</th>
                            <th>Tipo de pago</th>
                            <th>Banco</th>
                            <th>Fecha de facturación</th>
                            <th>Pago en Bs</th>
                            <th>Pago en $</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(bill, index) in paginatedBills">
                            <td>
                                <strong>{{
                                    (currentPage - 1) * pageSize + index + 1
                                }}</strong>
                            </td>

                            <td>
                                <strong
                                    >{{ bill.client?.name || "N/A" }}
                                    {{
                                        bill.client?.last_name || "N/A"
                                    }}</strong
                                >
                            </td>
                            <td>
                                <strong>{{ bill.order || "N/A" }}</strong>
                            </td>
                            <td>
                                <strong>{{ bill.client?.dni || "N/A" }}</strong>
                            </td>
                            <td>
                                <strong>{{ bill.typePayment || "N/A" }}</strong>
                            </td>
                            <td>
                                <strong>{{ bill.bank || "N/A" }}</strong>
                            </td>
                            <td>
                                <strong>{{
                                    formatDateWithTime(bill.created_at) || "N/A"
                                }}</strong>
                            </td>
                            <td>
                                <strong class="text-success"
                                    >{{ bill.amount_bs || "0" }} Bs</strong
                                >
                            </td>
                            <td>
                                <strong class="text-success"
                                    >{{ bill.amount || "0" }} $</strong
                                >
                            </td>
                            <td>
                                <i
                                    class="fa-solid fa-trash"
                                    @click="deleteBill(bill.id)"
                                    title="Eliminar"
                                ></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="mr-2"
                    >Página {{ currentPage }} de {{ totalPages }}</span
                >
                <div>
                    <button
                        class="btn btn-sm btn-primary me-2 mr-2"
                        :disabled="currentPage === 1"
                        @click="currentPage--"
                    >
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button
                        class="btn btn-sm btn-primary ms-2 mr-2"
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
import { format } from "date-fns";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    PointElement,
    CategoryScale,
    LinearScale,
} from "chart.js";
import { Line } from "vue-chartjs";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    PointElement,
    CategoryScale,
    LinearScale
);

export default {
    components: { Line, Datepicker },
    data() {
        return {
            filterByWeek: null,
            bills: [],
            allBills: [],
            selectedWeek: "all",
            currentPage: 1,
            pageSize: 10,
            filters: {
                dni: "",
                name: "",
                email: "",
                order: "",
            },
            chartData: {
                labels: [],
                datasets: [],
            },
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: "top",
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const value = context.parsed.y;
                                return `Ventas: $${value.toFixed(2)}`;
                            },
                        },
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: "Fecha",
                        },
                    },
                    y: {
                        title: {
                            display: true,
                            text: "",
                        },
                        beginAtZero: true,
                    },
                },
            },
        };
    },
    computed: {
        filteredBills() {
            return this.bills.filter((bill) => {
                const dniMatch = bill.client?.dni
                    ?.toLowerCase()
                    .includes(this.filters.dni.toLowerCase());

                const nameMatch = (
                    (bill.client?.name || "") +
                    " " +
                    (bill.client?.last_name || "")
                )
                    .toLowerCase()
                    .includes(this.filters.name.toLowerCase());

                const orderMatch = (bill.order || "")
                    .toLowerCase()
                    .includes(this.filters.order?.toLowerCase() || "");

                return dniMatch && nameMatch && orderMatch;
            });
        },
        paginatedBills() {
            const start = (this.currentPage - 1) * this.pageSize;
            const end = start + this.pageSize;
            return this.filteredBills.slice(start, end);
        },
        totalPages() {
            return Math.ceil(this.filteredBills.length / this.pageSize);
        },
    },
    watch: {
        filters: {
            deep: true,
            handler() {
                this.currentPage = 1;
            },
        },
    },
    mounted() {
        this.fetchBills();
    },

    methods: {
        formatDateWithTime(dateString) {
            if (!dateString) return "";
            const date = new Date(dateString);
            return date.toLocaleString();
        },
        fetchBills() {
            axios
                .get("/api/billing/list")
                .then((response) => {
                    const facturas = response.data.billing.reverse();
                    this.allBills = facturas;
                    this.bills = facturas;
                    this.filterByWeek(); // aplicar filtro al cargar
                })
                .catch((error) => {
                    console.error("Error al obtener las facturas:", error);
                });
        },
        filterByWeek() {
            const now = new Date();
            const day = now.getDay(); // 0: domingo, 1: lunes, ...
            const monday = new Date(now);
            monday.setDate(now.getDate() - (day === 0 ? 6 : day - 1)); // lunes actual
            const sunday = new Date(monday);
            sunday.setDate(monday.getDate() + 6); // domingo actual

            let filtered = this.allBills;

            if (this.selectedWeek === "current") {
                filtered = this.allBills.filter((bill) => {
                    const date = new Date(bill.created_at);
                    return date >= monday && date <= sunday;
                });
            }

            if (this.selectedWeek === "previous") {
                const lastMonday = new Date(monday);
                lastMonday.setDate(monday.getDate() - 7);
                const lastSunday = new Date(sunday);
                lastSunday.setDate(sunday.getDate() - 7);

                filtered = this.allBills.filter((bill) => {
                    const date = new Date(bill.created_at);
                    return date >= lastMonday && date <= lastSunday;
                });
            }

            this.bills = filtered;
            this.generateChart();
        },
        filterBillsBySelectedWeek(date) {
            if (!date) {
                this.bills = this.allBills;
                this.generateChart();
                return;
            }

            const selected = new Date(date);
            const day = selected.getDay(); // 0 (domingo) a 6 (sábado)
            const monday = new Date(selected);
            monday.setDate(selected.getDate() - (day === 0 ? 6 : day - 1));
            monday.setHours(0, 0, 0, 0);

            const sunday = new Date(monday);
            sunday.setDate(monday.getDate() + 6);
            sunday.setHours(23, 59, 59, 999);

            this.bills = this.allBills.filter((bill) => {
                const created = new Date(bill.created_at);
                return created >= monday && created <= sunday;
            });

            this.generateChart();
        },

        generateChart() {
            const grouped = {};

            this.bills.forEach((bill) => {
                const date = format(new Date(bill.created_at), "yyyy-MM-dd");
                const amount = parseFloat(bill.amount || 0);
                if (!grouped[date]) {
                    grouped[date] = 0;
                }
                grouped[date] += amount;
            });

            const sortedDates = Object.keys(grouped).sort();
            const dailyTotals = sortedDates.map((date) => grouped[date]);

            const total = dailyTotals.reduce((sum, val) => sum + val, 0);
            const promedio =
                dailyTotals.length > 0 ? total / dailyTotals.length : 0;

            const newData = {
                labels: sortedDates,
                datasets: [
                    {
                        label: "Ventas diarias (Monto Total $)",
                        data: dailyTotals,
                        backgroundColor: "rgba(25, 88, 247, 0.2)",
                        borderColor: "#1958f7",
                        pointBackgroundColor: "#1958f7",
                        fill: true,
                        tension: 0.3,
                    },
                    {
                        label: "Promedio diario",
                        data: sortedDates.map(() => promedio),
                        borderColor: "#f78319",
                        borderDash: [5, 5],
                        pointRadius: 0,
                        fill: false,
                        tension: 0.3,
                    },
                ],
            };

            this.chartData = newData;
        },
        deleteBill(id) {
            Swal.fire({
                title: "¿Estás seguro?",
                text: "No podrás revertir esto.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminarlo!",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(`/api/billing/delete/${id}`)
                        .then(() => {
                            Swal.fire("Eliminado correctamente", "", "success");
                            this.fetchBills();
                        })
                        .catch(() => {
                            Swal.fire(
                                "Error",
                                "No se pudo eliminar la factura.",
                                "error"
                            );
                        });
                }
            });
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
