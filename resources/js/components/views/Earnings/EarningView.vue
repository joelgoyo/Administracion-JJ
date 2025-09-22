<template>
    <div class="container-content">
        <div class="content-title">
            <h2>Ganancias</h2>
            <p>Ganancias en bruto y ganancias netas</p>
        </div>
        <div class="filter-section mb-3">
            <label for="start-date">Fecha Inicio:</label>
            <input
                type="date"
                v-model="startDate"
                id="start-date"
                class="date-input"
            />
            <label for="end-date">Fecha Fin:</label>
            <input
                type="date"
                v-model="endDate"
                id="end-date"
                class="date-input"
            />
            <button @click="applyFilter" class="filter-button">Filtrar</button>
            <button
                v-if="startDate || endDate"
                @click="clearFilter"
                class="clear-button"
            >
                Limpiar Filtro
            </button>
        </div>
        <div class="d-flex">
            <!-- GANANCIAS -->
            <div class="content-earnings d-flex flex-column justify-content-between">
                <div class="content">
                    <h2 class="mb-3">Ganancias</h2>
                    <div class="table-ernings">
                        <div v-if="isLoading" class="text-center">
                            <p>Cargando facturas...</p>
                        </div>
                        <div v-else-if="!bills.length" class="text-center">
                            No hay facturas registradas.
                        </div>
                        <div
                            v-else
                            class="d-flex justify-content-between align-items-center orders"
                            v-for="bill in bills"
                            :key="bill.id"
                        >
                            <span>{{ bill.client.name }} {{ bill.client.last_name }}</span>
                            <span>{{ formatDateWithTime(bill.date || bill.created_at) }}</span>
                            <span>{{ formatCurrency(bill.amount, '$') }}</span>
                            <span>{{ formatCurrency(bill.amount - bill.supplierCost, '$') }}</span>
                            <span>{{ formatCurrency(bill.amount_bs, 'Bs') }}</span>
                        </div>
                    </div>
                </div>
                <h3 class="mt-3">Total Ganancias: {{ formatCurrency(totalEarnings, '$') }}</h3>
            </div>

            <!-- GASTOS -->
            <div class="content-expensee d-flex flex-column justify-content-between">
                <div class="content">
                    <h2 class="mb-3">Gastos</h2>
                    <div class="table-expenses">
                        <div v-if="isLoading" class="text-center">
                            <p>Cargando gastos...</p>
                        </div>
                        <div v-else-if="!expenses.length" class="text-center">
                            No hay gastos registrados.
                        </div>
                        <div
                            v-else
                            class="d-flex justify-content-between align-items-center orders"
                            v-for="expense in expenses"
                            :key="expense.id"
                        >
                            <span>{{ expense.description_expenses }}</span>
                            <span>{{ formatDateWithTime(expense.date || expense.created_at) }}</span>
                            <span>{{ formatCurrency(expense.payment_amount, '$') }}</span>
                        </div>
                    </div>
                </div>
                <h3 class="mt-3">Total Gastos: {{ formatCurrency(totalExpenses, '$') }}</h3>
            </div>
        </div>

        <!-- GANANCIAS NETAS -->
        <div class="content-net-earnings mt-4">
            <h3 class="mt-2">Ganancias netas: {{ formatCurrency(netEarnings, '$') }}</h3>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";

export default {
    data() {
        return {
            bills: [],
            allBills: [],
            expenses: [],
            allExpenses: [],
            isLoading: false,
            startDate: null,
            endDate: null,
        };
    },

    computed: {
        totalEarnings() {
            return this.bills.reduce((total, bill) => {
                const amount = parseFloat(bill.amount) || 0;
                const supplierCost = parseFloat(bill.supplierCost) || 0;
                return total + (amount - supplierCost);
            }, 0);
        },
        totalExpenses() {
            return this.expenses.reduce((total, expense) => {
                const amount = parseFloat(expense.payment_amount) || 0;
                return total + amount;
            }, 0);
        },
        netEarnings() {
            return this.totalEarnings - this.totalExpenses;
        },
    },

    mounted() {
        this.setCurrentWeek();
        this.fetchBills();
        this.fetchExpenses();
    },

    methods: {
        setCurrentWeek() {
            const today = new Date();
            const dayOfWeek = today.getDay(); // 0 (domingo) a 6 (sábado)
            const diffToMonday = dayOfWeek === 0 ? -6 : 1 - dayOfWeek; // Diferencia al lunes
            const monday = new Date(today);
            monday.setDate(today.getDate() + diffToMonday);
            const sunday = new Date(monday);
            sunday.setDate(monday.getDate() + 6);

            this.startDate = monday.toISOString().split('T')[0]; // YYYY-MM-DD
            this.endDate = sunday.toISOString().split('T')[0]; // YYYY-MM-DD
        },
        formatDateWithTime(dateString) {
            if (!dateString) return "";
            const date = new Date(dateString);
            return date.toLocaleString();
        },
        formatCurrency(value, currency = '$') {
            if (isNaN(value)) return `${currency}0.00`;
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: currency === '$' ? 'USD' : 'VES',
            }).format(value);
        },
        fetchBills() {
            this.isLoading = true;
            axios
                .get("/api/billing/getClientsWithBillsAndProducts")
                .then((response) => {
                    this.allBills = response.data.clients.reduce((acc, client) => {
                        return acc.concat(client.bills.map(bill => ({
                            id: bill.bill_id,
                            client: {
                                name: client.client_name,
                                last_name: client.client_last_name,
                            },
                            created_at: bill.created_at,
                            date: bill.date,
                            amount: bill.amount,
                            amount_bs: bill.amount_bs,
                            products: bill.products,
                            supplierCost: bill.products.reduce((total, product) => {
                                const priceSupplier = parseFloat(product.priceSupplier) || 0;
                                const quantity = parseFloat(product.quantity) || 1;
                                return total + (priceSupplier * quantity);
                            }, 0),
                            showProducts: false
                        })));
                    }, []).reverse();
                    this.applyFilter();
                    console.log(this.allBills);
                })
                .catch((error) => {
                    console.error("Error al obtener las facturas:", error);
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "No se pudieron cargar las facturas.",
                    });
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        fetchExpenses() {
            this.isLoading = true;
            axios
                .get("/api/expenses/list")
                .then((response) => {
                    this.allExpenses = response.data.expenses.map(expense => ({
                        ...expense,
                        date: expense.date || expense.created_at
                    })).reverse();
                    this.applyFilter();
                    console.log(this.allExpenses);
                })
                .catch((error) => {
                    console.error("Error al obtener los gastos:", error);
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "No se pudieron cargar los gastos.",
                    });
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        applyFilter() {
            this.bills = this.allBills.filter(bill => {
                const billDate = bill.date || bill.created_at;
                if (!billDate) return false;
                const date = new Date(billDate).setHours(0, 0, 0, 0);
                const start = this.startDate ? new Date(this.startDate).setHours(0, 0, 0, 0) : null;
                const end = this.endDate ? new Date(this.endDate).setHours(0, 0, 0, 0) : null;

                if (start && end) {
                    return date >= start && date <= end;
                } else if (start) {
                    return date >= start;
                } else if (end) {
                    return date <= end;
                }
                return true;
            });

            this.expenses = this.allExpenses.filter(expense => {
                const expenseDate = expense.date || expense.created_at;
                if (!expenseDate) return false;
                const date = new Date(expenseDate).setHours(0, 0, 0, 0);
                const start = this.startDate ? new Date(this.startDate).setHours(0, 0, 0, 0) : null;
                const end = this.endDate ? new Date(this.endDate).setHours(0, 0, 0, 0) : null;

                if (start && end) {
                    return date >= start && date <= end;
                } else if (start) {
                    return date >= start;
                } else if (end) {
                    return date <= end;
                }
                return true;
            });

            if (this.endDate && this.startDate && this.endDate < this.startDate) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "La fecha de fin no puede ser anterior a la fecha de inicio.",
                });
                this.bills = [];
                this.expenses = [];
            }
        },
        clearFilter() {
            this.setCurrentWeek();
            this.applyFilter();
        },
    },
};
</script>

<style>
.table-ernings .orders {
    margin-bottom: 8px;
    border-bottom: 1px solid #d8d8d8;
}
.table-ernings .orders span {
    margin-right: 18px;
    margin-top: 4px;
    margin-bottom: 4px;
    color: #2ebd6a;
    font-weight: 600;
    
}
.content-earnings {
    padding: 24px;
    background-color: #f4f6f8;
    border-radius: 20px;
    margin-bottom: 24px;
    margin-right: 24px;
    width: 50%;
}
.content-expensee {
    padding: 24px;
    background-color: #f4f6f8;
    border-radius: 20px;
    margin-bottom: 24px;
    width: 50%;
}
.content-expensee .orders {
    margin-bottom: 8px;
    border-bottom: 1px solid #d8d8d8;
}
.content-expensee .orders span {
    margin-bottom: 8px;
    margin-right: 18px;
    color: #bd2e2e;
    font-weight: 600;
}
.content-table {
    overflow-x: auto;
    width: 100%;
}
.table-add-bill {
    width: 1600px;
}
.filter-section {
    display: flex;
    align-items: center;
    gap: 15px;
}
.date-input {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}
.filter-button, .clear-button {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
.filter-button {
    background-color: #007bff;
    color: white;
}
.filter-button:hover {
    background-color: #0056b3;
}
.clear-button {
    background-color: #dc3545;
    color: white;
}
.clear-button:hover {
    background-color: #bd2130;
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
    .filter-section {
        flex-wrap: wrap;
    }
}
</style>