<template>
    <div class="container-content">
        <div
            class="content-title d-flex justify-content-between align-items-center"
        >
            <div>
                <h2>Facturación</h2>
                <p>Factura electronica y impresion</p>

                <div class="d-flex">
                    <div class="dolar-bcv mr-2 dolars-price">
                        Dolar BCV: {{ dolarBcv.price }}Bs
                    </div>
                    
                    <div class="dolar-promedio dolars-price mr-2">
                        Dolar Promedio: {{ dolarPromedio }}Bs
                    </div>

                    <div class="dolar-paralelo dolars-price">
                        Dolar Paralelo: {{ dolarParalelo.price }}Bs
                    </div>
                </div>
            </div>

            <div class="client-info">
                <h4>{{ clientName }}</h4>
                <p>C.I: {{ clientCI }}</p>
                <p>Numero de telefono: {{ clientPhone }}</p>
            </div>
        </div>

        <div class="data-clients">
            <router-link to="/customer-registration"
                ><button class="btn btn-danger">
                    REGISTRAR NUEVO CLIENTE
                </button></router-link
            >

            <div class="inputs-content">
                <label for="">Datos del cliente</label>
                <div class="inputs">
                    <input
                        type="text"
                        placeholder="C.I"
                        class="form-control"
                        v-model="clientCI"
                        @input="filterClients"
                    />
                    <input
                        type="text"
                        placeholder="Nombre y Apellido"
                        class="form-control"
                        v-model="clientName"
                    />
                    <input
                        type="text"
                        placeholder="Dirección"
                        class="form-control"
                        v-model="clientAddress"
                    />
                    <input
                        type="number"
                        placeholder="Numero de telefono"
                        class="form-control"
                        v-model="clientPhone"
                    />
                </div>

                <div class="search-clients d-flex flex-wrap flex-direction-row">
                    <div
                        class=""
                        v-for="(client, index) in filteredClients"
                        :key="index"
                        @click="selectClient(client)"
                    >
                        <div class="m-1 select-client">
                            {{ client.dni }} - {{ client.name }}
                            {{ client.last_name }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="inputs-content">
                <label for="">Datos de la Factura</label>
                <div class="inputs">
                    <input
                        type="text"
                        placeholder="Lugar de emisión"
                        class="form-control"
                    />
                    <input
                        type="text"
                        placeholder="Fecha"
                        class="form-control"
                    />
                    <select
                        name=""
                        aria-placeholder="Tipo de entrega"
                        class="form-control"
                    >
                        <option value="" class="option-default">
                            Tipo de entrega
                        </option>
                        <option value="Entrega a domicilio">
                            Entrega a domicilio
                        </option>
                        <option value="Retiro en tienda">
                            Retiro en tienda
                        </option>
                    </select>
                    <select
                        name=""
                        aria-placeholder="Tipo de pago"
                        class="form-control"
                    >
                        <option value="" class="option-default">
                            Tipo de pago
                        </option>
                        <option value="Entrega a domicilio">
                            Transferencia
                        </option>
                        <option value="Retiro en tienda">Punto de venta</option>
                        <option value="Retiro en tienda">Pago movil</option>
                        <option value="Retiro en tienda">Efectivo</option>
                    </select>
                </div>
                <div class="inputs">
                    <input
                        type="text"
                        placeholder="Orden de compra"
                        class="form-control"
                    />
                    <input
                        type="text"
                        placeholder="Nota de entrega"
                        class="form-control"
                    />
                    <input
                        type="text"
                        placeholder="De fecha"
                        class="form-control"
                    />
                    <input
                        type="number"
                        placeholder="Numero de telefono"
                        class="form-control"
                    />
                </div>
            </div>
        </div>

        <div class="table-container">
            <button class="btn btn-primary" @click="showProductModal = true">
                AGREGAR PRODUCTOS
            </button>
            <div class="content-table">
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th scope="col">Acciones</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Codigo</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Peso KG</th>
                            <th scope="col">Precio UNIT</th>
                            <th scope="col">Monto total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in selectedProducts"
                            :key="item.product.id"
                        >
                            <td>
                                <i
                                    title="Eliminar"
                                    class="fa-solid fa-trash"
                                    @click="removeProduct(index)"
                                ></i>
                            </td>
                            <td>
                                <strong>{{ item.product.name }}</strong>
                            </td>
                            <td>{{ item.product.code }}</td>
                            <td>
                                <div class="text-dark">
                                    <i class="fa-solid fa-box mr-1"></i>
                                    <strong>{{ item.quantity }}</strong>
                                </div>
                            </td>
                            <td>
                                <strong>{{ item.product.weight }}Kg</strong>
                            </td>
                            <td class="text-success">
                                <strong>{{ item.product.priceUnit }}$</strong>
                            </td>
                            <td class="text-success">
                                <strong
                                    >{{
                                        item.product.priceUnit * item.quantity
                                    }}$</strong
                                >
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="total d-flex align-items-end">
                    <h4>
                        Dolar promedio: <strong class="text-success">{{ calculateTotal }}$</strong>
                    </h4>
                    <h4>
                        Precio Total: <strong class="text-success">{{ calculateTotal * dolarPromedio }}Bs</strong>
                    </h4>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn btn-primary mr-2">
                FACTURAR Y ENVIAR AL CORREO
            </button>
            <button class="btn btn-primary">IMPRIMIR FACTURA</button>
        </div>
    </div>

    <div v-if="showProductModal" class="modal-x">
        <div class="modal-y modal-products">
            <h2 class="mb-3">Lista de Productos</h2>
            <input
                type="text"
                placeholder="Codigo del producto"
                class="form-control mb-3"
                v-model="productFilter"
            />
            <div class="table-container">
                <div class="content-table">
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th scope="col">Seleccionar</th>
                                <th scope="col">Producto</th>
                                <th scope="col">Codigo</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Peso KG</th>
                                <th scope="col">Precio UNIT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="product in filteredProductList"
                                :key="product.id"
                            >
                                <td>
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            value=""
                                            id="flexCheckIndeterminate"
                                            v-model="product.selected"
                                        />
                                    </div>
                                </td>
                                <td>
                                    <strong>{{ product.name }}</strong>
                                </td>
                                <td>{{ product.code }}</td>
                                <td>
                                    <input
                                        type="number"
                                        v-model.lazy="product.modalQuantity"
                                        min="1"
                                        value="1"
                                        class="form-control"
                                    />
                                </td>
                                <td>
                                    <strong>{{ product.weight }}Kg</strong>
                                </td>
                                <td class="text-success">
                                    <strong>{{ product.priceUnit }}$</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <ul v-if="products && products.length > 0"></ul>
            <p v-else>No hay productos disponibles.</p>

            <button
                @click="showProductModal = false"
                class="btn btn-danger mr-2"
            >
                Cerrar
            </button>
            <button
                class="btn btn-primary"
                @click="addSelectedProductsToInvoice"
            >
                Agregar los productos a la factura
            </button>
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
            data: null,
            listClients: [],
            filteredClients: [],
            clientCI: "",
            clientName: "",
            clientAddress: "",
            clientPhone: "",
            products: [],
            showProductModal: false,
            productFilter: "",
            selectedProducts: [],
            dolarBcv: "",
            dolarParalelo: "",
        };
    },
    components: {
        LoadingComponent,
    },

    mounted() {
        axios
            .get("https://pydolarve.org/api/v1/dollar?page=alcambio")
            .then((response) => {
                this.dolarBcv = response.data.monitors.bcv;
                this.dolarParalelo = response.data.monitors.enparalelovzla;

                const suma = this.dolarBcv.price + this.dolarParalelo.price; 
                this.dolarPromedio = suma / 2;
            });
        this.clientsDate();
        this.productsList();
    },
    computed: {
        filteredProductList() {
            if (this.productFilter) {
                return this.products.filter((product) =>
                    product.code
                        .toLowerCase()
                        .includes(this.productFilter.toLowerCase())
                );
            } else {
                return this.products;
            }
        },
        calculateTotal() {
            return this.selectedProducts.reduce(
                (total, item) => total + item.product.priceUnit * item.quantity,
                0
            );
        },
    },
    methods: {
        removeProduct(index) {
            this.selectedProducts.splice(index, 1);
        },
        filterClients() {
            if (this.clientCI) {
                this.filteredClients = this.listClients.filter((client) =>
                    client.dni.includes(this.clientCI)
                );
            } else {
                this.filteredClients = [];
            }
        },
        selectClient(client) {
            this.clientCI = client.dni;
            this.clientName = `${client.name} ${client.last_name}`;
            this.clientAddress = client.address;
            this.clientPhone = client.phone;
        },
        clientsDate() {
            axios.get("/api/clients/list").then((response) => {
                this.listClients = response.data.clients;
            });
        },
        productsList() {
            axios.get("/api/products/list").then((response) => {
                this.products = response.data.products;
                this.products.forEach((product) => {
                    product.selected = false;
                    product.modalQuantity = 1;
                });
            });
        },
        addSelectedProductsToInvoice() {
            const selected = this.products.filter(
                (product) => product.selected
            );
            selected.forEach((product) => {
                this.selectedProducts.push({
                    product: product,
                    quantity: product.modalQuantity,
                });
            });
            this.showProductModal = false;
            this.products.forEach((product) => {
                product.selected = false;
                product.modalQuantity = 1;
            });
        },
    },
};
</script>
<style>
.dolars-price {
    margin-top: 12px;
    color: #fff;
    font-weight: 600;
    border-radius: 10px;
    padding: 8px 12px;
    background: linear-gradient(to right, #fc466b, #3f5efb);
    background-size: 200% 100%; /* Doble del tamaño para permitir el movimiento */
    animation: gradientShift 3s linear infinite alternate; /* Animación */
}
@keyframes gradientShift {
  0% {
    background-position: 0% 50%; /* Inicio del gradiente */
  }
  100% {
    background-position: 100% 50%; /* Fin del gradiente */
  }
}
.selected {
    cursor: pointer;
}
.client-info {
    text-align: end;
}
.client-info h4 {
    font-size: 20px;
    margin-bottom: 0px;
}

.client-info p {
    color: #1a1a1a !important;
    margin-bottom: 0px;
    line-height: 20px;
}
.select-client {
    background-color: rgb(235, 235, 235);
    font-size: 12px;
    font-weight: 600;
    color: #7f7f7f;
    padding: 8px 12px;
    border-radius: 100px;
    display: flex;
    cursor: pointer;
    transition: all 150ms;
    border: 1px solid #9e9e9e;
}
.select-client:hover {
    background-color: rgb(182, 182, 182);
    color: #1a1a1a;
}
.modal-products {
    width: 80% !important;
}
.total{
    flex-direction: column;
    justify-content: flex-end !important;
}
</style>
