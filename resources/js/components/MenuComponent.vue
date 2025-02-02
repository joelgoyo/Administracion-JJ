<template>
    <head>
        <title>Administracion</title>
    </head>

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
            </div>
            <h4 class="text-menu">Menu Principal</h4>

            <nav class="opcion-menu">
                <div class="list-menu">
                    <router-link to="/" class="link">
                        <div class="menu-item">
                            <i class="icon-text fa-solid fa-house"></i>Home
                        </div>
                    </router-link>
                    <router-link to="/billing" class="link">
                        <div class="menu-item">
                            <i class="icon-text fa-solid fa-money-bills"></i>Facturacion
                        </div>
                    </router-link>
                    <router-link to="/inventory" class="link">
                        <div class="menu-item d-flex justify-content-between align-items-center">
                            <div><i class="icon-text fa-solid fa-box"></i>Inventario</div><i class="arrow fa-solid fa-angle-down"></i>
                        </div>
                    </router-link>
                    <router-link to="/customer-registration" class="link">
                        <div class="menu-item">
                            <i class="icon-text fa-solid fa-users"></i>Registro de clientes
                        </div>
                    </router-link>
                    <router-link to="/supplier-registration" class="link">
                        <div class="menu-item">
                            <i class="icon-text fa-solid fa-user"></i>Registro de
                            provedores
                        </div>
                    </router-link>
                    <router-link to="/accounting" class="link">
                        <div class="menu-item d-flex justify-content-between align-items-center">
                            <div><i class="icon-text icon-text fa-solid fa-hand-holding-dollar"></i>Contabilidad</div>
                            <i class="arrow fa-solid fa-angle-down"></i>
                        </div>
                    </router-link>
                </div>
            </nav>
        </div>
        <a class="btn-logout" href="/logout"
            ><i class="fa-solid fa-circle-xmark"></i>Cerrar sesión</a
        >
    </div>
</template>
<script>
  import { RouterLink } from "vue-router";
</script>

<style>
* {
    font-family: "Roboto";
}
p {
    margin-bottom: 0 !important;
}
h3 {
    margin-bottom: 0 !important;
    font-size: 16px !important;
    font-weight: 500;
}


.menu-side {
    background-color: #f4f6f8;
    width: 340px;
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
}
.menu-side .user img {
    width: 50px;
    height: 50px;
    margin-right: 12px;
}
.menu-side .user p {
    color: #96b6ff;
    font-size: 12px;
}
.menu-side .text-menu{
    font-size: 16px;
    padding: 26px 0px;
    color: #B9B9B9;
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
.menu-side .list-menu .link .menu-item .arrow {
    color: #1958f7;
    margin-right: 8px;
}
.opcion-menu .list-menu .link .menu-item:hover .arrow{
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
.opcion-menu .list-menu .link{
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
</style>
