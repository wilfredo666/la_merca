// Variable global para el DataTable
var kardexTable;

// Esperar a que el DOM esté listo y kardexTable esté inicializado
$(document).ready(function() {
  // Verificar que estamos en la página correcta
  if ($('#DataTable_KxProducto').length === 0) {
    return;
  }

  // Esperar a que window.kardexTable esté disponible
  function initKardex() {
    if (typeof window.kardexTable === 'undefined' || !window.kardexTable) {
      // Si no está disponible, esperar 100ms e intentar de nuevo
      setTimeout(initKardex, 100);
      return;
    }

    // Obtener API de DataTable directamente (más confiable)
    kardexTable = $('#DataTable_KxProducto').DataTable();

    // Inicializar Select2
    $('.select2').select2({
      theme: 'bootstrap4'
    });

    // Configurar DateRangePicker para Kardex
    $('#daterange-kardex').daterangepicker({
    ranges: {
      'Hoy': [moment(), moment()],
      'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Últimos 7 Días': [moment().subtract(6, 'days'), moment()],
      'Últimos 30 Días': [moment().subtract(29, 'days'), moment()],
      'Este Mes': [moment().startOf('month'), moment().endOf('month')],
      'Mes Pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
      'Este Año': [moment().startOf('year'), moment().endOf('year')]
    },
    startDate: moment().startOf('month'),
    endDate: moment(),
    locale: {
      format: 'DD/MM/YYYY',
      separator: ' - ',
      applyLabel: 'Aplicar',
      cancelLabel: 'Cancelar',
      fromLabel: 'Desde',
      toLabel: 'Hasta',
      customRangeLabel: 'Rango Personalizado',
      weekLabel: 'S',
      daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
      monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      firstDay: 1
    }
  }, function(start, end, label) {
    $('#daterange-kardex span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
    $('#fechaInicialKardex').val(start.format('YYYY-MM-DD'));
    $('#fechaFinalKardex').val(end.format('YYYY-MM-DD'));
  });

  // Inicializar con el mes actual
  $('#fechaInicialKardex').val(moment().startOf('month').format('YYYY-MM-DD'));
  $('#fechaFinalKardex').val(moment().format('YYYY-MM-DD'));
  $('#daterange-kardex span').html(moment().startOf('month').format('DD/MM/YYYY') + ' - ' + moment().format('DD/MM/YYYY'));

  // Botón Filtrar Kardex
  $('#btnFiltrarKardex').click(function() {
    var fechaInicial = $('#fechaInicialKardex').val();
    var fechaFinal = $('#fechaFinalKardex').val();
    var idProducto = $('#filtroProducto').val();
    var tipo = $('#filtroTipo').val();

    // Validar que al menos se hayan seleccionado las fechas
    if (!fechaInicial || !fechaFinal) {
      Swal.fire({
        icon: 'warning',
        title: 'Atención',
        text: 'Por favor seleccione un rango de fechas',
        confirmButtonColor: '#3085d6'
      });
      return;
    }

    // Mostrar loading
    Swal.fire({
      title: 'Cargando...',
      text: 'Generando reporte de kardex',
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      }
    });

    // Realizar petición AJAX
    $.ajax({
      type: "POST",
      url: "controlador/productoControlador.php?ctrReporteKardex",
      data: {
        fechaInicial: fechaInicial,
        fechaFinal: fechaFinal,
        idProducto: idProducto,
        tipo: tipo
      },
      dataType: "json",
      success: function(data) {
        
        Swal.close();
        
        // Verificar que kardexTable esté disponible
        if (typeof kardexTable === 'undefined' || !kardexTable) {
          console.error('❌ kardexTable NO está definido');
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al inicializar la tabla',
            confirmButtonColor: '#d33'
          });
          return;
        }

        // Limpiar tabla
        kardexTable.clear();

        if (data && data.length > 0) {
          // Procesar datos para el kardex
          var saldoAcumulado = 0;
          var valorTotal = 0;

          data.forEach(function(item) {
            // Determinar tipo de movimiento basado en el código de referencia
            var referencia = item.referencia || '';
            var tipoMovimiento = '';
            var entrada = 0;
            var salida = 0;
            
            if (referencia.startsWith('NV')) {
              tipoMovimiento = 'venta';
              salida = parseFloat(item.cantidad);
            } else if (referencia.startsWith('NI')) {
              tipoMovimiento = 'ingreso';
              entrada = parseFloat(item.cantidad);
            } else if (referencia.startsWith('NT')) {
              tipoMovimiento = 'traspaso';
              // Para traspaso, usar el campo tipo de la BD para determinar si es entrada o salida
              var tipoBD = (item.tipo || '').toLowerCase();
              if (tipoBD === 'ingreso') {
                entrada = parseFloat(item.cantidad);
              } else if (tipoBD === 'salida') {
                salida = parseFloat(item.cantidad);
              }
            } else if (referencia.startsWith('NS')) {
              tipoMovimiento = 'salida';
              salida = parseFloat(item.cantidad);
            } else {
              // Si no tiene prefijo reconocido, usar el tipo de la BD
              tipoMovimiento = (item.tipo || '').toLowerCase();
              entrada = (tipoMovimiento === 'ingreso') ? parseFloat(item.cantidad) : 0;
              salida = (tipoMovimiento === 'salida' || tipoMovimiento === 'venta') ? parseFloat(item.cantidad) : 0;
            }
            
            // Calcular saldo acumulado
            saldoAcumulado += entrada - salida;
            
            // Calcular valor total (usar costo de movimiento o precio del producto)
            var precioUnitario = parseFloat(item.costo) || parseFloat(item.precio) || 0;
            valorTotal = saldoAcumulado * precioUnitario;

            // Formatear tipo de movimiento con badge
            var tipoBadge = '';
            switch(tipoMovimiento) {
              case 'ingreso':
                tipoBadge = '<span class="badge badge-success">Ingreso</span>';
                break;
              case 'salida':
                tipoBadge = '<span class="badge badge-danger">Salida</span>';
                break;
              case 'venta':
                tipoBadge = '<span class="badge badge-info">Venta</span>';
                break;
              case 'traspaso':
                tipoBadge = '<span class="badge badge-warning">Traspaso</span>';
                break;
              case 'ajuste':
                tipoBadge = '<span class="badge badge-secondary">Ajuste</span>';
                break;
              default:
                tipoBadge = '<span class="badge badge-dark">' + tipoMovimiento + '</span>';
            }

            // Preparar fila
            var fila = [
              item.create_at,
              item.cod_producto,
              item.nombre_producto,
              tipoBadge,
              entrada > 0 ? entrada: '-',
              salida > 0 ? salida : '-',
              saldoAcumulado,
              precioUnitario.toFixed(2),
              valorTotal.toFixed(2),
              referencia || '-'
            ];

            // Agregar fila a la tabla
            kardexTable.row.add(fila);
          });

          kardexTable.draw();

          Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: 'Se encontraron ' + data.length + ' movimientos',
            timer: 2000,
            showConfirmButton: false
          });

        } else {
          // No hay datos
          $('#tbodyKardex').html(
            '<tr><td colspan="10" class="text-center text-muted">' +
            '<i class="fas fa-exclamation-circle"></i> No se encontraron movimientos con los filtros seleccionados' +
            '</td></tr>'
          );

          Swal.fire({
            icon: 'info',
            title: 'Sin resultados',
            text: 'No se encontraron movimientos con los filtros seleccionados',
            confirmButtonColor: '#3085d6'
          });
        }
      },
      error: function(xhr, status, error) {
        Swal.close();
        console.error("Error:", error);
        console.error("Response:", xhr.responseText);
        
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Ocurrió un error al cargar los datos del kardex',
          confirmButtonColor: '#d33'
        });
      }
    });
  });

  // Botón Limpiar Filtros
  $('#btnLimpiarFiltros').click(function() {
    // Limpiar selects
    $('#filtroProducto').val('').trigger('change');
    $('#filtroTipo').val('').trigger('change');
    
    // Reiniciar fechas al mes actual
    var inicio = moment().startOf('month');
    var fin = moment();
    
    $('#fechaInicialKardex').val(inicio.format('YYYY-MM-DD'));
    $('#fechaFinalKardex').val(fin.format('YYYY-MM-DD'));
    $('#daterange-kardex span').html(inicio.format('DD/MM/YYYY') + ' - ' + fin.format('DD/MM/YYYY'));
    
    // Limpiar tabla
    kardexTable.clear().draw();
    $('#tbodyKardex').html(
      '<tr><td colspan="10" class="text-center text-muted">' +
      '<i class="fas fa-info-circle"></i> Seleccione los filtros y haga clic en "Buscar" para ver los resultados' +
      '</td></tr>'
    );

    Swal.fire({
      icon: 'success',
      title: 'Filtros limpiados',
      text: 'Los filtros han sido restablecidos',
      timer: 1500,
      showConfirmButton: false
    });
  });

  } // Fin de initKardex

  // Iniciar la función
  initKardex();

}); // Fin de document.ready
