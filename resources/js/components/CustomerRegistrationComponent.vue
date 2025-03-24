<template>
    <!-- HEADER -->
    <div class="container-content">
        <div class="content-title">
            <h2>Agregar nuevo cliente</h2>
            <p>Registrar nuevo cliente</p>
        </div>

        <!-- CLIENTES Y REGISTROS DE CLIENTES -->

        <div class="data-clients">
            <div class="inputs-content">
                <div class="inputs">
                    <input
                        type="text"
                        placeholder="Nombre"
                        class="form-control"
                    />
                    <input
                        type="number"
                        placeholder="Apellido"
                        class="form-control"
                    />
                    <input
                        type="text"
                        placeholder="Dirección"
                        class="form-control"
                    />
                    <input
                        type="number"
                        placeholder="RIF/C.I"
                        class="form-control"
                    />
                </div>
                <div class="inputs">
                    <input
                        type="text"
                        placeholder="Correo electronico"
                        class="form-control"
                    />
                    <input
                        type="text"
                        placeholder="Numero de telefono"
                        class="form-control"
                    />
                </div>
            </div>
            <button class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> GUARDAR NUEVO CLIENTE
            </button>
        </div>

        <div class="table-container">
            <div class="d-flex justify-content-between align-items-end">
                <div class="filters">
                    <label for="">Filtros de busqueda</label>
                    <div class="d-flex">
                        <input
                            type="text"
                            class="form-control mr-2"
                            placeholder="RIF/C.I"
                        />
                        <input
                            type="text"
                            class="form-control mr-2"
                            placeholder="Nombre y apellido"
                        />
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Correo electronico"
                        />
                    </div>
                </div>
            </div>
            <div class="content-table">
                <table class="table mt-3 table-add-product">
                    <thead>
                        <tr>
                            <th scope="col">Nombre y apellido</th>
                            <th scope="col">Direccion</th>
                            <th scope="col">RIF/C.I</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Numero de telefono</th>
                            <th scope="col">Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong> Joseph Leal </strong></td>
                            <td><strong>Palo negro, piso 2</strong></td>
                            <td>
                                <div class="text-dark">
                                    <strong>29899708</strong>
                                </div>
                            </td>
                            <td>
                                <strong>info.josephleal@gmail.com</strong>
                            </td>
                            <td><strong>04128991690</strong></td>
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
