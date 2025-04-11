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
                <p>C.I: {{ client_dni }}</p>
                <p>Numero de telefono: {{ clientPhone }}</p>
            </div>
        </div>

        <div class="data-clients">
            <router-link to="/customer-registration">
                <button class="btn btn-danger">REGISTRAR NUEVO CLIENTE</button>
            </router-link>
            <div class="inputs-content">
                <label for="">Datos del cliente</label>
                <div class="inputs">
                    <input
                        type="text"
                        placeholder="C.I"
                        class="form-control"
                        @input="filterClients"
                        v-model="client_dni"
                    />
                    <input
                        type="text"
                        placeholder="id de cliente"
                        class="form-control d-none"
                        v-model="client_id"
                        readonly
                    />
                    <input
                        type="text"
                        placeholder="Nombre y Apellido"
                        class="form-control"
                        v-model="clientName"
                        readonly
                    />
                    <input
                        type="text"
                        placeholder="Dirección"
                        class="form-control"
                        v-model="clientAddress"
                        readonly
                    />
                    <input
                        type="number"
                        placeholder="Numero de telefono"
                        class="form-control"
                        v-model="clientPhone"
                        readonly
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
                    <select class="form-control" v-model="billing.PlaceIssue">
                        <option value="" disabled>Lugar de emisión</option>
                        <option value="San Mateo">Bolívar (San Mateo)</option>
                        <option value="Camatagua">Camatagua (Camatagua)</option>
                        <option value="Santa Rita">
                            Francisco Linares Alcántara (Santa Rita)
                        </option>
                        <option value="Maracay">Girardot (Maracay)</option>
                        <option value="Santa Cruz">
                            José Ángel Lamas (Santa Cruz)
                        </option>
                        <option value="La Victoria">
                            José Félix Ribas (La Victoria)
                        </option>
                        <option value="El consejo">
                            José Rafael Revenga (El Consejo)
                        </option>
                        <option value="Palo negro">
                            Libertador (Palo Negro)
                        </option>
                        <option value="El limon">
                            Mario Briceño Iragorry (El Limón)
                        </option>
                        <option value="Ocumare de la Costa de Oro">
                            Ocumare de la Costa de Oro (Ocumare de la Costa)
                        </option>
                        <option value="San Casimiro">
                            San Casimiro (San Casimiro)
                        </option>
                        <option value="San Sebastián">
                            San Sebastián (San Sebastián)
                        </option>
                        <option value="Turmero">
                            Santiago Mariño (Turmero)
                        </option>
                        <option value="Las tejerias">
                            Santos Michelena (Las Tejerías)
                        </option>
                        <option value="Sucre">Sucre (Cagua)</option>
                        <option value="Tovar">Tovar (Colonia Tovar)</option>
                        <option value="Urdaneta">Urdaneta (Barbacoas)</option>
                        <option value="Zamora">Zamora (Villa de Cura)</option>
                    </select>
                    <select
                        name=""
                        aria-placeholder="Tipo de entrega"
                        class="form-control"
                        v-model="billing.typeDelivery"
                    >
                        <option value="" class="option-default">
                            Tipo de entrega
                        </option>
                        <option value="home">Entrega a domicilio</option>
                        <option value="p2p">Retiro en tienda</option>
                        <option value="other">Otro</option>
                    </select>
                    <select
                        name=""
                        aria-placeholder="Tipo de pago"
                        class="form-control"
                        v-model="billing.typePayment"
                    >
                        <option value="" class="option-default">
                            Tipo de pago
                        </option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Punto de venta">Punto de venta</option>
                        <option value="Transferencia">Transferencia</option>
                        <option value="Pago movil">Pago movil</option>
                    </select>
                </div>
                <div class="inputs">
                    <div class="input-order d-flex align-items-center">
                        <input
                            type="text"
                            placeholder="Orden de compra"
                            class="form-control mr-2"
                            v-model="billing.order"
                            readonly
                        />
                        <button
                            class="btn-genrate-order btn btn-outline-secondary"
                            @click="generateOrderNumber"
                        >
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                        </button>
                    </div>

                    <select class="form-control" v-model="billing.bank">
                        <option value="" class="option-default">
                            Seleccione un Banco
                        </option>
                        <option value="EFECTIVO">EFECTIVO</option>
                        <option value="BANCO DE VENEZUELA">
                            BANCO DE VENEZUELA
                        </option>
                        <option value="100% BANCO">100% BANCO</option>
                        <option value="BANCAMIGA BANCO MICROFINANCIERO C.A.">
                            BANCAMIGA BANCO MICROFINANCIERO C.A.
                        </option>
                        <option value="BANCARIBE">BANCARIBE</option>
                        <option value="BANCO ACTIVO">BANCO ACTIVO</option>
                        <option value="BANCO AGRICOLA DE VENEZUELA">
                            BANCO AGRICOLA DE VENEZUELA
                        </option>
                        <option value="BANCO BICENTENARIO DEL PUEBLO">
                            BANCO BICENTENARIO DEL PUEBLO
                        </option>
                        <option value="BANCO CARONI">BANCO CARONI</option>
                        <option value="BANCO DEL TESORO">
                            BANCO DEL TESORO
                        </option>
                        <option value="BANCO EXTERIOR">BANCO EXTERIOR</option>
                        <option value="BANCO FONDO COMUN">
                            BANCO FONDO COMUN
                        </option>
                        <option value="BANCO INTERNACIONAL DE DESARROLLO">
                            BANCO INTERNACIONAL DE DESARROLLO
                        </option>
                        <option value="BANCO MERCANTIL">BANCO MERCANTIL</option>
                        <option value="BANCO NACIONAL DE CREDITO">
                            BANCO NACIONAL DE CREDITO
                        </option>
                        <option value="BANCO PLAZA">BANCO PLAZA</option>
                        <option value="BANCO SOFITASA">BANCO SOFITASA</option>
                        <option value="BANCO VENEZOLANO DE CREDITO">
                            BANCO VENEZOLANO DE CREDITO
                        </option>
                        <option value="BANCRECER">BANCRECER</option>
                        <option value="BANESCO">BANESCO</option>
                        <option value="BANFANB">BANFANB</option>
                        <option value="BANGENTE">BANGENTE</option>
                        <option value="BANPLUS">BANPLUS</option>
                        <option value="BBVA PROVINCIAL">BBVA PROVINCIAL</option>
                        <option value="DELSUR BANCO UNIVERSAL">
                            DELSUR BANCO UNIVERSAL
                        </option>
                        <option value="MI BANCO">MI BANCO</option>
                        <option
                            value="N58 BANCO DIGITAL BANCO MICROFINANCIERO S.A."
                        >
                            N58 BANCO DIGITAL BANCO MICROFINANCIERO S.A.
                        </option>
                    </select>

                    <select class="form-control">
                        <option value="" class="option-default">
                            Seleccione una tasa
                        </option>
                        <option value="1">
                            Promedio - 1$ = {{ dolarPromedio }}Bs
                        </option>
                        <option value="2">
                            BCV - 1$ = {{ dolarBcv.price }}$
                        </option>
                    </select>
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
                            <th scope="col">#</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Codigo</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Peso KG</th>
                            <th scope="col">Precio UNIT</th>
                            <th scope="col">Monto total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(item, index) in selectedProducts"
                            :key="item.product.id"
                        >
                            <td>
                                <i
                                    title="Eliminar"
                                    class="fa-solid fa-trash"
                                    @click="removeProduct(index)"
                                ></i>
                            </td>
                            <td>{{ item.product.id }}</td>
                            <td>
                                <strong>{{ item.product.name }}</strong>
                            </td>
                            <td>{{ item.product.code }}</td>
                            <td>
                                <div class="text-dark">
                                    <i class="fa-solid fa-box mr-1"></i>
                                    <strong>{{ item.product.stock }}</strong>
                                </div>
                            </td>

                            <td>
                                <div class="text-danger">
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
                        Dolar promedio:
                        <strong class="text-success"
                            >{{ calculateTotal }}$</strong
                        >
                    </h4>
                    <h4>
                        Precio Total:
                        <strong class="text-success"
                            >{{ calculateTotal * dolarPromedio }}Bs</strong
                        >
                    </h4>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn btn-primary mr-2" @click="saveBilling">
                FACTURAR Y ENVIAR AL CORREO (Simulado en Consola)
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
                                <th scope="col">Stock</th>
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
                                            :id="'product-' + product.id"
                                            v-model="product.selected"
                                        />
                                        <label
                                            class="form-check-label"
                                            :for="'product-' + product.id"
                                        ></label>
                                    </div>
                                </td>
                                <td>
                                    <strong>{{ product.name }}</strong>
                                </td>
                                <td>{{ product.code }}</td>
                                <td>
                                    <div class="text-dark">
                                        <i class="fa-solid fa-box mr-1"></i>
                                        <strong>{{ product.stock }}</strong>
                                    </div>
                                </td>
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
import Swal from "sweetalert2";
import { jsPDF } from "jspdf";
import autoTable from "jspdf-autotable";
import JsBarcode from "jsbarcode";

export default {
    data() {
        return {
            fechaFormateada: "",
            isLoading: true,
            data: null,
            listClients: [],
            filteredClients: [],
            client_id: "",
            client_dni: "",
            clientName: "",
            clientAddress: "",
            clientPhone: "",
            products: [],
            showProductModal: false,
            productFilter: "",
            selectedProducts: [],
            dolarBcv: "",
            dolarParalelo: "",
            dolarPromedio: "",
            billing: {
                client_id: null,
                PlaceIssue: "",
                date: "",
                typeDelivery: "",
                typePayment: "",
                bank: "",
                deliveryNote: "",
                deliveryDate: "",
                status: "pending",
                order: "",
                amount: "",
                amount_bs: "",
                created_at: "",
            },
            newlyCreatedBillingId: null,
            billingProducts: {
                product_id: "",
                bill_id: "",
            },
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
        generateOrderNumber() {
            const timestamp = Date.now().toString(36);
            const randomPart = Math.random().toString(36).substring(2, 8);
            this.billing.order = `ORD-${timestamp}-${randomPart.toUpperCase()}`;
        },

        formatDate(dateString) {
            if (!dateString) return "Fecha no disponible";
            let date;
            if (dateString.includes("-") && !dateString.includes("T")) {
                const [day, month, year] = dateString.split("-");
                date = new Date(`${year}-${month}-${day}`);
            } else {
                date = new Date(dateString);
            }
            if (isNaN(date.getTime())) return "Fecha inválida";
            return date.toLocaleDateString("es-ES", {
                day: "2-digit",
                month: "2-digit",
                year: "numeric",
            });
        },

        printInvoice() {
            const pdf = new jsPDF();
            const pageWidth = pdf.internal.pageSize.getWidth();
            const margin = 15;
            const defaultFont = "helvetica";

            const marginTop = 15;
            const lineHeight = 5;
            let y = marginTop;
            let startCompanyInfoY = y;
            const halfPageWidth = pageWidth / 2;
            const tableWidthPercentage = 0.45; // 45% de ancho para cada tabla
            const tableWidth = pageWidth * tableWidthPercentage;
            const spacing = 10; // Espacio entre las tablas

            // Datos de la empresa
            const companyName = "RADIADORES MARACAY JPC, C.A.";
            const companyRif = "J-00000000-0"; // Reemplaza con el RIF real
            const companyAddress =
                "Av. Principal, Zona Industrial, Maracay, Edo. Aragua"; // Reemplaza con la dirección real
            const companyPhone = "+58 123-4567890"; // Reemplaza con el teléfono real
            const instagramQRPath = "/img/radiadores-maracay-qr.png"; // Reemplaza con la ruta real de tu QR

            // Dimensiones del logo
            const logoWidth = 40;
            const logoHeight = 30;
            const logoX = margin; // Colocar el logo a la izquierda

            // Dimensiones del QR
            const qrWidth = 30;
            const qrHeight = 30;
            const qrX = pageWidth - margin - qrWidth; // Colocar el QR en la esquina superior derecha

            // Posición inicial para el texto de la empresa (ajustar según el logo)
            let companyInfoX = margin + logoWidth + 10;

            // Función para añadir texto alineado a la izquierda

            const addLeftText = (text, x, currentY, style = {}) => {
                pdf.setFontSize(style.fontSize || 10);
                pdf.setFont(
                    style.font || defaultFont,
                    style.fontStyle || "normal"
                );

                // Aquí es donde se aplica el color correctamente
                if (style.textColor) {
                    pdf.setTextColor(...style.textColor); // <-- importante
                } else {
                    pdf.setTextColor(0, 0, 0); // Color por defecto (negro)
                }

                pdf.text(text, x, currentY);
                return currentY + (style.lineHeight || lineHeight);
            };

            // Agregar logo
            try {
                pdf.addImage(
                    "/img/radiadoresMaracayLogo.jpg",
                    "jpg",
                    logoX,
                    startCompanyInfoY + (4 * lineHeight) / 2 - logoHeight / 2,
                    logoWidth,
                    logoHeight
                );
            } catch (error) {
                console.error("Error al cargar el logo:", error);
                companyInfoX = margin;
            }

            // Titular
            y = addLeftText(companyName, 58, 18, {
                font: "helvetica",
                fontSize: 17,
                fontWeight: "bold",
                lineHeight: 7,
                textColor: [128, 0, 32],
            });

            // RIF
            y = addLeftText(`RIF: ${companyRif}`, 58, y, {
                font: "helvetica",
                fontSize: 12,
                lineHeight: 5,
            });

            // Información de la empresa
            y = addLeftText(companyAddress, 58, y, {
                font: "helvetica",
                fontSize: 10,
            });
            y = addLeftText(`Teléfono: ${companyPhone}`, 58, y, {
                font: "helvetica",
                fontSize: 10,
            });

            let endCompanyInfoY = y;
            const companyInfoHeight = endCompanyInfoY - startCompanyInfoY;
            const qrY = 12 + companyInfoHeight / 2 - qrHeight / 2;

            // Agregar QR de Instagram
            try {
                pdf.addImage(
                    "/img/radiadores-maracay-qr.png",
                    "png",
                    qrX,
                    qrY,
                    qrWidth,
                    qrHeight
                );
            } catch (error) {
                console.error("Error al cargar el QR de Instagram:", error);
            }

            y += 15; // Espacio después de la información de la empresa

            // Tabla de Información del Cliente (Izquierda)
            pdf.setFontSize(12);
            pdf.setFont("helvetica", "bold");

            const customerInfo = [
                [`Nombre:`, this.clientName],
                [`C.I./RIF:`, this.client_dni],
                [`Dirección:`, this.clientAddress],
                [`Teléfono:`, this.clientPhone],
            ];

            autoTable(pdf, {
                body: customerInfo.map((row) => ({
                    ...row,
                    columnStyles: { 0: { fontStyle: "bold" } },
                })),
                columns: [
                    { header: "Información del Cliente", dataKey: "0" },
                    { header: "Detalle", dataKey: "1" },
                ],
                startY: y,
                startX: pageWidth / 2 + spacing, // Iniciar en la mitad derecha
                tableLineWidth: 0.2,
                tableLineColor: [0, 0, 0],
                fillColor: [128, 0, 32],
                columnStyles: {
                    0: {
                        fontStyle: "bold",
                        fillColor: [240, 240, 240],
                        halign: "left",
                    }, // Alinear la primera columna a la derecha
                    1: { halign: "left" }, // Alinear la segunda columna a la derecha
                },
                bodyStyles: { halign: "left" }, // Alinear el contenido del cuerpo a la derecha
                headStyles: {
                    fillColor: [128, 0, 32], // Color vinotinto
                    textColor: [255, 255, 255], // Texto blanco
                    fontStyle: "bold",
                },
                tableWidth: 86,
                margin: { left: halfPageWidth + spacing / 2 }, // Margen izquierdo para separar
            });
            // Tabla de Información de la Factura (Derecha)
            pdf.setFontSize(12);
            pdf.setFont("helvetica", "bold");
            const invoiceInfo = [
                [`Orden #:`, this.billing.order],
                [`Fecha:`, this.formatDate(this.billing.created_at)],
                [`Lugar de Emisión:`, this.billing.PlaceIssue],
                [`Tipo de Pago:`, this.billing.typePayment],
            ];

            autoTable(pdf, {
                body: invoiceInfo.map((row) => ({
                    ...row,
                    columnStyles: { 0: { fontStyle: "bold" } },
                })),
                columns: [
                    { header: "Información de la Factura", dataKey: "0" },
                    { header: "Detalle", dataKey: "1" },
                ],
                startY: y, // Misma altura que la tabla del cliente
                startX: halfPageWidth + spacing, // Iniciar después de la primera tabla y el espacio
                tableLineWidth: 0.2,
                tableLineColor: [0, 0, 0],
                columnStyles: {
                    0: {
                        fontStyle: "bold",
                        fillColor: [240, 240, 240],
                        halign: "left",
                    },
                    1: { halign: "left" },
                },
                bodyStyles: { halign: "left" },
                headStyles: {
                    fillColor: [128, 0, 32], // Color vinotinto
                    textColor: [255, 255, 255], // Texto blanco
                    fontStyle: "bold",
                },
                tableWidth: tableWidth,
            });

            y = pdf.lastAutoTable.finalY + 10; // Actualizar y después de la segunda tabla
            pdf.setFontSize(12);
            pdf.setFont("helvetica", "bold");
            y += lineHeight + 2;

            const head = [
                [
                    "Cantidad",
                    "Concepto o descripcion",
                    "Código",
                    "Precio Unitario ($)",
                    "Monto Total ($)",
                ],
            ];
            const body = this.selectedProducts.map((item) => [
                item.quantity,
                item.product.name,
                item.product.code,
                Number(item.product.priceUnit).toFixed(2),
                (Number(item.product.priceUnit) * item.quantity).toFixed(2),
            ]);

            autoTable(pdf, {
                head: head,
                body: body,
                startX: margin,
                startY: 95,
                tableLineWidth: 0.2,
                tableLineColor: [0, 0, 0],
                headStyles: {
                    fillColor: [128, 0, 32], // Color vinotinto
                    textColor: [255, 255, 255], // Texto blanco
                    fontStyle: "bold",
                },
                columnStyles: { 4: { halign: "right" } },
                didDrawPage: (data) => {
                    y = data.cursor.y + lineHeight;
                },
            });

            y += 5;

            // Totales
            pdf.setFontSize(24);
            pdf.setFont("helvetica", "bold");
            const totalsX = pageWidth - margin - 34; // Ajustar el valor para dejar espacio para los bordes
            const totalsYStart = y;
            const totalsWidth = 28; // Ancho del bloque de totales
            const totalsHeight = 4 * 2 + 7; // Altura del bloque de totales (2 líneas + espacio para bordes)

            pdf.rect(
                totalsX - 7,
                totalsYStart - 6,
                totalsWidth + 14,
                totalsHeight,
                "D"
            ); // Dibujar el rectángulo alrededor de los totales

            addLeftText(
                `Subtotal: ${this.calculateTotal.toFixed(2)}$`,
                totalsX,
                y,
                {
                    font: "helvetica",
                    fontWeight: "bold",
                    fontSize: 12,
                    margin: { bottom: 5 },
                }
            );
            y += lineHeight;
            addLeftText(
                `Total: ${(this.calculateTotal * this.dolarPromedio).toFixed(
                    2
                )}Bs`,
                totalsX,
                y,
                {
                    font: "helvetica",
                    fontWeight: "bold",
                    fontSize: 12,
                }
            );

            const barcodeValue = this.billing.order || "000000";
            const canvas = document.createElement("canvas");

            JsBarcode(canvas, barcodeValue, {
                format: "CODE128",
                displayValue: true,
                fontSize: 14,
                height: 40,
                width: 2,
            });

            const barcodeImg = canvas.toDataURL("image/png");
            const barcodeWidth = 50;
            const barcodeHeight = 30;
            const barcodeX = (pageWidth - barcodeWidth) / 2;
            const barcodeY = y + 10;

            pdf.addImage(
                barcodeImg,
                "PNG",
                barcodeX,
                barcodeY,
                barcodeWidth,
                barcodeHeight
            );

            pdf.save(`factura_${this.billing.order || "sin_orden"}.pdf`);
        },

        saveBilling() {
            if (
                this.selectedProducts.length === 0 ||
                !this.client_id ||
                !this.billing.PlaceIssue ||
                !this.billing.typePayment ||
                !this.billing.bank
            ) {
                let message = "";
                if (this.selectedProducts.length === 0 && !this.client_id) {
                    message =
                        "No has agregado productos ni seleccionado un cliente.";
                } else if (this.selectedProducts.length === 0) {
                    message = "No tienes productos agregados.";
                } else if (!this.client_id) {
                    message = "No has seleccionado un cliente.";
                } else if (!this.billing.PlaceIssue) {
                    message = "No has seleccionado el lugar de emisión.";
                } else if (!this.billing.typePayment) {
                    message = "No has seleccionado el tipo de pago.";
                } else {
                    message = "No has seleccionado un banco.";
                }
                Swal.fire({
                    icon: "error",
                    title: "Datos incompletos",
                    text:
                        message +
                        " Por favor completa los datos para crear la factura.",
                    confirmButtonText: "Aceptar",
                });
                return;
            }

            this.billing.client_id = this.client_id || null;
            this.billing.amount = this.calculateTotal;
            this.billing.amount_bs = this.billing.amount * this.dolarPromedio;

            this.generateOrderNumber();

            axios
                .post("/api/billing/save", {
                    ...this.billing,
                })
                .then((response) => {
                    this.newlyCreatedBillingId = response.data.billing.id;
                    this.billing.created_at =
                        response.data.billing.created_at ||
                        new Date().toISOString();

                    this.saveBillProducts();
                    this.printInvoice();
                    this.resetBillingForm();

                    Swal.fire({
                        title: "Exitoso",
                        text: "Factura registrada correctamente",
                        icon: "success",
                        confirmButtonText: "Aceptar",
                    });
                })
                .catch((error) => {
                    console.error("Error al guardar la factura:", error);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "No se ha podido registrar La factura",
                    });
                });
        },

        saveBillProducts() {
            if (
                this.newlyCreatedBillingId &&
                this.selectedProducts.length > 0
            ) {
                const billProductsData = this.selectedProducts.map((item) => ({
                    bill_id: this.newlyCreatedBillingId,
                    product_id: item.product.id,
                    quantity: item.quantity, // Incluir la cantidad para restar del stock
                }));

                axios
                    .post("/api/billing/save-billProducts", {
                        products: billProductsData,
                    })
                    .then((response) => {
                        console.log(
                            "Productos de la factura guardados exitosamente:",
                            response.data
                        );

                        billProductsData.forEach((item) => {
                            axios
                                .post("/api/billing/updateStock", {
                                    product_id: item.product_id,
                                    quantity: item.quantity,
                                })
                                .then(() => {
                                    // Actualizar el stock en el frontend
                                    const product = this.products.find(
                                        (p) => p.id === item.product_id
                                    );
                                    if (product) {
                                        product.stock -= item.quantity;
                                    }
                                })
                                .catch((error) => {
                                    console.error(
                                        "Error al actualizar el stock:",
                                        error
                                    );
                                    Swal.fire({
                                        icon: "error",
                                        title: "Error",
                                        text: `Error al actualizar el stock del producto ID ${item.product_id}.`,
                                    });
                                });
                        });

                        this.billingProducts = []; // Limpiar el array después de guardar
                    })
                    .catch((error) => {
                        console.error(
                            "Error al guardar los productos de la factura:",
                            error
                        );
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Error al guardar los productos de la factura.",
                        });
                    });
            } else {
                console.warn(
                    "No se puede guardar los productos: ID de factura no disponible o no hay productos seleccionados."
                );
            }
        },

        resetBillingForm() {
            this.billing = {
                client_id: null,
                PlaceIssue: "",
                date: "",
                typeDelivery: "",
                typePayment: "",
                bank: "",
                deliveryNote: "",
                deliveryDate: "",
                amount: 0,
                amount_bs: 0,
                product_ids: [],
            };
            this.client_id = "";
            this.client_dni = "";
            this.clientName = "";
            this.clientAddress = "";
            this.clientPhone = "";
            this.selectedProducts = [];
            this.newlyCreatedBillingId = null;
            this.billingProducts = [];
        },

        removeProduct(index) {
            this.selectedProducts.splice(index, 1);
        },

        filterClients() {
            if (this.client_dni) {
                this.filteredClients = this.listClients.filter((client) =>
                    client.dni.includes(this.client_dni)
                );
            } else {
                this.filteredClients = [];
            }
        },

        selectClient(client) {
            this.client_id = client.id;
            this.client_dni = client.dni;
            this.clientName = `${client.name} ${client.last_name}`;
            this.clientAddress = client.address;
            this.clientPhone = client.phone;
            this.filteredClients = []; // Limpia la lista de sugerencias después de seleccionar
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
                    product.stock = product.stock || 0;
                });
            });
        },

        addSelectedProductsToInvoice() {
            const selected = this.products.filter(
                (product) => product.selected
            );

            // Validar stock antes de agregar
            let hasError = false;
            selected.forEach((product) => {
                if (product.modalQuantity > product.stock) {
                    hasError = true;
                    Swal.fire({
                        icon: "error",
                        title: "Stock insuficiente",
                        text: `No hay suficiente stock para ${product.name}. Disponible: ${product.stock} unidades.`,
                    });
                }
            });

            if (hasError) return; // Detener si hay error de stock

            // Agregar productos a la factura
            selected.forEach((product) => {
                const existingProduct = this.selectedProducts.find(
                    (item) => item.product.id === product.id
                );
                if (existingProduct) {
                    existingProduct.quantity += product.modalQuantity;
                } else {
                    this.selectedProducts.push({
                        product: product,
                        quantity: product.modalQuantity,
                    });
                }
                product.selected = false;
                product.modalQuantity = 1;
            });

            this.showProductModal = false;
        },
    },
};
</script>
<style scoped>
/* Estilos existentes (opcional) */
.select-client {
    cursor: pointer;
    padding: 5px;
    border: 1px solid #ccc;
    margin-bottom: 2px;
    background-color: #f9f9f9;
}

.select-client:hover {
    background-color: #eee;
}
</style>
<style>
.input-order {
    width: 100%;
    background: #e9ecef;
    padding: 0px 11px;
    border-radius: 10px;
}
.input-order input {
    padding: 0px !important;
}
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
.total {
    flex-direction: column;
    justify-content: flex-end !important;
}
.btn-genrate-order {
    padding: 6px 6px;
    line-height: 8px;
    color: #c500c5;
    border: 1px solid #c500c5;
}
.btn-genrate-order:hover {
    background-color: #c500c5;
    border: 1px solid #c500c5;
}
</style>
