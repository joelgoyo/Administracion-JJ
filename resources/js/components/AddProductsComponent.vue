<template>
    <div class="container-content">
        <div class="content-title">
            <h2>Inventario</h2>
            <p>Registrar nuevos productos</p>
        </div>

        <div class="data-clients">
            <form action="" @submit.prevent="handleSubmit">
                <div class="inputs-content">
                    <div class="inputs">
                        <div class="input">
                            <input
                                type="number"
                                placeholder="Codigo de barras"
                                class="form-control"
                                v-model="form.code"
                            />
                            <p v-if="errors.code" class="text-danger">
                                {{ errors.code }}
                            </p>
                        </div>
                    </div>
                    <div class="inputs">
                        <div class="input">
                            <input
                                type="text"
                                placeholder="Nombre del producto"
                                class="form-control"
                                v-model="form.name"
                            />
                            <p v-if="errors.name" class="text-danger">
                                {{ errors.name }}
                            </p>
                        </div>
                        <div class="input">
                            <input
                                type="number"
                                placeholder="Cantidad en stock"
                                class="form-control"
                                v-model="form.stock"
                            />
                            <p v-if="errors.stock" class="text-danger">
                                {{ errors.stock }}
                            </p>
                        </div>
                        <div class="input">
                            <input
                                type="date"
                                placeholder="Fecha de vencimiento"
                                class="form-control"
                                v-model="form.expiration"
                            />
                            <p v-if="errors.expiration" class="text-danger">
                                {{ errors.expiration }}
                            </p>
                        </div>
                        <div class="input">
                            <input
                                type="number"
                                placeholder="Peso en KG"
                                class="form-control"
                                v-model="form.weight"
                            />
                            <p v-if="errors.weight" class="text-danger">
                                {{ errors.weight }}
                            </p>
                        </div>
                    </div>
                    <div class="inputs">
                        <div class="input">
                            <select
                                name=""
                                aria-placeholder="Proveedor"
                                class="form-control"
                                v-model="form.supplier_id"
                            >
                                <option value="" class="option-default">
                                    Proveedor
                                </option>
                                <option
                                    v-for="supplier in suppliers"
                                    :key="supplier.id"
                                    :value="supplier.id"
                                >
                                    {{ supplier.name }}
                                </option>
                            </select>
                            <p v-if="errors.supplier_id" class="text-danger">
                                {{ errors.supplier_id }}
                            </p>
                        </div>
                        <div class="input">
                            <input
                                type="number"
                                placeholder="Precio de proveedor"
                                class="form-control"
                                v-model="form.provider_price"
                            />
                            <p v-if="errors.provider_price" class="text-danger">
                                {{ errors.provider_price }}
                            </p>
                        </div>
                        <div class="input">
                            <input
                                type="number"
                                placeholder="Precio de venta"
                                class="form-control"
                                v-model="form.price"
                            />
                            <p v-if="errors.price" class="text-danger">
                                {{ errors.price }}
                            </p>
                        </div>
                        <div class="input">
                            <input
                                type="text"
                                placeholder="Descripción"
                                class="form-control"
                                v-model="form.description"
                            />
                            <p v-if="errors.description" class="text-danger">
                                {{ errors.description }}
                            </p>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk" type="submit"></i>
                    GUARDAR PRODUCTO
                </button>
            </form>
        </div>

        <div class="table-container">
            <h3 class="mb-3">
                Productos registrados:
                <strong class="text-success">{{
                    countProducts.products
                }}</strong>
            </h3>
            <div class="d-flex justify-content-between align-items-end">
                <div class="filters">
                    <label for="">Filtros de busqueda</label>
                    <div class="d-flex">
                        <input
                            type="text"
                            class="form-control mr-2"
                            placeholder="Codigo de porducto"
                            v-model="filters.code"
                        />
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Nombre del producto"
                            v-model="filters.name"
                        />
                    </div>
                </div>
            </div>
            <div class="content-table">
                <table class="table mt-3 table-invetory-product">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre del producto</th>
                            <th scope="col">Codigo</th>
                            <th scope="col">En stock</th>
                            <th scope="col">Descripcion</th>
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
                        <tr
                            v-for="(product, index) in paginatedProducts"
                            :key="product.id"
                        >
                            <th scope="row">{{ index + 1 }}</th>
                            <td>
                                <strong>{{ product.name }}</strong>
                            </td>
                            <td>
                                <strong>{{ product.code }} </strong>
                            </td>
                            <td>
                                <div class="text-dark">
                                    <i class="fa-solid fa-box mr-1"></i>
                                    <strong>{{ product.stock }}</strong>
                                </div>
                            </td>
                            <td>{{ product.description }}</td>
                            <td class="text-success">
                                <strong>{{
                                    formatDate(product.created_at)
                                }}</strong>
                            </td>
                            <td class="text-danger">
                                <strong>{{ product.expirationDate }}</strong>
                            </td>
                            <td>
                                <strong>{{ product.weight }}kg</strong>
                            </td>
                            <td>
                                <strong>{{ product.supplier_id }}</strong>
                            </td>
                            <td>
                                <strong>{{ product.priceSupplier }}$</strong>
                            </td>
                            <td>
                                <strong>{{ product.priceUnit }}$</strong>
                            </td>

                            <td>
                                <i
                                    title="Editar"
                                    class="fa-solid fa-pen-to-square mr-2"
                                    @click="openEditModal(product)"
                                ></i>
                                <i
                                    title="Eliminar"
                                    class="fa-solid fa-trash"
                                    @click="deleteProduct(product.id)"
                                ></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="mr-2"
                    >Página {{ currentPage }} de {{ totalPages }}</span
                >
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
    </div>

    <div v-if="editModal.show" class="modal-x">
        <div class="modal-y">
            <div class="content-title">
                <h2>Editar datos del cliente</h2>
                <p>Editar</p>
            </div>

            <form action="" @submit.prevent="updateProduct">
                <div class="inputs">
                    <div class="w-100">
                        <label for="">Codigo de barras</label>
                        <input
                            type="number"
                            v-model="editModal.products.code"
                            placeholder="Codigo de barras"
                            class="form-control mb-2"
                        />
                    </div>
                </div>
                <div class="inputs">
                    <div class="w-100">
                        <label for="">Nombre del producto</label>
                        <input
                            type="text"
                            v-model="editModal.products.name"
                            placeholder="Nombre"
                            class="form-control mb-2"
                        />
                    </div>
                    <div class="w-100">
                        <label for="">Productos en stock</label>
                        <input
                            type="number"
                            v-model="editModal.products.stock"
                            placeholder="Cantidad en stock"
                            class="form-control mb-2"
                        />
                    </div>
                </div>

                <div class="inputs">
                    <div class="w-100">
                        <label for=""> Fecha de expiracion </label>
                        <input
                            type="date"
                            v-model="editModal.products.expirationDate"
                            placeholder="Fecha de vencimiento"
                            class="form-control mb-2"
                        />
                    </div>
                    <div class="w-100">
                        <label for="">Peso del producto en KG</label>
                        <input
                            type="number"
                            v-model="editModal.products.weight"
                            placeholder="Cantidad en stock"
                            class="form-control mb-2"
                        />
                    </div>
                </div>
                <div class="inputs">
                    <div class="w-100">
                        <label for="">Proveedores</label>
                        <select
                            name=""
                            aria-placeholder="Proveedor"
                            class="form-control"
                            v-model="editModal.products.supplier_id"
                        >
                            <option value="" class="option-default">
                                Proveedor
                            </option>
                            <option
                                v-for="supplier in suppliers"
                                :key="supplier.id"
                                :value="supplier.id"
                            >
                                {{ supplier.name }}
                            </option>
                        </select>
                    </div>

                    <div class="w-100">
                        <label for="">Precio de proveedor</label>
                        <input
                            type="number"
                            placeholder="Precio de proveedor"
                            class="form-control"
                            v-model="editModal.products.priceSupplier"
                        />
                    </div>
                </div>
                <div class="inputs">
                    <div class="w-100">
                        <label for="">Precio de venta</label>
                        <input
                            type="number"
                            placeholder="Precio de venta"
                            class="form-control"
                            v-model="editModal.products.priceUnit"
                        />
                    </div>
                    <div class="w-100">
                        <label for="">Descripcion</label>
                        <input
                            type="text"
                            placeholder="Descripcion"
                            class="form-control"
                            v-model="editModal.products.description"
                        />
                    </div>
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
import * as yup from "yup";
import axios from "axios";
import Swal from "sweetalert2";

const validationSchema = yup.object({
    code: yup.string().required("El codigo es requerido."),
    name: yup.string().required("Nombre es requerido."),
    stock: yup.string().required("El stock es requerido."),
    expiration: yup.string().required("La fecha de vencimiento es requerida."),
    weight: yup.string().required("El peso es requerido."),
    supplier_id: yup.string().required("El proveedor es requerido."),
    provider_price: yup
        .string()
        .required("El precio de proveedor es requerido."),
    price: yup.string().required("El precio es requerido."),
    description: yup.string(),
});

export default {
    data() {
        return {
            currentPage: 1,
            pageSize: 10,
            form: {
                code: "",
                name: "",
                stock: "",
                expiration: "",
                weight: "",
                supplier_id: "",
                provider_price: "",
                price: "",
                description: "",
            },
            countProducts: "",
            products: [],
            suppliers: [],
            errors: {},
            editModal: { show: false, products: {} },
            filters: {
                code: "",
                name: "",
            },
        };
    },
    mounted() {
        this.fechSuppliers();
        this.fetchProducts();
        this.fechCountProducts();
    },
    computed: {
        filteredProducts() {
            return this.products.filter((product) => {
                const codeMatch = product.code
                    ?.toString()
                    .toLowerCase()
                    .includes(this.filters.code.toLowerCase());
                const nameMatch = product.name
                    ?.toLowerCase()
                    .includes(this.filters.name.toLowerCase());
                return codeMatch && nameMatch;
            });
        },
        paginatedProducts() {
            const start = (this.currentPage - 1) * this.pageSize;
            const end = start + this.pageSize;
            return this.filteredProducts.slice(start, end);
        },
        totalPages() {
            return Math.ceil(this.filteredProducts.length / this.pageSize);
        },
    },
    watch: {
        filters: {
            deep: true,
            handler() {
                this.currentPage = 1;
            },
        },
    },
    methods: {
        formatDate(dateString) {
            if (!dateString) return "";
            const date = new Date(dateString);
            return date.toLocaleDateString();
        },
        openEditModal(products) {
            this.editModal.products = { ...products };
            this.editModal.show = true;
        },
        closeEditModal() {
            this.editModal.show = false;
        },

        updateProduct() {
            axios
                .put(
                    `/api/products/update/${this.editModal.products.id}`,
                    this.editModal.products
                )
                .then(() => {
                    Swal.fire(
                        "Producto actualizado correctamente",
                        "",
                        "success"
                    );
                    this.closeEditModal();
                    this.fetchProducts();
                    this.fechCountProducts();
                })
                .catch(() => {
                    Swal.fire(
                        "Error al actualizar el producto ya estos datos estan en uso",
                        "",
                        "error"
                    );
                });
        },

        fechSuppliers() {
            axios
                .get("/api/suppliers/list")
                .then((response) => {
                    this.suppliers = response.data.suppliers;
                })
                .catch((error) => {
                    console.log("Error fetching suppliers:", error);
                });
        },

        fechCountProducts() {
            axios
                .get("/api/products/count")
                .then((response) => {
                    this.countProducts = response.data;
                })
                .catch((error) => {
                    console.log("Error fetching count:", error);
                });
        },

        fetchProducts() {
            axios
                .get("/api/products/list")
                .then((response) => {
                    this.products = response.data.products.reverse();
                })
                .catch((error) => {
                    console.log("Error fetching products:", error);
                });
        },

        deleteProduct(id) {
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
                        .delete(`/api/products/delete/${id}`)
                        .then(() => {
                            Swal.fire({
                                title: "Eliminado correctamente",
                                icon: "success",
                                draggable: true,
                            });
                            this.fetchProducts();
                            this.fechCountProducts();
                        })
                        .catch((error) => {
                            console.log(error);
                            Swal.fire({
                                title: "Error",
                                text: "No se pudo eliminar el producto.",
                                icon: "error",
                            });
                        });
                }
            });
        },

        async handleSubmit() {
            try {
                await validationSchema.validate(this.form, {
                    abortEarly: false,
                });
                this.errors = {};

                const codeResponse = await axios.get(
                    `/api/products/check-code/${this.form.code}`
                );
                if (codeResponse.data.exists) {
                    this.errors.code =
                        "Este codigo de producto ya está registrado.";
                    return;
                }

                const nameResponse = await axios.get(
                    `/api/products/check-name/${this.form.name}`
                );
                if (nameResponse.data.exists) {
                    this.errors.name =
                        "Este nombre de producto ya esta registrado.";
                    return;
                }

                axios
                    .post("/api/products/save", this.form)
                    .then(() => {
                        Swal.fire({
                            title: "Exitoso",
                            text: "Producto registrado correctamente",
                            icon: "success",
                            confirmButtonText: "Aceptar",
                        });
                        this.form = {
                            code: "",
                            name: "",
                            stock: "",
                            expiration: "",
                            weight: "",
                            supplier_id: "",
                            provider_price: "",
                            price: "",
                            description: "",
                        };
                        this.fetchProducts();
                        this.fechCountProducts();
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "No se ha podido registrar el producto",
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
.table-invetory-product {
    width: 1350px;
}
@media (max-width: 1229px) {
    .table-invetory-product {
        width: 1350px;
    }
}
@media (max-width: 675px) {
    .inputs {
        flex-wrap: wrap;
    }
}
</style>
