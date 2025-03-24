<template>
    <!-- HEADER -->
    <div class="container-content">
        <div class="content-title">
            <h2>Agendar nuevos productos</h2>
            <p>Registrar nuevos productos</p>
        </div>

        <!-- CLIENTES Y REGISTROS DE CLIENTES -->

        <div class="data-clients">
            <div class="inputs-content">
                <div class="inputs">
                    <input
                        type="text"
                        placeholder="Codigo de barras"
                        class="form-control"
                    />
                </div>
                <div class="inputs">
                    <input
                        type="text"
                        placeholder="Nombre del producto"
                        class="form-control"
                    />
                    <input
                        type="number"
                        placeholder="Cantidad en stock"
                        class="form-control"
                    />
                    <input
                        type="text"
                        placeholder="Fecha de vencimiento"
                        class="form-control"
                    />
                    <input
                        type="number"
                        placeholder="Peso en KG"
                        class="form-control"
                    />
                </div>
                <div class="inputs">
                    <select
                        name=""
                        aria-placeholder="Tipo de entrega"
                        class="form-control"
                    >
                        <option value="" class="option-default">
                            Proveedor
                        </option>
                        <option value="Entrega a domicilio">Proveedor 1</option>
                        <option value="Retiro en tienda">Proveedor 2</option>
                    </select>
                    <input
                        type="text"
                        placeholder="Precio de proveedor"
                        class="form-control"
                    />
                    <input
                        type="text"
                        placeholder="Precio de venta"
                        class="form-control"
                    />
                    <input
                        type="text"
                        placeholder="Descripción"
                        class="form-control"
                    />
                </div>
            </div>
            <button class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> GUARDAR PRODUCTO
            </button>
        </div>

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
                            placeholder="Codigo de porducto"
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
                <table class="table mt-3 table-add-product">
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
                            <td><strong>$20</strong></td>
                            <td><strong>$50</strong></td>
                        </tr>
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
                            <td><strong>$20</strong></td>
                            <td><strong>$50</strong></td>
                        </tr>
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
                            <td><strong>$20</strong></td>
                            <td><strong>$50</strong></td>
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
.table-add-product {
    width: 1250px;
}
@media (max-width: 1229px) {
    .table-add-product {
        width: 1250px !important;
    }
}
@media (max-width: 675px) {
    .inputs {
        flex-wrap: wrap;
    }
}
</style>
