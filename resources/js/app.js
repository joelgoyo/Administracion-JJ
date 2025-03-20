import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
// Importar solo componentes
import MenuComponent from './components/MenuComponent.vue';

// Importar los componentes para las rutas
import HomeComponent from './components/HomeComponent.vue';
import BillingComponent from './components/BillingComponent.vue'; 
import SupplierRegistrationComponent from './components/SupplierRegistrationComponent.vue'; 
import CustomerRegistrationComponent from './components/CustomerRegistrationComponent.vue'; 
import AccountingComponent from './components/AccountingComponent.vue';
import AddProductsComponent from './components/AddProductsComponent.vue'
import EditProductComponent from './components/EditProductComponent.vue'
import IncomeComponent from './components/IncomeComponent.vue'
import ExpensesComponent from './components/ExpensesComponent.vue'
import LoadingComponent from './components/LoadingComponent.vue';

// Definir las rutas
const routes = [
    { path: '/', component: HomeComponent},
    { path: '/billing', component: BillingComponent},
    { path: '/supplier-registration', component: SupplierRegistrationComponent},
    { path: '/customer-registration', component: CustomerRegistrationComponent},
    { path: '/accounting', component: AccountingComponent},
    { path: '/add-products', component: AddProductsComponent},
    { path: '/edit-products', component: EditProductComponent},
    { path: '/income', component: IncomeComponent},
    { path: '/expenses', component: ExpensesComponent},
];

// Crear la instancia del enrutador
const router = createRouter({
    history: createWebHistory(),  // Habilita rutas sin el #
    routes
});

// Crear la aplicación Vue y registrar los componentes globalmente
const app = createApp({});
app.component('home-component', HomeComponent);
app.component('menu-component', MenuComponent);
app.component('billing-component', BillingComponent);
app.component('supplier-registration-component', SupplierRegistrationComponent);
app.component('customer-registration-component', CustomerRegistrationComponent);
app.component('accounting-component', AccountingComponent);
app.component('add-products-component', AddProductsComponent);
app.component('edit-products-component', EditProductComponent);
app.component('income-component', IncomeComponent);
app.component('expenses-component', ExpensesComponent);
app.component('loading-component', LoadingComponent);

// Usar el enrutador en la aplicación Vue
app.use(router);

// Montar la aplicación
app.mount('#app');
