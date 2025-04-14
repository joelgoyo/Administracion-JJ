<template>
    <div class="container-content">
        <div class="content-title">
            <h2>Todos los usuarios</h2>
            <p>usuarios</p>
        </div>

        <!-- FILTROS Y TABLA DE FACTURAS -->
        <div class="table-container">
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
                            placeholder="Correo electrónico"
                            v-model="filters.email"
                        />
                    </div>
                </div>
            </div>

            <div class="content-table">
                <table class="table mt-3 table-add-bill">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre y apellido</th>
                            <th>Rif/C.I</th>
                            <th>Email</th>
                            <th>Telefono</th>
                            <th>Fecha de registro</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(client, index) in clients" :key="index">
                            <td>
                                <strong>{{ index + 1 }}</strong>
                            </td>
                            <td>
                                <strong
                                    >{{ client.name }}
                                    {{ client.last_name }}</strong
                                >
                            </td>
                            <td>
                                <strong>{{ client.dni }}</strong>
                            </td>
                            <td>
                                <strong>{{ client.email }}</strong>
                            </td>
                            <td>
                                <strong>{{ client.phone }}</strong>
                            </td>
                            <td>
                                <strong>{{
                                    formatDateWithTime(client.created_at)
                                }}</strong>
                            </td>
                            <td>
                                <a :href="`user-view/${client.id}`">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";

export default {
    data() {
        return {
            filterByWeek: null,
            clients: [],
            allBills: [],
            selectedWeek: "all",
            filters: {
                dni: "",
                name: "",
                email: "",
            },
        };
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
                .get("/api/clients/list")
                .then((response) => {
                    this.clients = response.data.clients.reverse();
                    console.log(this.clients);
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
.fa-eye {
  cursor: pointer;
  transition: all 200ms;
  color: #7f7f7f;
}
.fa-eye:hover {
    color: #1958f7;
}
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
