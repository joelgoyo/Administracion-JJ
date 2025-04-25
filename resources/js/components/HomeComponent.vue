<template>
    <!-- HEADER -->
    <LoadingComponent v-model="isLoading" />
    <div class="container-content">
        <div class="content-title">
            <h2>Bienvenido Administrador</h2>
            <p>{{ fechaFormateada }}</p>
        </div>

        <!-- ESTADISTICAS -->
        <div class="content-stadisticts d-flex">
            <div class="card">
                <div
                    class="d-flex justify-content-between align-items-center mb-1"
                >
                    <h3>Cantidad de clientes</h3>
                </div>
                <div
                    class="d-flex justify-content-space-between align-items-center"
                >
                    <i class="fa-solid fa-users"></i>
                    <span>{{ clients }}</span>
                </div>
            </div>
            <div class="card">
                <div
                    class="d-flex justify-content-between align-items-center mb-1"
                >
                    <h3>Ventas semanales</h3>
                </div>
                <div
                    class="d-flex justify-content-space-between align-items-center"
                >
                    <i class="fa-solid fa-chart-simple"></i>
                    <span>{{ ventasSemanales }}</span>
                </div>
            </div>
            <div class="card">
                <div
                    class="d-flex justify-content-between align-items-center mb-1"
                >
                    <h3>Ventas mensuales</h3>
                </div>
                <div
                    class="d-flex justify-content-space-between align-items-center"
                >
                    <i class="fa-solid fa-chart-simple"></i>
                    <span>{{ ventasMensuales }}</span>
                </div>
            </div>
            <div class="card">
                <div
                    class="d-flex justify-content-between align-items-center mb-1"
                >
                    <h3>Ventas anuales</h3>
                </div>
                <div
                    class="d-flex justify-content-space-between align-items-center"
                >
                    <i class="fa-solid fa-chart-simple"></i>
                    <span>{{ ventasAnuales }}</span>
                </div>
            </div>
        </div>

        <!-- LISTA DE ENTRADAS -->
        <div class="table-container">
            <h2 class="d-flex align-items-center mb-3">
                <i class="fa-solid fa-money-bills mt-1 mr-2"></i> Lista de
                entradas
            </h2>
            <div class="content-table">
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre del cliente</th>
                            <th scope="col">Identificacion</th>
                            <th scope="col">Fecha de compra</th>
                            <th scope="col">Monto ($)</th>
                            <th scope="col">Monto (Bs)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(bill, index) in bills">
                            <td scope="row">{{ index + 1 }}</td>
                            <td>{{ bill.client.name }}</td>
                            <td>{{ bill.client.dni }}</td>
                            <td>{{ formatDateWithTime(bill.created_at) }}</td>
                            <td class="text-success">
                                <strong>{{ bill.amount }}$</strong>
                            </td>
                            <td class="text-success">
                                <strong> {{ bill.amount_bs }}Bs </strong>
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
import LoadingComponent from "./LoadingComponent.vue";

export default {
    data() {
        return {
            fechaFormateada: "",
            isLoading: true,
            clients: 0,
            bills: [],
            ventasAnuales: 0,
            ventasMensuales: 0,
            ventasSemanales: 0,
        };
    },
    components: {
        LoadingComponent,
    },
    mounted() {
        this.formatearFechaHora();
        this.fechtClients();
        this.fechtBillsDate();

        setTimeout(() => {
            this.isLoading = false;
        }, 1000);

        setInterval(() => {
            this.formatearFechaHora();
        }, 1000);
    },
    methods: {
        formatDateWithTime(dateString) {
            if (!dateString) return "";
            const date = new Date(dateString);
            return date.toLocaleString();
        },
        formatearFechaHora() {
            const ahora = new Date();
            const dia = ahora.getDate().toString().padStart(2, "0");
            const mes = (ahora.getMonth() + 1).toString().padStart(2, "0");
            const anio = ahora.getFullYear();
            const horas = ahora.getHours().toString().padStart(2, "0");
            const minutos = ahora.getMinutes().toString().padStart(2, "0");
            const segundos = ahora.getSeconds().toString().padStart(2, "0");
            this.fechaFormateada = `${dia}/${mes}/${anio} ${horas}:${minutos}:${segundos}`;
        },
        fechtClients() {
            return axios
                .get("/api/clients/count")
                .then((response) => {
                    this.clients = response.data.clients;
                })
                .catch((error) => {
                    console.error("Error al obtener clientes:", error);
                    this.clients = 0;
                });
        },
        fechtBillsDate() {
            return axios
                .get("/api/billing/list")
                .then((response) => {
                    // Ordenamos por fecha descendente (más recientes primero)
                    const sortedBills = response.data.billing.sort((a, b) => {
                        return new Date(b.created_at) - new Date(a.created_at);
                    });

                    // Tomamos solo las últimas 10 facturas
                    this.bills = sortedBills.slice(0, 10);

                    this.contarVentasPorFecha();
                })
                .catch((error) => {
                    console.error("Error al obtener facturas:", error);
                    this.bills = [];
                });
        },
        contarVentasPorFecha() {
            const ahora = new Date();

            const inicioSemana = new Date(ahora);
            inicioSemana.setDate(ahora.getDate() - ahora.getDay());

            const inicioMes = new Date(
                ahora.getFullYear(),
                ahora.getMonth(),
                1
            );
            const inicioAnio = new Date(ahora.getFullYear(), 0, 1);

            this.ventasSemanales = 0;
            this.ventasMensuales = 0;
            this.ventasAnuales = 0;

            this.bills.forEach((factura) => {
                const fechaCompra = new Date(factura.created_at);
                const fechaLocal = new Date(
                    fechaCompra.getFullYear(),
                    fechaCompra.getMonth(),
                    fechaCompra.getDate()
                );

                if (fechaLocal >= inicioAnio) this.ventasAnuales++;
                if (fechaLocal >= inicioMes) this.ventasMensuales++;
                if (fechaLocal >= inicioSemana) this.ventasSemanales++;
            });
        },
    },
};
</script>

<style scoped></style>
