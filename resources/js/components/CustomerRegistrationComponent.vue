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
                <form action="" @submit.prevent="handleSubmit">
                    <div class="inputs">
                        <input
                            type="text"
                            placeholder="Nombre"
                            class="form-control"
                            v-model="clients.name"
                        />
                        <input
                            type="text"
                            placeholder="Apellido"
                            class="form-control"
                            v-model="clients.last_name"
                        />
                        <input
                            type="text"
                            placeholder="Dirección"
                            class="form-control"
                            v-model="clients.address"
                        />
                        <input
                            type="number"
                            placeholder="RIF/C.I"
                            class="form-control"
                            v-model="clients.dni"
                        />
                    </div>
                    <div class="inputs">
                        <input
                            type="text"
                            placeholder="Correo electronico"
                            class="form-control"
                            v-model="clients.email"
                        />
                        <input
                            type="text"
                            placeholder="Numero de telefono"
                            class="form-control"
                            v-model="clients.phone"
                        />
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> GUARDAR NUEVO
                        CLIENTE
                    </button>
                </form>
            </div>
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
                            v-model="filters.dni"
                        />
                        <input
                            type="text"
                            class="form-control mr-2"
                            placeholder="Nombre y apellido"
                            v-model="filters.name"
                        />
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Correo electronico"
                            v-model="filters.email"
                        />
                    </div>
                </div>
            </div>
            <div class="content-table">
                <table class="table mt-3 table-add-product">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre y apellido</th>
                            <th scope="col">Direccion</th>
                            <th scope="col">RIF/C.I</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Numero de telefono</th>
                            <th scope="col">Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(client, index) in filteredClients"
                            :key="index.id"
                        >
                            <td>
                                <strong> {{ index + 1 }} </strong>
                            </td>
                            <td>
                                <strong
                                    >{{ client.name }}
                                    {{ client.last_name }}</strong
                                >
                            </td>
                            <td>
                                <div class="text-dark">
                                    <strong>{{ client.address }}</strong>
                                </div>
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
                                <i
                                    title="Editar"
                                    class="fa-solid fa-pen-to-square mr-2"
                                ></i>
                                <i
                                    title="Eliminar"
                                    class="fa-solid fa-trash"
                                    @click="deleteClient(client.id)"
                                ></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import LoadingComponent from "./LoadingComponent.vue";
import axios from "axios";
import Swal from "sweetalert2";
export default {
    data() {
        return {
            fechaFormateada: "",
            isLoading: true,
            data: null,
            clients: {
                name: "",
                last_name: "",
                address: "",
                dni: "",
                email: "",
                phone: "",
            },
            clientList: [],
            filters: {
                dni: "",
                name: "",
                email: "",
            },
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

        this.fetchClients();
    },
    computed: {
        filteredClients() {
            return this.clientList.filter((client) => {
                const dniMatch =
                    !this.filters.dni ||
                    client.dni.toString().includes(this.filters.dni);
                const nameMatch =
                    !this.filters.name ||
                    `${client.name} ${client.last_name}`
                        .toLowerCase()
                        .includes(this.filters.name.toLowerCase());
                const emailMatch =
                    !this.filters.email ||
                    client.email
                        .toLowerCase()
                        .includes(this.filters.email.toLowerCase());
                return dniMatch && nameMatch && emailMatch;
            });
        },
    },
    methods: {
        deleteClient(id) {
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
              .delete(`/api/clients/delete/${id}`)
              .then((response) => {
                Swal.fire({
                  title: "Eliminado correctamente",
                  icon: "success",
                  draggable: true,
                });
                this.fetchClients();
              })
              .catch((error) => {
                console.log(error);
                Swal.fire({
                  title: "Error",
                  text: "No se pudo eliminar el usuario.",
                  icon: "error",
                });
              });
          }
        });
      },
        fetchClients() {
            axios.get("/api/clients/list").then((response) => {
                this.clientList = response.data.clients.reverse();
            });
        },
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

        handleSubmit() {
            axios
                .post("/api/clients/save", this.clients)
                .then(() => {
                    Swal.fire({
                        title: "Exitoso",
                        text: "Cliente registrado correctamente",
                        icon: "success",
                        confirmButtonText: "Aceptar",
                    });
                    this.fetchClients(); // Recargar la lista de clientes
                    this.clients = {
                        name: "",
                        last_name: "",
                        address: "",
                        dni: "",
                        email: "",
                        phone: "",
                    }; // Limpiar el formulario
                })
                .catch(() => {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "No se ha podido registrar el usuario",
                    });
                });
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
