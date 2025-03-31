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
                        <div class="input">
                            <input
                                type="text"
                                placeholder="Nombre"
                                class="form-control"
                                v-model="clients.name"
                            />
                            <p v-if="errors.name" class="text-danger">
                                {{ errors.name }}
                            </p>
                        </div>
                        <div class="input">
                            <input
                                type="text"
                                placeholder="Apellido"
                                class="form-control"
                                v-model="clients.last_name"
                            />
                            <p v-if="errors.last_name" class="text-danger">
                                {{ errors.last_name }}
                            </p>
                        </div>

                        <div class="input">
                            <input
                                type="text"
                                placeholder="Dirección"
                                class="form-control"
                                v-model="clients.address"
                            />
                            <p v-if="errors.address" class="text-danger">
                                {{ errors.address }}
                            </p>
                        </div>
                        <div class="input">
                            <input
                                type="number"
                                placeholder="RIF/C.I"
                                class="form-control"
                                v-model="clients.dni"
                            />
                            <p v-if="errors.dni" class="text-danger">
                                {{ errors.dni }}
                            </p>
                        </div>
                    </div>
                    <div class="inputs">
                        <div class="input">
                            <input
                                type="text"
                                placeholder="Correo electronico"
                                class="form-control"
                                v-model="clients.email"
                            />
                            <p v-if="errors.email" class="text-danger">
                                {{ errors.email }}
                            </p>
                        </div>
                        <div class="input">
                            <input
                                type="text"
                                placeholder="Numero de telefono"
                                class="form-control"
                                v-model="clients.phone"
                            />
                            <p v-if="errors.phone" class="text-danger">
                                {{ errors.phone }}
                            </p>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> GUARDAR NUEVO
                        CLIENTE
                    </button>
                </form>
            </div>
        </div>

        <div class="table-container" v-if="!isLoading">
            <div class="d-flex justify-content-between align-items-end">
                <div class="filters">
                    <label for="">Filtros de busqueda</label>
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
                                    @click="openEditModal(client)"
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
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li
                            class="page-item"
                            :class="{ disabled: currentPage === 1 }"
                        >
                            <a
                                class="page-link"
                                href="#"
                                @click.prevent="changePage(currentPage - 1)"
                                ><i class="fa-solid fa-angles-left"></i
                            ></a>
                        </li>
                        <li
                            class="page-item"
                            :class="{ disabled: currentPage === totalPages }"
                        >
                            <a
                                class="page-link"
                                href="#"
                                @click.prevent="changePage(currentPage + 1)"
                                ><i class="fa-solid fa-angles-right"></i
                            ></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div v-else>
            <p>Cargando datos...</p>
        </div>
    </div>

    <div v-if="editModal.show" class="modal-x">
        <div class="modal-y">
            <div class="content-title">
                <h2>Editar datos del cliente</h2>
                <p>Editar</p>
            </div>

            <form action="" @submit.prevent="updateClient">
                <div class="inputs">
                    <input
                        type="text"
                        v-model="editModal.client.name"
                        placeholder="Nombre"
                        class="form-control mb-2"
                    />
                    <input
                        type="text"
                        v-model="editModal.client.last_name"
                        placeholder="Apellido"
                        class="form-control mb-2"
                    />
                </div>
                <div class="inputs">
                    <input
                        type="text"
                        v-model="editModal.client.address"
                        placeholder="Dirección"
                        class="form-control mb-2"
                    />
                    <input
                        type="number"
                        v-model="editModal.client.dni"
                        placeholder="RIF/C.I"
                        class="form-control mb-2"
                    />
                </div>
                <div class="inputs">
                    <input
                        type="text"
                        v-model="editModal.client.email"
                        placeholder="Correo electronico"
                        class="form-control mb-2"
                    />
                    <input
                        type="text"
                        v-model="editModal.client.phone"
                        placeholder="Numero de telefono"
                        class="form-control mb-2"
                    />
                </div>
                <button type="submit" class="btn btn-primary mr-2">
                    Actualizar
                </button>
                <button
                    type="button"
                    class="btn btn-danger"
                    @click="closeEditModal"
                >
                    Cancelar
                </button>
            </form>
        </div>
    </div>
</template>
<script>
import LoadingComponent from "./LoadingComponent.vue";
import axios from "axios";
import Swal from "sweetalert2";
import * as yup from "yup";

const validationSchema = yup.object({
    name: yup.string().required("Nombre es requerido."),
    last_name: yup.string().required("Apellido es requerido."),
    address: yup.string().required("Dirección es requerida."),
    dni: yup.string().required("RIF/C.I es requerido."),
    email: yup
        .string()
        .email("Correo electrónico no válido.")
        .required("Correo electrónico es requerido."),
    phone: yup.string().required("Número de teléfono es requerido."),
});
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
            editModal: { show: false, client: {} },
            form: {
                name: "",
                email: "",
                password: "",
            },
            errors: {},
            currentPage: 1,
            perPage: 10,
            totalClients: 0,
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

        setTimeout(() => {
            this.fetchClients();
        }, 2000);
    },
    computed: {
        filteredClients() {
            const filtered = this.clientList.filter((client) => {
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

            const startIndex = (this.currentPage - 1) * this.perPage;
            const endIndex = startIndex + this.perPage;
            return filtered.slice(startIndex, endIndex);
        },
        totalPages() {
            return Math.ceil(this.totalClients / this.perPage);
        },
    },
    watch: {
        currentPage(newVal, oldVal) {
            if (newVal !== oldVal) {
                this.fetchClients();
            }
        },
    },
    methods: {
        openEditModal(client) {
            this.editModal.client = { ...client };
            this.editModal.show = true;
        },
        closeEditModal() {
            this.editModal.show = false;
        },
        updateClient() {
            axios
                .put(
                    `/api/clients/update/${this.editModal.client.id}`,
                    this.editModal.client
                )
                .then(() => {
                    Swal.fire(
                        "Cliente actualizado correctamente",
                        "",
                        "success"
                    );
                    this.closeEditModal();
                    this.fetchClients();
                })
                .catch(() => {
                    Swal.fire(
                        "Error al actualizar el cliente ya estos datos estan en uso",
                        "",
                        "error"
                    );
                });
        },

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

        async fetchClients() {
            this.isLoading = true;
            try {
                const response = await axios.post(
                    `/api/clients/list-table?page=${this.currentPage}&perPage=${this.perPage}`
                );
                this.clientList = response.data.clients.data;
                this.totalClients = response.data.clients.total;
            } catch (error) {
                console.error("Error fetching clients:", error);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No se pudieron cargar los clientes.",
                });
            } finally {
                this.isLoading = false;
            }
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
        async changePage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
                await this.fetchClients();
            }
        },

        pages() {
            const pages = [];
            for (let i = 1; i <= this.totalPages; i++) {
                pages.push(i);
            }
            return pages;
        },
        async handleSubmit() {
            try {
                await validationSchema.validate(this.clients, {
                    abortEarly: false,
                });
                this.errors = {}; // Limpiar errores

                // Verificar si el correo electrónico ya existe
                const emailResponse = await axios.get(
                    `/api/clients/check-email/${this.clients.email}`
                );
                if (emailResponse.data.exists) {
                    this.errors.email =
                        "Este correo electrónico ya está registrado.";
                    return; // Detener el registro si el correo ya existe
                }

                // Verificar si el DNI ya existe
                const dniResponse = await axios.get(
                    `/api/clients/check-dni/${this.clients.dni}`
                );
                if (dniResponse.data.exists) {
                    this.errors.dni = "Este RIF/C.I ya está registrado.";
                    return; // Detener el registro si el DNI ya existe
                }

                // Si el correo y el DNI no existen, proceder con el registro
                axios
                    .post("/api/clients/save", this.clients)
                    .then(() => {
                        Swal.fire({
                            title: "Exitoso",
                            text: "Cliente registrado correctamente",
                            icon: "success",
                            confirmButtonText: "Aceptar",
                        });
                        this.fetchClients();
                        this.clients = {
                            name: "",
                            last_name: "",
                            address: "",
                            dni: "",
                            email: "",
                            phone: "",
                        };
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "No se ha podido registrar el usuario",
                        });
                    });
            } catch (err) {
                this.errors = {};
                err.inner.forEach((error) => {
                    this.errors[error.path] = error.message;
                });
            }
        },
    },
};
</script>
<style>
.modal-x {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    transition: all 0.3s ease;
}
.modal-y {
    background: white;
    padding: 20px;
    border-radius: 5px;
    width: 50%;
    border-radius: 20px;
    transition: all 0.3s ease;
}

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
    .modal-y {
        width: 80%;
    }
}
</style>
