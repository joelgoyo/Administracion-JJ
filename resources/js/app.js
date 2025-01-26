import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

// Importar los componentes para las rutas
import ExampleComponent from './components/ExampleComponent.vue';
import NavComponent from './components/NavComponent.vue';
import BillingComponent from './components/BillingComponent.vue';
// Definir las rutas
const routes = [
    { path: '/', component: ExampleComponent },
    { path: '/nav', component: NavComponent }
];

// Crear la instancia del enrutador
const router = createRouter({
    history: createWebHistory(),  // Habilita rutas sin el #
    routes
});

// Crear la aplicación Vue y registrar los componentes globalmente
const app = createApp({});
app.component('example-component', ExampleComponent);
app.component('nav-component', NavComponent);
app.component('billing-component', BillingComponent);

// Usar el enrutador en la aplicación Vue
app.use(router);

// Montar la aplicación
app.mount('#app');
