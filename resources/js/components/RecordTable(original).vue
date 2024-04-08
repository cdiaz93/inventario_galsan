<template>

    <div class="mx-3">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body custom-scroll" ref="tableContainer">
                        <h2 class="text-center m-3 mb-4">
                            <div class="row">
                            <div class="col-md-3 text-left">
                                <!-- <button type="button" class="btn btn-outline-dark btn-sm"    ref="btnImportar"> Importar Excel </button> -->
                                <button type="button" class="btn btn-outline-dark btn-sm" ref="btnImportar" data-toggle="modal" data-target="#myModal">
                                    Importar Excel
                                </button>
                                <button type="button" class="btn btn-outline-success btn-sm" ref="btnNuevo" @click="articuloNuevoFormulario()"> Nuevo</button>
                                <button type="button" class="btn btn-outline-success btn-sm" ref="btnGuardar" @click="guardarInventario()"> Guardar</button>

                            </div>
                            <div class="col-md-6">
                                Inventario de Galsan repuestos
                            </div>
                        </div>

                        </h2>

                        <div id="tableFixHead" class="tableFixHead" ref="tableFixHead">
                        <table class="table table-striped table-smxd table-fixed"  >
                            <thead>
                                <tr>
                                <th scope="col" class="text-center sticky-column"> Acciones </th>
                                <th scope="col" class="text-center"> ID </th>
                                <th scope="col"> Codigo interno </th>
                                <th scope="col"> Referencia fabrica </th>
                                <th scope="col"> Referencia articulo </th>
                                <th scope="col"> Numero Serial </th>
                                <th scope="col"> Segemento </th>
                                <th scope="col"> Lineas </th>
                                <th scope="col"> Marca </th>
                                <th scope="col"> Tipo marca </th>
                                <th scope="col"> Descripcion </th>
                                <th scope="col"> Existencias </th>
                                <th scope="col"> Ubicación en bodega </th>
                                <th scope="col"> Unidad de medida </th>
                                <th scope="col"> Costo </th>
                                <th scope="col"> Precio de venta </th>
                                <th scope="col">Usuario</th>
                                <th scope="col">Contador</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr  style="background-color: #1b6499a1;" v-show="mostarNuevoDato">
                                    <td class="sticky-column" style="display:table-cell; text-align: center;">
                                        <button @click="guardarInventario" class="btn btn-sm btn-success">Guardar</button>
                                    </td>
                                    <td><input type="text" v-model="nuevoDato.id" placeholder="ID"></td>
                                    <td><input type="text" v-model="nuevoDato.codigo_interno" placeholder="Codigo interno"></td>
                                    <td><input type="text" v-model="nuevoDato.referencia_fabrica" placeholder="Referencia fabrica"></td>
                                    <td><input type="text" v-model="nuevoDato.referencia_articulo" placeholder="Referencia articulo"></td>
                                    <td><input type="text" v-model="nuevoDato.serial" placeholder="Serial"></td>
                                    <td><input type="text" v-model="nuevoDato.segemento" placeholder="Segemento"></td>
                                    <td><input type="text" v-model="nuevoDato.lineas" placeholder="Linea"></td>
                                    <td><input type="text" v-model="nuevoDato.marca" placeholder="Marca"></td>
                                    <td><input type="text" v-model="nuevoDato.tipo_marca" placeholder="Tipo de marca"></td>
                                    <td><input type="text" v-model="nuevoDato.descripcion" placeholder="Descripcion"></td>
                                    <td><input type="text" v-model="nuevoDato.existencias" placeholder="Existencias"></td>
                                    <td><input type="text" v-model="nuevoDato.ubicacion_bodega" placeholder="Ubicacion en bodega"></td>
                                    <td><input type="text" v-model="nuevoDato.unidad_medida" placeholder="Unidad de medida"></td>
                                    <td><input type="text" v-model="nuevoDato.costo" placeholder="Costo"></td>
                                    <td><input type="text" v-model="nuevoDato.precio_venta" placeholder="Precio de venta"></td>
                                    <td><input type="text" v-model="nuevoDato.usuario" placeholder="Usuario"></td>
                                    <td><input type="text" v-model="nuevoDato.contador" placeholder="Contador"></td>
                                </tr>

                                <tr v-for="(inventario, index) in inventarios" :key="index">
                                    <td class="justify-content-center sticky-column" :style= "{width:'180px', display:'flex'}">
                                        <div class="d-inline">
                                        <button class="btn btn-sm mx-1" :class="{'btn-primary': !inventario.editing, 'btn-success': inventario.editing}"   @click="toggleEdit(inventario)" data-bs-toggle="tooltip" data-bs-placement="top"  :title="inventario.editing ? 'Guardar' : 'Editar'" >
                                            <span v-if="!inventario.editing">
                                                <i class="fas fa-edit fa-lg"></i>
                                            </span>
                                            <span v-else>
                                                <i class="fas fa-save fa-lg"></i>
                                            </span>
                                        </button>
                                        <button class="btn btn-sm btn-danger mx-1"  v-if="inventario.editing"  @click="cancelEdit(inventario)" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar">
                                            <i class="bi bi-x-octagon-fill fa-lg"></i>
                                        </button>
                                        </div>
                                    </td>

                                    <td class="text-center"> {{ inventario.id }}</td>

                                    <td v-if="!inventario.editing"> <input type="text" class="form-control form-control-sm input-ro" v-model="inventario.codigo_interno" disabled> </td>
                                    <td v-else> <input type="text" class="form-control form-control-sm" v-model="inventario.codigo_interno"> </td>

                                    <td v-if="!inventario.editing"> <input type="text" class="form-control form-control-sm input-ro" v-model="inventario.referencia_fabrica" disabled> </td>
                                    <td v-else> <input type="text" class="form-control form-control-sm" v-model="inventario.referencia_fabrica"> </td>

                                    <td v-if="!inventario.editing"> <input type="text" class="form-control form-control-sm input-ro" v-model="inventario.referencia_articulo" disabled> </td>
                                    <td v-else> <input type="text" class="form-control form-control-sm" v-model="inventario.referencia_articulo"> </td>

                                    <td v-if="!inventario.editing"><input type="text" class="form-control form-control-sm input-ro" v-model="inventario.serial" disabled> </td>
                                    <td v-else> <input type="text" class="form-control form-control-sm" v-model="inventario.serial"> </td>

                                    <td v-if="!inventario.editing"> <input type="text" class="form-control form-control-sm input-ro" v-model="inventario.segemento" disabled ref="inputField" @input="adjustInputWidth"> </td>
                                    <td v-else> <input type="text" class="form-control form-control-sm" v-model="inventario.segemento"> </td>

                                    <td v-if="!inventario.editing"> <input type="text" class="form-control form-control-sm input-ro" v-model="inventario.lineas" disabled> </td>
                                    <td v-else> <input type="text" class="form-control form-control-sm" v-model="inventario.lineas"> </td>

                                    <td v-if="!inventario.editing"> <input type="text" class="form-control form-control-sm input-ro" v-model="inventario.marca" disabled> </td>
                                    <td v-else> <input type="text" class="form-control form-control-sm" v-model="inventario.marca"> </td>

                                    <td v-if="!inventario.editing"> <input type="text" class="form-control form-control-sm input-ro" v-model="inventario.tipo_marca" disabled> </td>
                                    <td v-else> <input type="text" class="form-control form-control-sm" v-model="inventario.tipo_marca"> </td>

                                    <td v-if="!inventario.editing"> <input type="text" class="form-control form-control-sm input-ro" v-model="inventario.descripcion" disabled> </td>
                                    <td v-else> <input type="text" class="form-control form-control-sm" v-model="inventario.descripcion"> </td>

                                    <td v-if="!inventario.editing"> <input type="text" class="form-control form-control-sm input-ro" v-model="inventario.existencias" disabled> </td>
                                    <td v-else> <input type="text" class="form-control form-control-sm" v-model="inventario.existencias"> </td>

                                    <td v-if="!inventario.editing"> <input type="text" class="form-control form-control-sm input-ro" v-model="inventario.ubicacion_bodega" disabled> </td>
                                    <td v-else> <input type="text" class="form-control form-control-sm" v-model="inventario.ubicacion_bodega"> </td>

                                    <td v-if="!inventario.editing"> <input type="text" class="form-control form-control-sm input-ro" v-model="inventario.unidad_medida" disabled> </td>
                                    <td v-else> <input type="text" class="form-control form-control-sm" v-model="inventario.unidad_medida"> </td>

                                    <td v-if="!inventario.editing"> <input type="text" class="form-control form-control-sm input-ro" v-model="inventario.costo" disabled> </td>
                                    <td v-else> <input type="text" class="form-control form-control-sm" v-model="inventario.costo"> </td>

                                    <td v-if="!inventario.editing"> <input type="text" class="form-control form-control-sm input-ro" v-model="inventario.precio_venta" disabled> </td>
                                    <td v-else> <input type="text" class="form-control form-control-sm" v-model="inventario.precio_venta"> </td>

                                    <td v-if="!inventario.editing"> <input type="text" class="form-control form-control-sm input-ro" v-model="inventario.usuario" disabled>  </td>
                                    <td v-else> <input type="text" class="form-control form-control-sm" v-model="inventario.usuario"> </td>

                                    <td v-if="!inventario.editing"> <input type="text" class="form-control form-control-sm input-ro" v-model="inventario.contador" disabled> </td>
                                    <td v-else> <input type="text" class="form-control form-control-sm" v-model="inventario.contador"> </td>

                                </tr>
                            </tbody>
                        </table>
                        </div>

                        <button class="scroll-button bottom-right"  v-show="showScrollRightButton"  @mouseover="scrollTableRight">
                            <i class="fa-sharp fa-solid fa-circle-right fa-xl fa-beat" style="color: #aea7a7;"></i>
                        </button>
                        <button class="scroll-button bottom-left"   v-show="showScrollLeftButton"    @mouseover="scrollTableLeft">
                            <i class="fa-sharp fa-solid fa-circle-left fa-xl fa-beat" style="color: #aea7a7;"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>



        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" v-if="showModal">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Importar Inventario </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- <form enctype="multipart/form-data"> -->
                            <div class="form-group">
                                <label for="exampleFormControlFile1"> Seleccione el archivo Excel que va a cargar </label>
                                <input id="excel_inventory" name="excel_inventory[]" type="file" class="file" multiple data-show-upload="false" ref="fileInput">
                            </div>

                            <div class="form-group mt-5">
                                <button @click="cargarExcel" class="btn btn-primary btn-block"> Cargar </button>
                            </div>

                        <!-- </form> -->
                    </div>
                    <div class="modal-footer">
                        <button id="close-modal" type="button" class="btn btn-secondary" data-dismiss="modal"> Cerrar ventana</button>
                    </div>
                </div>
            </div>
        </div>


    </div>

</template>

<script>

    //Fonat awesome 5 Icons
    import '@fortawesome/fontawesome-free/css/all.css';

    //Bootstrap FileInput Krajee
    import 'bootstrap-fileinput/css/fileinput.min.css';
    import 'bootstrap-fileinput/js/fileinput.min.js';
    // import '../../../public/js/es.js';

    // import 'bootstrap';
    // import 'bootstrap/dist/css/bootstrap.min.css';


    //Boostrap Icons (FileInput Krajee por Defecto los usa)
    import 'bootstrap-icons/font/bootstrap-icons.css';



    //Componentes Vue
    import UploadExcel from '../components/UploadExcel.vue';


    //DataTables JS
    import Datatable from 'vue2-datatable-component'


    export default {
        // props: ['inventarios'],

        components: {
            UploadExcel,
        },

        data() {
            return {
                showScrollRightButton: false,
                showScrollLeftButton: false,
                mostarNuevoDato: false,
                inventarios: [], // Arreglo para almacenar los datos del inventario en la DB
                editing: false ,
                showModal: true,
                nuevoDato: {
                    id: '',
                    codigo_interno: '',
                    referencia_fabrica: '',
                    referencia_articulo: '',
                    serial: '',
                    segemento: '',
                    lineas: '',
                    marca: '',
                    tipo_marca: '',
                    descripcion: '',
                    existencias: '',
                    ubicacion_bodega: '',
                    unidad_medida: '',
                    costo: '',
                    precio_venta: '',
                    usuario: '',
                    contador: '',
                },

            };
        },

        // (created) => Al iniciar el componente haga esto...
        created() {
            this.consultarInventario();
        },

        methods: {


            // Modal para importar Excel con inventario
            openModal() {
            this.showModal = true;
            },
            closeModal() {
                document.getElementById('close-modal').click();
            },


            consultarInventario() {
                axios.get('/inventory')
                    .then(response => {
                    this.inventarios = response.data;

                }).catch(error => {
                    console.error('Error al obtener datos:', error);
                });
            },


            toggleEdit(inventario) {
                inventario.editing = !inventario.editing;
                if (!record.editing) {
                    // Aquí podrías enviar una solicitud para guardar los cambios en el backend
                }
            },
            cancelEdit(inventario) {
                inventario.editing = false; // Restaurar el valor de editing a false
            },


            handleScroll(){
                const container = this.$refs.tableContainer;
                this.showScrollRightButton = container.scrollLeft <= 0;
                this.showScrollLeftButton  = container.scrollLeft > 0;
            },

            scrollTableRight() {
                this.$refs.tableContainer.scrollLeft += 100;
            },

            scrollTableLeft() {
                this.$refs.tableContainer.scrollLeft -= 100; // Ajusta el valor según tu preferencia de desplazamiento
            },

            articuloNuevoFormulario() {
                this.mostarNuevoDato = !this.mostarNuevoDato;

                 // Redirigir al usuario al inicio de la tabla
                 const scrollTopTable = this.$refs.tableFixHead;
                scrollTopTable.scrollTop = 0;

                //Deshabilitar el boton de crear
                this.$refs.btnNuevo.disabled = true;

                // Encontrar el elemento div con la clase tableFixHead y  Redirigir al usuario hasta el elemento.
                const tableFixHead = document.querySelector('.tableFixHead');
                tableFixHead.scrollIntoView({ behavior: 'smooth' });
            },





            alert(){
                alert('esto es un alert');
            },


            // Envia por POST el archivo excel para guardar la info del inventario
            cargarExcel() {
                let formData = new FormData();
                formData.append('excel_inventory', this.$refs.fileInput.files[0]);
                axios.post('inventory/upload', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    setTimeout(() => {
                        this.closeModal();
                        alert('Información cargada con éxito');
                        console.log(response.data);
                        this.consultarInventario();
                    }, 100);
                })
                .catch(error => {
                    alert('Hubo un error en la carga del archivo. Consulte la consola para mas detalles.');
                    console.error(' ---------------- ALERTA ERROR ----------------');
                    console.error(error);
                    console.error(' ----------------------------------------------');
                });
            },

            adjustInputWidth() {
                // Obtener el ancho del contenido del input
                const contentWidth = this.$refs.inputField.scrollWidth;

                // Ajustar la anchura del input
                this.$refs.inputField.style.width = contentWidth + 'px';
            },


            guardarInventario() {

                const inventario = {
                    id:                     this.nuevoDato.id,
                    codigo_interno:         this.nuevoDato.codigo_interno,
                    referencia_fabrica:     this.nuevoDato.referencia_fabrica,
                    referencia_articulo:    this.nuevoDato.referencia_articulo,
                    serial:                 this.nuevoDato.serial,
                    segemento:              this.nuevoDato.segemento,
                    lineas:                 this.nuevoDato.lineas,
                    marca:                  this.nuevoDato.marca,
                    tipo_marca:             this.nuevoDato.tipo_marca,
                    descripcion:            this.nuevoDato.descripcion,
                    existencias:            this.nuevoDato.existencias,
                    ubicacion_bodega:       this.nuevoDato.ubicacion_bodega,
                    unidad_medida:          this.nuevoDato.unidad_medida,
                    costo:                  this.nuevoDato.costo,
                    precio_venta:           this.nuevoDato.precio_venta,
                    usuario:                this.nuevoDato.usuario,
                    contador:               this.nuevoDato.contador,
                }

                alert('Datos de registro nuevo');
                console.log(inventario);

            }



        },
        mounted() {
            this.$refs.tableContainer.addEventListener('scroll', this.handleScroll);

            //Inicializa Fileinput con las opciones personalizadas
            $(this.$refs.inputFile).fileinput({
                language: 'es', // idioma a español
            });

        },
        beforeDestroy() {
            this.$refs.tableContainer.removeEventListener('scroll', this.handleScroll);
        }
    }
  </script>

<style>

    .tableFixHead {
        overflow-y: auto; /* make the table scrollable if height is more than 200 px  */
        height: 60vh; /* gives an initial height of 200px to the table */
    }


    .input-ro{
        border: 1px solid transparent !important;
        background-color: transparent !important;
        /* border-width: 2px !important; */
    }

    .table-container {
        position: relative;
        overflow-x: auto;
    }

    .scroll-button {
        position: absolute;
        z-index: 1;
        cursor: pointer;
        border: none;
        background-color: transparent;
        color: #000;
        font-size: 24px;
    }

    .bottom-right {
        position: absolute;
        top: 60%;
        right: 0;
    }

    .bottom-left {
        position: absolute;
        top: 60%;
        left: 0;
    }

    .table-fixed thead {
      position: sticky;
      top: 0;
      z-index: 999;
      background-color: #fff;
      font-size: '12px';
    }

    .card-body.custom-scroll {
      overflow-x: auto;
      white-space: nowrap;
      scroll-snap-type: x mandatory;
    }

    .sticky-column {
        position: sticky;
        left: 0;
        z-index: 1;
        background-color: #ffffff;
    }

</style>
