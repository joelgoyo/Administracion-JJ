<template>
    <!-- HEADER -->
    <div class="container-content">
        <div class="content-title">
            <h2>Agregar nuevo Proveedor</h2>
            <p>Registrar nuevo Proveedor</p>
        </div>

        <!-- CLIENTES Y REGISTROS DE CLIENTES -->

        <div class="data-clients">
            <div class="inputs-content">
                <form action="" @submit.prevent="handleSubmit">
                    <div class="inputs">
                        <div class="input">
                            <input
                                type="text"
                                placeholder="Nombre de la empresa"
                                class="form-control"
                                v-model="suppliers.name"
                            />
                            <p v-if="errors.name" class="text-danger">
                                {{ errors.name }}
                            </p>
                        </div>
                        <div class="input">
                            <input
                                type="number"
                                placeholder="RIF"
                                class="form-control"
                                v-model="suppliers.dni"
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
                                v-model="suppliers.email"
                            />
                            <p v-if="errors.email" class="text-danger">
                                {{ errors.email }}
                            </p>
                        </div>
                        <div class="input">
                            <input
                                type="number"
                                placeholder="Numero de telefono"
                                class="form-control"
                                v-model="suppliers.phone"
                            />
                            <p v-if="errors.phone" class="text-danger">
                                {{ errors.phone }}
                            </p>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> GUARDAR NUEVO
                        PROVEEDOR
                    </button>
                </form>
            </div>
        </div>

        <div class="table-container">
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
                            <th scope="col">Nombre de empresa</th>
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
            </div>
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
                        type="number"
                        v-model="editModal.client.dni"
                        placeholder="RIF/C.I"
                        class="form-control mb-2"
                    />
                    <input
                        type="text"
                        v-model="editModal.client.name"
                        placeholder="Nombre"
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
    dni: yup.string().required("RIF/C.I es requerido."),
    phone: yup.string().required("Número de teléfono es requerido."),
});
export default {
    data() {
        return {
            isLoading: true,
            data: null,
            suppliers: {
                name: "",
                dni: "",
                email: "",
                phone: "",
            },
            suppliersList: [],
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
        this.fetchClients();
    },
    computed: {
        filteredClients() {
            const filtered = this.suppliersList.filter((supplier) => {
                const dniMatch =
                    !this.filters.dni ||
                    supplier.dni.toString().includes(this.filters.dni);
                const nameMatch =
                    !this.filters.name ||
                    supplier.name
                        .toLowerCase()
                        .includes(this.filters.name.toLowerCase()); // Asegúrate de que solo comparas el nombre de la empresa.
                const emailMatch =
                    !this.filters.email ||
                    supplier.email
                        .toLowerCase()
                        .includes(this.filters.email.toLowerCase());
                return dniMatch && nameMatch && emailMatch;
            });
            return filtered.slice();
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
            axios.put(`/api/suppliers/update/${this.editModal.client.id}`, this.editModal.client).then(() => {
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
                        .delete(`/api/suppliers/delete/${id}`)
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
            axios
                .get(`/api/suppliers/list`)
                .then((response) => {
                    this.suppliersList = response.data.suppliers;
                })
                .catch((error) => {
                    console.log(error);
                });
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
                await validationSchema.validate(this.suppliers, {
                    abortEarly: false,
                });
                this.errors = {}; // Limpiar errores

                // Verificar si el correo electrónico ya existe
                const emailResponse = await axios.get(`/api/suppliers/check-email/${this.suppliers.email}`);
                if (emailResponse.data.exists) {
                    this.errors.email = "Este correo electrónico ya está registrado.";
                    return; // Detener el registro si el correo ya existe
                }

                // Verificar si el DNI ya existe
                const NameResponse = await axios.get(`/api/suppliers/check-name/${this.suppliers.name}`);
                if (NameResponse.data.exists) {
                    this.errors.name = "Este nombre ya esta registrado.";
                    return; // Detener el registro si el DNI ya existe
                }
                // Si el correo y el DNI no existen, proceder con el registro
                axios
                    .post("/api/suppliers/save", this.suppliers)
                    .then(() => {
                        Swal.fire({
                            title: "Exitoso",
                            text: "Cliente registrado correctamente",
                            icon: "success",
                            confirmButtonText: "Aceptar",
                        });
                        this.fetchClients();
                        this.suppliers = {
                            name: "",
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
