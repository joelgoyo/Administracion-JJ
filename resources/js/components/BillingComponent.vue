<template>
  <!-- HEADER -->
  <div class="container-content">
      <div class="content-title">
          <h2>Facturación</h2>
          <p>Factura electronica y impresion</p>
      </div>

      <!-- CLIENTES Y REGISTROS DE CLIENTES -->

      <div class="data-clients">
       <router-link to="/customer-registration"><button class="btn btn-danger">REGISTRAR NUEVO CLIENTE</button></router-link>

        <div class="inputs-content">
          <label for="">Datos del cliente</label>
           <div class="inputs">
            <input type="text" placeholder="C.I" class="form-control" />
            <input type="text" placeholder="Nombre y Apellido" class="form-control"/>
            <input type="text" placeholder="Dirección" class="form-control" />
            <input type="number" placeholder="Numero de telefono" class="form-control" />
           </div>
        </div>

        <div class="inputs-content">
          <label for="">Datos de la Factura</label>
           <div class="inputs">
            <input type="text" placeholder="Lugar de emisión" class="form-control" />
            <input type="text" placeholder="Fecha" class="form-control"/>
            <select name="" aria-placeholder="Tipo de entrega" class="form-control">
              <option value="" class="option-default" >Tipo de entrega</option>
              <option value="Entrega a domicilio">Entrega a domicilio</option>
              <option value="Retiro en tienda">Retiro en tienda</option>
            </select>
            <select name="" aria-placeholder="Tipo de pago" class="form-control">
              <option value="" class="option-default" >Tipo de pago</option>
              <option value="Entrega a domicilio">Transferencia</option>
              <option value="Retiro en tienda">Punto de venta</option>
              <option value="Retiro en tienda">Pago movil</option>
              <option value="Retiro en tienda">Efectivo</option>
            </select>
           </div>
           <div class="inputs">
            <input type="text" placeholder="Orden de compra" class="form-control" />
            <input type="text" placeholder="Nota de entrega" class="form-control"/>
            <input type="text" placeholder="De fecha" class="form-control" />
            <input type="number" placeholder="Numero de telefono" class="form-control" />
           </div>
        </div>
      </div>

      <div class="table-container">
            <button class="btn btn-primary">AGREGAR PRODUCTOS</button>
            <div class="content-table">
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th scope="col">Producto</th>
                            <th scope="col">Codigo</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Peso KG</th>
                            <th scope="col">Precio UNIT</th>
                            <th scope="col">Monto total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong> Nombre del Producto </strong></td>
                            <td>10001</td>
                            <td>
                                <div class="text-dark">
                                    <i class="fa-solid fa-box mr-1"></i>
                                    <strong>2</strong>
                                </div>
                            </td>
                            <td><strong>10 Kg</strong></td>
                            <td class="text-success"><strong>$20</strong></td>
                            <td class="text-success"><strong>$40</strong></td>
                        </tr>
                        <tr>
                            <td><strong> Nombre del Producto </strong></td>
                            <td>10001</td>
                            <td>
                                <div class="text-dark">
                                    <i class="fa-solid fa-box mr-1"></i>
                                    <strong>2</strong>
                                </div>
                            </td>
                            <td><strong>10 Kg</strong></td>
                            <td class="text-success"><strong>$20</strong></td>
                            <td class="text-success"><strong>$40</strong></td>
                        </tr>
                        <tr>
                            <td><strong> Nombre del Producto </strong></td>
                            <td>10001</td>
                            <td>
                                <div class="text-dark">
                                    <i class="fa-solid fa-box mr-1"></i>
                                    <strong>2</strong>
                                </div>
                            </td>
                            <td><strong>10 Kg</strong></td>
                            <td class="text-success"><strong>$20</strong></td>
                            <td class="text-success"><strong>$40</strong></td>
                        </tr>
                        <tr>
                            <td><strong> Nombre del Producto </strong></td>
                            <td>10001</td>
                            <td>
                                <div class="text-dark">
                                    <i class="fa-solid fa-box mr-1"></i>
                                    <strong>2</strong>
                                </div>
                            </td>
                            <td><strong>10 Kg</strong></td>
                            <td class="text-success"><strong>$20</strong></td>
                            <td class="text-success"><strong>$40</strong></td>
                        </tr>
                    </tbody>
                </table>

                <div class="total d-flex justify-content-end">
                    <h4>PRECIO TOTAL:  <strong class="text-success">40$</strong></h4>          
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn btn-primary mr-2">FACTURAR Y ENVIAR AL CORREO</button>
            <button class="btn btn-primary">IMPRIMIR FACTURA</button>
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
      };
  },
  components: {
      LoadingComponent,
  },

  mounted() {
    axios
      .get("/api/billing/productsClients")
      .then((response) => {
          this.productsClients = response.data.suppliers;
          console.log(this.productsClients);
      })
  },
  methods: {
      formatearFechaHora() {
          const ahora = new Date();
          const dia = ahora.getDate().toString().padStart(2, "0");
          const mes = (ahora.getMonth() + 1).toString().padStart(2, "0"); // Los meses comienzan desde 0
          const anio = ahora.getFullYear();
          const horas = ahora.getHours().toString().padStart(2, "0");
          const minutos = ahora.getMinutes().toString().padStart(2, "0");
          const segundos = ahora.getSeconds().toString().padStart(2, "0");
          this.fechaFormateada = `${dia}/${mes}/${anio} ${horas}:${minutos}:${segundos}`;
      },
  },
};
</script>