<template>
    <!-- HEADER -->
    <div class="container-content">
        <div class="content-title">
            <h2>Editar o eliminar productos</h2>
            <p>Editar o eliminar</p>
        </div>

        <!-- Tabla de productos editar o eliminar -->

        <div class="table-container">
            <h3 class="mb-3">
                Productos registrados:
                <strong class="text-success">1000</strong>
            </h3>
            <div class="d-flex justify-content-between align-items-end">
                <div class="filters">
                    <label for="">Filtros de busqueda</label>
                    <div class="d-flex">
                        <input
                            type="text"
                            class="form-control mr-2"
                            placeholder="Codigo del producto"
                        />
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Nombre del producto"
                        />
                    </div>
                </div>
            </div>
            <div class="content-table">
                <table class="table mt-3 table-edit-product">
                    <thead>
                        <tr>
                            <th scope="col">Nombre del producto</th>
                            <th scope="col">Codigo</th>
                            <th scope="col">En stock</th>
                            <th scope="col">Fecha de registro</th>
                            <th scope="col">Vencimiento</th>
                            <th scope="col">Peso</th>
                            <th scope="col">Proveedor</th>
                            <th scope="col">Precio de proveedor</th>
                            <th scope="col">Precio de venta</th>
                            <th scope="col">Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong> Nombre del Producto </strong></td>
                            <td>10001</td>
                            <td>
                                <div class="text-dark">
                                    <i class="fa-solid fa-box mr-1"></i>
                                    <strong>2</strong>
                                </div>
                            </td>
                            <td class="text-danger">
                                <strong>20/03/2025</strong>
                            </td>
                            <td class="text-success">
                                <strong>20/03/2025</strong>
                            </td>
                            <td><strong>1kg</strong></td>
                            <td><strong>Nombre del proveedor</strong></td>
                            <td class="text-danger"><strong>$20</strong></td>
                            <td class="text-success"><strong>$50</strong></td>
                            <td><i title="Editar" class="fa-solid fa-pen-to-square mr-2"></i> <i title="Eliminar" class="fa-solid fa-trash"></i></td>
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
/* ESTILOS INDEPENDIENTES PARA ESTE COMPONENTE */
.content-table {
    overflow-x: auto;
    width: 100%;
}
.table-edit-product {
    width: 1300px;
}
@media (max-width: 1229px) {
    .table-edit-product{
        width: 1300px !important;
    }
}
@media (max-width: 675px) {
    .inputs {
        flex-wrap: wrap;
    }
}
</style>
