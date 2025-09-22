<template>
    <div class="container-content">
        <div class="content-title">
            <h2>Todos los usuarios</h2>
            <p>Usuarios registrados</p>
        </div>

        <div class="table-container" v-if="!isLoading">
            <div class="d-flex justify-content-between align-items-end">
                <div class="filters">
                    <label for="">Filtros de búsqueda</label>
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
                            placeholder="Correo electrónico"
                            v-model="filters.email"
                        />
                    </div>
                </div>
            </div>

            <div class="content-table">
                <table class="table mt-3 table-add-user">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre y apellido</th>
                            <th>RIF/C.I</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Fecha de registro</th>
                            <th>Ver</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, index) in paginatedUsers" :key="user.id">
                            <td>
                                <strong>{{ (currentPage - 1) * pageSize + index + 1 }}</strong>
                            </td>
                            <td>
                                <strong>{{ user.name }} {{ user.last_name }}</strong>
                            </td>
                            <td>
                                <strong>{{ user.dni }}</strong>
                            </td>
                            <td>
                                <strong>{{ user.email }}</strong>
                            </td>
                            <td>
                                <strong>{{ user.phone }}</strong>
                            </td>
                            <td>
                                <strong>{{ formatDateWithTime(user.created_at) }}</strong>
                            </td>
                            <td>
                                <a :href="`/user-view/${user.id}`">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
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
    </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";

export default {
    data() {
        return {
            currentPage: 1,
            pageSize: 10,
            isLoading: false,
            users: [],
            filters: {
                dni: "",
                name: "",
                email: "",
            },
        };
    },
    mounted() {
        this.fetchUsers();
    },
    computed: {
        filteredUsers() {
            return this.users.filter((user) => {
                const dniMatch = user.dni
                    ?.toString()
                    .toLowerCase()
                    .includes(this.filters.dni.toLowerCase());
                const nameMatch = `${user.name} ${user.last_name}`
                    ?.toLowerCase()
                    .includes(this.filters.name.toLowerCase());
                const emailMatch = user.email
                    ?.toLowerCase()
                    .includes(this.filters.email.toLowerCase());
                return dniMatch && nameMatch && emailMatch;
            });
        },
        paginatedUsers() {
            const start = (this.currentPage - 1) * this.pageSize;
            const end = start + this.pageSize;
            return this.filteredUsers.slice(start, end);
        },
        totalPages() {
            return Math.ceil(this.filteredUsers.length / this.pageSize);
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
        formatDateWithTime(dateString) {
            if (!dateString) return "";
            const date = new Date(dateString);
            return date.toLocaleString();
        },
        async fetchUsers() {
            this.isLoading = true;
            try {
                const response = await axios.get("/api/clients/list");
                this.users = response.data.clients;
            } catch (error) {
                console.error("Error fetching users:", error);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No se pudieron cargar los usuarios.",
                });
            } finally {
                this.isLoading = false;
            }
        },
    },
};
</script>

<style>
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
    width: 100%;
    min-width: 800px;
}
@media (max-width: 675px) {
    .inputs {
        flex-wrap: wrap;
    }
}
</style>