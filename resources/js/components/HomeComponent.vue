<template>
    <!-- HEADER -->
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
                    <i
                        title="Abrir"
                        class="fa-solid fa-up-right-from-square"
                    ></i>
                </div>
                <div
                    class="d-flex justify-content-space-between align-items-center"
                >
                    <i class="fa-solid fa-users"></i>
                    <span>100</span>
                </div>
            </div>
            <div class="card">
                <div
                    class="d-flex justify-content-between align-items-center mb-1"
                >
                    <h3>Ventas semanles</h3>
                    <i
                        title="Abrir"
                        class="fa-solid fa-up-right-from-square"
                    ></i>
                </div>
                <div
                    class="d-flex justify-content-space-between align-items-center"
                >
                    <i class="fa-solid fa-chart-simple"></i>
                    <span>100</span>
                </div>
            </div>
            <div class="card">
                <div
                    class="d-flex justify-content-between align-items-center mb-1"
                >
                    <h3>Ventas mensuales</h3>
                    <i
                        title="Abrir"
                        class="fa-solid fa-up-right-from-square"
                    ></i>
                </div>
                <div
                    class="d-flex justify-content-space-between align-items-center"
                >
                    <i class="fa-solid fa-chart-simple"></i>
                    <span>100</span>
                </div>
            </div>
            <div class="card">
                <div
                    class="d-flex justify-content-between align-items-center mb-1"
                >
                    <h3>Ventas anuales</h3>
                    <i
                        title="Abrir"
                        class="fa-solid fa-up-right-from-square"
                    ></i>
                </div>
                <div
                    class="d-flex justify-content-space-between align-items-center"
                >
                    <i class="fa-solid fa-chart-simple"></i>
                    <span>100</span>
                </div>
            </div>
        </div>

        <!-- LISTA DE ENTRADAS -->
        <div class="table-container">
            <h2 class="d-flex align-items-center mb-3">
                <i class="fa-solid fa-money-bills mt-1 mr-2"></i> Lista de
                entradas
            </h2>
            <div class="d-flex justify-content-between align-items-end">
                <div class="filters">
                    <label for="">Filtros de busqueda</label>
                    <div class="d-flex">
                        <input
                            type="text"
                            class="form-control mr-2"
                            placeholder="Nombre"
                        />
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Identificacion"
                        />
                    </div>
                </div>
                <button class="btn btn-primary" title="Exportar Excel">
                    <i class="fa-solid fa-file-excel"></i> Exportar
                </button>
            </div>
            <div class="content-table">
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre del cliente</th>
                            <th scope="col">Identificacion</th>
                            <th scope="col">Cantindad de productos</th>
                            <th scope="col">Fecha de compra</th>
                            <th scope="col">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row">1</td>
                            <td>Jose Rojas</td>
                            <td>29899708</td>
                            <td>
                                <div class="text-dark">
                                    <i class="fa-solid fa-box mr-1"></i>
                                    <strong>2</strong>
                                </div>
                            </td>
                            <td>15/03/2023</td>
                            <td class="text-success"><strong>$200</strong></td>
                        </tr>
                        <tr>
                            <td scope="row">1</td>
                            <td>Jose Rojas</td>
                            <td>29899708</td>
                            <td>
                                <div class="text-dark">
                                    <i class="fa-solid fa-box mr-1"></i>
                                    <strong>2</strong>
                                </div>
                            </td>
                            <td>15/03/2023</td>
                            <td class="text-success"><strong>$200</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import LoadingComponent from "./LoadingComponent.vue";

export default {
    data() {
        return {
            fechaFormateada: "",
            isLoading: true,
            data: null,
        };
    },
    components: {
        LoadingComponent,
    },

    mounted() {
        this.formatearFechaHora();
        setInterval(() => {
            this.formatearFechaHora();
        }, 1000);
    },
    methods: {
        formatearFechaHora() {
            const ahora = new Date();
            const dia = ahora.getDate().toString().padStart(2, "0");
            const mes = (ahora.getMonth() + 1).toString().padStart(2, "0"); // Los meses comienzan desde 0
            const anio = ahora.getFullYear();
            const horas = ahora.getHours().toString().padStart(2, "0");
            const minutos = ahora.getMinutes().toString().padStart(2, "0");
            const segundos = ahora.getSeconds().toString().padStart(2, "0");
            this.fechaFormateada = `${dia}/${mes}/${anio} ${horas}:${minutos}:${segundos}`;
        },
    },
};
</script>

<style>
.bg-success {
    width: fit-content;
    padding: 6px 12px;
    border-radius: 8px;
}
</style>
