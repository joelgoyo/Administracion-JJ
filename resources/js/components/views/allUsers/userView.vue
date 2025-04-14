<template>
    <div class="container-content">
        <div class="content-title">
            <h2>{{ client.name }} {{ client.last_name }}</h2>
            <p>Detalles del usuarios</p>
            <p class="text-dark mt-3"> <strong>C.I:</strong>  {{ client.dni }}</p>
            <p class="text-dark"><strong>Telefono:</strong>  {{ client.phone }} </p>
            <p class="text-dark"><strong>Email:</strong>  {{ client.email }}</p>
            <p class="text-dark"><strong>Direccion:</strong>  {{ client.address }} </p>
        </div>

        <!-- FILTROS Y TABLA DE FACTURAS -->
        <div class="table-container">
            <h2 class="mb-3">Facturas del cliente</h2>
            <div class="content-table">
                <div
                    v-for="bill in bills_client"
                    class="bills-produscts-container"
                >
                    <div class="bill" @click="toggleProducts(bill.id)">
                        <span>Factura</span>
                        <span>{{ bill.order }}</span>
                        <span>{{ formatDateWithTime(bill.created_at) }}</span>
                        <span>{{ bill.PlaceIssue }}</span>
                        <span class="text-success text-bold">{{ bill.amount }}$</span>
                        <span class="text-success text-bold">{{ bill.amount_bs }}Bs</span>
                        <span>
                            <i
                                class="fa-solid"
                                :class="
                                    expandedBills.includes(bill.id)
                                        ? 'fa-angle-up'
                                        : 'fa-angle-down'
                                "
                            ></i
                        ></span>
                    </div>
                    <transition @enter="expand" @leave="collapse">
                        <div
                            v-if="expandedBills.includes(bill.id)"
                            class="mb-4"
                        >
                            <div
                                v-for="product in bill.products"
                                :key="product.id"
                                class="products-items d-flex justify-content-between align-items-center"
                            >
                            <span>{{ product.code }}</span>
                            <span>{{ product.name }}</span>
                            <span class="text-success text-bold">{{ product.priceUnit }}$</span>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </div>

        <div class="gastos-totales">
            <h4 class="text-right">
                Total de facturas:
                <span class="text-success">{{ bills_client.length }}</span>
            </h4>
            <h4 class="text-right">
                Monto total:
                <span class="text-success">{{ totalAmount.toFixed(2) }}$</span>
            </h4>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";

export default {
    data() {
        return {
            bills_client: "",
            client: "",
            expandedBills: [],
        };
    },

    computed: {
        totalAmount() {
            if (!this.bills_client || !Array.isArray(this.bills_client)) {
                return 0; // Devuelve 0 si bills_client no es un arreglo
            }
            return this.bills_client.reduce((total, bill) => {
                const amount = Number(bill.amount) || 0; // Convierte a número, usa 0 si no es válido
                return total + amount;
            }, 0);
        },
    },
    mounted() {
        const path = window.location.pathname; // "/users-view/12"
        const id = path.split("/").pop();
        axios
            .get("/api/clients/details", { params: { id } }) // Sin la barra al final "/"
            .then((response) => {
                this.client = response.data.client;
                this.bills_client = response.data.client_bills;
                console.log(this.bills_client);
            })
            .catch((error) => {
                console.error("Error en la petición:", error);
            });
    },

    methods: {
        toggleProducts(billId) {
            const index = this.expandedBills.indexOf(billId);
            if (index > -1) {
                this.expandedBills.splice(index, 1);
            } else {
                this.expandedBills.push(billId);
            }
        },
        expand(el) {
            el.style.height = "0";
            el.style.opacity = "0";
            el.style.transition = "all 0.3s ease";
            requestAnimationFrame(() => {
                el.style.height = el.scrollHeight + "px";
                el.style.opacity = "1";
            });
        },
        collapse(el) {
            el.style.height = el.scrollHeight + "px";
            el.style.opacity = "1";
            requestAnimationFrame(() => {
                el.style.transition = "all 0.3s ease";
                el.style.height = "0";
                el.style.opacity = "0";
            });
        },
        toggleProducts(billId) {
            const index = this.expandedBills.indexOf(billId);
            if (index > -1) {
                this.expandedBills.splice(index, 1); // si ya está, lo quita
            } else {
                this.expandedBills.push(billId); // si no está, lo agrega
            }
        },
        formatDateWithTime(dateString) {
            if (!dateString) return "";
            const date = new Date(dateString);
            return date.toLocaleString();
        },

        fetchBills() {
            axios
                .get("/api/clients/details", {
                    params: { id: this.$route.params.id },
                })
                .then((response) => {
                    this.client = response; // Almacena directamente el objeto { id: 123 }
                    console.log(this.client); // Debería mostrar { id: 123 }
                })
                .catch((error) => {
                    console.error(
                        "Error al obtener los datos del cliente:",
                        error
                    );
                });
        },

        deleteBill(id) {
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
                        .delete(`/api/billing/delete/${id}`)
                        .then(() => {
                            Swal.fire("Eliminado correctamente", "", "success");
                            this.fetchBills();
                        })
                        .catch(() => {
                            Swal.fire(
                                "Error",
                                "No se pudo eliminar la factura.",
                                "error"
                            );
                        });
                }
            });
        },
    },
};
</script>

<style>
.products {
    overflow: hidden;
}
.products-items{
    margin-bottom: 8px;
    margin-left: 12px;
    background-color: #e7e7e7;
    border-radius: 8px;
    padding: 8px 12px;
}
.bill {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #d4d4d4;
    padding: 8px 12px;
    margin-bottom: 8px;
    border-radius: 5px;
}
.bill span {
    color: #393939;
    font-weight: 500;
    font-size: 16px;
}
.products {
    border: 1px solid #1958f7;
    padding: 8px 12px;
    border-radius: 5px;
}
.fa-file-pdf {
    font-size: 18px;
    color: #f71919;
    transition: all 200ms;
    cursor: pointer;
}
.fa-file-pdf:hover {
    color: #ffffff;
}

.fa-eye {
    cursor: pointer;
    transition: all 200ms;
    color: #7f7f7f;
}
.fa-eye:hover {
    color: #1958f7;
}
.content-table {
    overflow-x: auto;
    width: 100%;
}
.table-add-user {
    width: 1097px;
}
@media (max-width: 1229px) {
    .table-add-product {
        width: 1600px !important;
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
