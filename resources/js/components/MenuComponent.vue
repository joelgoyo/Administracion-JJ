<template>
    <head>
        <title>Administracion</title>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
            rel="stylesheet"
        />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/brands.min.css"
        />
        <link
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
            rel="stylesheet"
        />
    </head>
    <div :class="`${colapse ? '' : 'colapse-user'}`">
        <div class="menu-side">
            <div>
                <div class="user">
                    <img
                        src="../../../public/img/photoUser.svg"
                        alt="Foto de usuario"
                    />
                    <div class="content-user">
                        <h3>Administracion</h3>
                        <p>lunes, Enero 20, 2025</p>
                    </div>
                    <i
                        class="icon-closet-open fa-solid"
                        :class="`${
                            colapse ? 'fa-arrow-left' : 'fa-arrow-right'
                        }`"
                        @click="colapseNav"
                    ></i>
                </div>
                <h4 class="text-menu">Menu Principal</h4>

                <nav class="opcion-menu">
                    <div class="list-menu">
                        <router-link to="/" class="link">
                            <div class="menu-item d-flex align-items-center">
                                <i class="icon-text fa-solid fa-house"></i>
                                <div class="text">Home</div>
                            </div>
                        </router-link>
                        <router-link to="/billing" class="link">
                            <div class="menu-item d-flex align-items-center">
                                <i
                                    class="icon-text fa-solid fa-money-bills"
                                ></i>
                                <div class="text">Facturacion</div>
                            </div>
                        </router-link>
                        <div class="link" @click="arrowToggleTwo">
                            <div
                                class="menu-item d-flex justify-content-between align-items-center"
                            >
                                <div class="d-flex align-items-center">
                                    <i class="icon-text fa-solid fa-box"></i>
                                    <div class="text">Inventario</div>
                                </div>
                                <i
                                    class="arrow fa-solid"
                                    :class="`${
                                        changeTwo
                                            ? 'fa-angle-down '
                                            : 'fa-angle-up'
                                    }`"
                                ></i>
                            </div>

                            <div
                                class="ul"
                                :class="`${changeTwo ? 'delete' : 'view'}`"
                            >
                                <router-link to="/add-products" class="link">
                                    <div
                                        class="menu-item d-flex justify-content-between align-items-center"
                                    >
                                        <div class="d-flex align-items-center">
                                            <i
                                                class="icon-text fa-solid fa-circle-plus"
                                            ></i>
                                            <div class="text">
                                                Agregar productos
                                            </div>
                                        </div>
                                    </div>
                                </router-link>
                                <router-link to="/edit-products" class="link">
                                    <div
                                        class="menu-item d-flex justify-content-between align-items-center"
                                    >
                                        <div class="d-flex align-items-center">
                                            <i
                                                class="icon-text fa-solid fa-pen-to-square"
                                            ></i>
                                            <div class="text">
                                                Editar o eliminar productos
                                            </div>
                                        </div>
                                    </div>
                                </router-link>
                            </div>
                        </div>
                        <router-link to="/customer-registration" class="link">
                            <div class="menu-item d-flex align-items-center">
                                <i class="icon-text fa-solid fa-users"></i>
                                <div class="text">Registro de cliente</div>
                            </div>
                        </router-link>
                        <router-link to="/supplier-registration" class="link">
                            <div class="menu-item d-flex align-items-center">
                                <i class="icon-text fa-solid fa-user"></i>
                                <div class="text">Registro de provedores</div>
                            </div>
                        </router-link>
                        <div class="link" @click="arrowToggle">
                            <div
                                class="menu-item d-flex justify-content-between align-items-center"
                            >
                                <div class="d-flex align-items-center">
                                    <i
                                        class="icon-text fa-solid fa-hand-holding-dollar"
                                    ></i>
                                    <div class="text">Contabilidad</div>
                                </div>
                                <i
                                    class="arrow fa-solid"
                                    :class="`${
                                        change
                                            ? 'fa-angle-down '
                                            : 'fa-angle-up'
                                    }`"
                                ></i>
                            </div>
                            <div
                                class="ul"
                                :class="`${change ? 'delete' : 'view'}`"
                            >
                                <router-link to="/income" class="link">
                                    <div
                                        class="menu-item d-flex justify-content-between align-items-center"
                                    >
                                        <div class="d-flex align-items-center">
                                            <i
                                                class="icon-text fa-solid fa-circle-plus"
                                            ></i>
                                            <div class="text">Ingresos</div>
                                        </div>
                                    </div>
                                </router-link>
                                <router-link to="/expenses" class="link">
                                    <div
                                        class="menu-item d-flex justify-content-between align-items-center"
                                    >
                                        <div class="d-flex align-items-center">
                                            <i
                                                class="icon-text fa-solid fa-circle-minus"
                                            ></i>
                                            <div class="text">Egresos</div>
                                        </div>
                                    </div>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>

            <a href="/logout">
                <div class="btn-logout d-flex align-items-center">
                    <i class="fa-solid fa-circle-xmark"></i>
                    <div class="text">Cerrar sesion</div>
                </div>
            </a>
        </div>
    </div>
</template>

<script setup>
import { RouterLink } from "vue-router";
import { ref } from "vue";
const change = ref(true);
const changeTwo = ref(true);
const colapse = ref(true);

const arrowToggle = () => {
    change.value = !change.value;
};
const arrowToggleTwo = () => {
    changeTwo.value = !changeTwo.value;
};
const colapseNav = () => {
    colapse.value = !colapse.value;
};
</script>

<style scoped>
* {
    font-family: "Roboto";
}
p {
    margin-bottom: 0 !important;
}
h3 {
    margin-bottom: 0 !important;
    font-size: 14px !important;
    font-weight: 500;
}
a{
    text-decoration: none;
}
.ul {
    margin-left: 12px;
}
.delete {
    visibility: hidden;
    position: absolute;
    opacity: 0;
}
.view {
    visibility: visible;
    position: relative;
    opacity: 1;
    transition: all 400ms;
}
.menu-side {
    background-color: #f4f6f8;
    width: 330px;
    padding: 32px 24px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100vh;
}

.menu-side .user {
    display: flex;
    align-items: center;
    background-color: #ffffff;
    padding: 12px 6px;
    border-radius: 20px;
    justify-content: space-around;
}
.menu-side .user img {
    width: 50px;
    height: 50px;
}
.menu-side .user p {
    color: #96b6ff;
    font-size: 12px;
}
.menu-side .text-menu {
    font-size: 16px;
    padding: 26px 0px;
    color: #b9b9b9;
    margin-bottom: 0px;
}
.menu-side .list-menu .link .menu-item .icon-text {
    padding: 8px;
    background-color: #c4d6ff;
    border-radius: 8px;
    margin-right: 12px;
    color: #1958f7;
    width: 34px;
    text-align: center;
}
.icon-closet-open {
    padding: 8px;
    background-color: #c4d6ff;
    border-radius: 8px;
    color: #1958f7;
    text-align: center;
    font-size: 10px;
    cursor: pointer;
    transition: all 300ms;
}
.icon-closet-open:hover {
    transition: all 300ms;
    background-color: #b3caff;
}

.menu-side .list-menu .link .menu-item .arrow {
    color: #1958f7;
    margin-right: 8px;
}
.opcion-menu .list-menu .link .menu-item:hover .arrow {
    color: #ffffff;
    transition: all 200ms;
}
.btn-danger {
    background-color: #ff3f3f !important;
    color: #ffffff;
}
.btn-logout {
    color: #393939;
    margin-bottom: 8px;
    padding: 8px;
    border-radius: 16px;
    margin-left: 0;
    list-style: none;
    transition: all 200ms;
    cursor: pointer;
    font-weight: 400;
    font-size: 14px;
    text-decoration: none;
}
.btn-logout:hover {
    background-color: #ff3f3f;
    color: #ffffff;
    margin-left: 8px;
    text-decoration: none;
}
.btn-logout i {
    padding: 8px;
    background-color: #fff6f6;
    border-radius: 8px;
    margin-right: 12px;
    color: #ff3f3f;
}
.opcion-menu .list-menu .link {
    text-decoration: none;
}
.opcion-menu .list-menu .link .menu-item {
    color: #393939;
    margin-bottom: 8px;
    padding: 8px;
    border-radius: 16px;
    margin-left: 0;
    transition: all 200ms;
    cursor: pointer;
    font-weight: 400;
    font-size: 14px;
    text-decoration: none;
}
.opcion-menu .list-menu .link .menu-item:hover {
    background-color: #1958f7;
    color: #ffffff;
    margin-left: 8px;
}
.content-user {
    padding: 0 12px;
    .menu-side {
        background-color: #f4f6f8;
        width: auto;
        padding: 32px 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100vh;
    }
}
.colapse-user .user {
    flex-direction: column;
}
.colapse-user .content-user {
    display: none;
}
.colapse-user img {
    width: 40px;
    height: 40px;
    padding-bottom: 8px;
}
.colapse-user .text {
    display: none !important;
}
.colapse-user .text-menu {
    display: none;
}
.colapse-user .menu-side {
    width: auto;
    align-items: center
}
.colapse-user .opcion-menu {
    padding-top: 42px;
}
.colapse-user .arrow {
    display: none;
}
.colapse-user .opcion-menu .list-menu .link .menu-item {
    display: flex;
    justify-content: center;
}
.colapse-user .opcion-menu .list-menu .link {
    display: flex;
    justify-content: center;
}
.colapse-user .opcion-menu .list-menu .link .menu-item:hover {
    background-color: #1958f7;
    color: #ffffff;
    margin-left: 0px;
}
.colapse-user .menu-side .list-menu .link .menu-item .icon-text {
    padding: 8px;
    background-color: #c4d6ff;
    border-radius: 8px;
    margin-right: 0px;
    color: #1958f7;
    width: 34px;
}
.colapse-user .btn-logout {
    color: #393939;
    margin-bottom: 8px;
    padding: 8px 21px;
    border-radius: 16px;
    margin-left: 0;
    list-style: none;
    transition: all 200ms;
    cursor: pointer;
    font-weight: 400;
    font-size: 14px;
    text-decoration: none;
    display: flex;
    justify-content: center;
    width: 34px;
}
.colapse-user .btn-logout:hover {
    background-color: #ff3f3f;
    color: #ffffff;
    margin-left: 0px;
    text-decoration: none;
}
.colapse-user .btn-logout i {
    padding: 8px;
    background-color: #fff6f6;
    border-radius: 8px;
    margin-right: 0px;
    color: #ff3f3f;
}
</style>
