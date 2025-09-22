<template>
    <div class="container-content">
        <div class="content-title">
            <h2>Agregar nuevo Proveedor</h2>
            <p>Registrar nuevo Proveedor</p>
        </div>

        <div class="data-clients">
            <div class="inputs-content">
                <form action="" @submit.prevent="handleSubmit">
                    <div class="inputs">
                        <div class="input">
                            <input
                                type="text"
                                placeholder="Nombre de la empresa"
                                class="form-control"
                                v-model="supplier.name"
                            />
                            <p v-if="errors.name" class="text-danger">
                                {{ errors.name }}
                            </p>
                        </div>
                        <div class="input">
                            <input
                                type="text"
                                placeholder="RIF"
                                class="form-control"
                                v-model="supplier.dni"
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
                                placeholder="Correo electrónico"
                                class="form-control"
                                v-model="supplier.email"
                            />
                            <p v-if="errors.email" class="text-danger">
                                {{ errors.email }}
                            </p>
                        </div>
                        <div class="input">
                            <input
                                type="text"
                                placeholder="Número de teléfono"
                                class="form-control"
                                v-model="supplier.phone"
                            />
                            <p v-if="errors.phone" class="text-danger">
                                {{ errors.phone }}
                            </p>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> GUARDAR NUEVO PROVEEDOR
                    </button>
                </form>
            </div>
        </div>

        <div class="table-container" v-if="!isLoading">
            <div class="d-flex justify-content-between align-items-end">
                <div class="filters">
                    <label for="">Filtros de búsqueda</label>
                    <div class="inputs">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="RIF"
                            v-model="filters.dni"
                        />
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Nombre de empresa"
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
                <table class="table mt-3 table-add-product">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre de empresa</th>
                            <th scope="col">RIF</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Número de teléfono</th>
                            <th scope="col">Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(supplier, index) in paginatedSuppliers"
                            :key="supplier.id"
                        >
                            <td>
                                <strong>{{ (currentPage - 1) * pageSize + index + 1 }}</strong>
                            </td>
                            <td>
                                <strong>{{ supplier.name }}</strong>
                            </td>
                            <td>
                                <strong>{{ supplier.dni }}</strong>
                            </td>
                            <td>
                                <strong>{{ supplier.email }}</strong>
                            </td>
                            <td>
                                <strong>{{ supplier.phone }}</strong>
                            </td>
                            <td>
                                <i
                                    title="Editar"
                                    class="fa-solid fa-pen-to-square mr-2"
                                    @click="openEditModal(supplier)"
                                ></i>
                                <i
                                    title="Eliminar"
                                    class="fa-solid fa-trash"
                                    @click="deleteSupplier(supplier.id)"
                                ></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="mr-2">Página {{ currentPage }} de {{ totalPages }}</span>
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
        <div v-else>
            <p>Cargando datos...</p>
        </div>

        <div v-if="editModal.show" class="modal-x">
            <div class="modal-y">
                <div class="content-title">
                    <h2>Editar datos del proveedor</h2>
                    <p>Editar</p>
                </div>

                <form action="" @submit.prevent="updateSupplier">
                    <div class="inputs">
                        <input
                            type="text"
                            v-model="editModal.supplier.name"
                            placeholder="Nombre de empresa"
                            class="form-control mb-2"
                        />
                        <input
                            type="text"
                            v-model="editModal.supplier.dni"
                            placeholder="RIF"
                            class="form-control mb-2"
                        />
                    </div>
                    <div class="inputs">
                        <input
                            type="text"
                            v-model="editModal.supplier.email"
                            placeholder="Correo electrónico"
                            class="form-control mb-2"
                        />
                        <input
                            type="text"
                            v-model="editModal.supplier.phone"
                            placeholder="Número de teléfono"
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
    </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
import * as yup from "yup";

const validationSchema = yup.object({
    name: yup.string().required("El nombre de la empresa es requerido."),
    dni: yup.string().required("El RIF es requerido."),
    email: yup
        .string()
        .email("Correo electrónico no válido.")
        .required("El correo electrónico es requerido."),
    phone: yup.string().required("El número de teléfono es requerido."),
});

export default {
    data() {
        return {
            currentPage: 1,
            pageSize: 10,
            isLoading: false,
            supplier: {
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
            editModal: { show: false, supplier: {} },
            errors: {},
        };
    },
    mounted() {
        this.fetchSuppliers();
    },
    computed: {
        filteredSuppliers() {
            return this.suppliersList.filter((supplier) => {
                const dniMatch = supplier.dni
                    ?.toString()
                    .toLowerCase()
                    .includes(this.filters.dni.toLowerCase());
                const nameMatch = supplier.name
                    ?.toLowerCase()
                    .includes(this.filters.name.toLowerCase());
                const emailMatch = supplier.email
                    ?.toLowerCase()
                    .includes(this.filters.email.toLowerCase());
                return dniMatch && nameMatch && emailMatch;
            });
        },
        paginatedSuppliers() {
            const start = (this.currentPage - 1) * this.pageSize;
            const end = start + this.pageSize;
            return this.filteredSuppliers.slice(start, end);
        },
        totalPages() {
            return Math.ceil(this.filteredSuppliers.length / this.pageSize);
        },
    },
    watch: {
        filters: {
            deep: true,
            handler() {
                this.currentPage = 1;
            },
        },
        currentPage() {
            if (this.currentPage < 1) this.currentPage = 1;
            if (this.currentPage > this.totalPages) this.currentPage = this.totalPages;
        },
    },
    methods: {
        async fetchSuppliers() {
            this.isLoading = true;
            try {
                const response = await axios.get("/api/suppliers/list");
                this.suppliersList = response.data.suppliers;
            } catch (error) {
                console.error("Error fetching suppliers:", error);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No se pudieron cargar los proveedores.",
                });
            } finally {
                this.isLoading = false;
            }
        },
        openEditModal(supplier) {
            this.editModal.supplier = { ...supplier };
            this.editModal.show = true;
        },
        closeEditModal() {
            this.editModal.show = false;
        },
        async updateSupplier() {
            try {
                await axios.put(
                    `/api/suppliers/update/${this.editModal.supplier.id}`,
                    this.editModal.supplier
                );
                Swal.fire("Proveedor actualizado correctamente", "", "success");
                this.closeEditModal();
                await this.fetchSuppliers();
            } catch (error) {
                Swal.fire(
                    "Error al actualizar el proveedor, estos datos ya están en uso",
                    "",
                    "error"
                );
            }
        },
        deleteSupplier(id) {
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
                        .then(() => {
                            Swal.fire({
                                title: "Eliminado correctamente",
                                icon: "success",
                                draggable: true,
                            });
                            this.fetchSuppliers();
                        })
                        .catch((error) => {
                            console.error(error);
                            Swal.fire({
                                title: "Error",
                                text: "No se pudo eliminar el proveedor.",
                                icon: "error",
                            });
                        });
                }
            });
        },
        async handleSubmit() {
            try {
                await validationSchema.validate(this.supplier, {
                    abortEarly: false,
                });
                this.errors = {};

                const emailResponse = await axios.get(
                    `/api/suppliers/check-email/${this.supplier.email}`
                );
                if (emailResponse.data.exists) {
                    this.errors.email = "Este correo electrónico ya está registrado.";
                    return;
                }

                const nameResponse = await axios.get(
                    `/api/suppliers/check-name/${this.supplier.name}`
                );
                if (nameResponse.data.exists) {
                    this.errors.name = "Este nombre ya está registrado.";
                    return;
                }

                await axios.post("/api/suppliers/save", this.supplier);
                Swal.fire({
                    title: "Exitoso",
                    text: "Proveedor registrado correctamente",
                    icon: "success",
                    confirmButtonText: "Aceptar",
                });
                this.supplier = {
                    name: "",
                    dni: "",
                    email: "",
                    phone: "",
                };
                await this.fetchSuppliers();
            } catch (err) {
                this.errors = {};
                if (err.inner) {
                    err.inner.forEach((error) => {
                        this.errors[error.path] = error.message;
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "No se ha podido registrar el proveedor",
                    });
                }
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