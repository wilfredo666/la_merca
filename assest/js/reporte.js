var etiquetaX=[]
var etiquetaY=[]

$('#dataCancelPicker').on('click', function () {
  $('#daterange-btn span').html('<i class="far fa-calendar-alt"></i> Rango de fecha');
});
//Date range as a button
$('#daterange-btn').daterangepicker(
  {
    ranges   : {
      'Hoy'       : [moment(), moment()],
      'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Ultimos 7 Dias' : [moment().subtract(6, 'days'), moment()],
      'Ultimos 30 Dias': [moment().subtract(29, 'days'), moment()],
      'Este Mes'  : [moment().startOf('month'), moment().endOf('month')],
      'El Mes Pasado'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment().subtract(29, 'days'),
    endDate  : moment()
  },
  function (start, end) {
    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
    
    var fechaInicial = start.format('YYYY-MM-DD')
    var fechaFinal = end.format('YYYY-MM-DD')
    
    var obj={
      inicio:fechaInicial,
      final:fechaFinal
    }
    
    $.ajax({
      type:"POST",
      url:"controlador/facturaControlador.php?ctrReporteVentas",
      data:obj,
      dataType:"json",
      success:function(data){
        
        for(var i=0; i<data.length; i++) {
          let year= data[i]["fecha_emision"].split(" ")
          
          etiquetaX.push(year[0])
          etiquetaY.push(data[i]["total"])
        }
        
        graficoVentas(etiquetaX, etiquetaY)
      }
    })
    
  }
) 

function graficoVentas(etiquetaX, etiquetaY){
  // Sales graph chart
var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d')
// $('#revenue-chart').get(0).getContext('2d');

var salesGraphChartData = {
  labels: etiquetaX,
  datasets: [
    {
      label: 'Digital Goods',
      fill: false,
      borderWidth: 2,
      lineTension: 0,
      spanGaps: true,
      borderColor: '#efefef',
      pointRadius: 3,
      pointHoverRadius: 7,
      pointColor: '#efefef',
      pointBackgroundColor: '#1a1111',
      data: etiquetaY
    }
  ]
}

var salesGraphChartOptions = {
  maintainAspectRatio: false,
  responsive: true,
  legend: {
    display: false
  },
  scales: {
    xAxes: [{
      ticks: {
        fontColor: '#efefef'
      },
      gridLines: {
        display: false,
        color: '#efefef',
        drawBorder: false
      }
    }],
    yAxes: [{
      ticks: {
        stepSize: 5000,
        fontColor: '#efefef'
      },
      gridLines: {
        display: true,
        color: '#efefef',
        drawBorder: false
      }
    }]
  }
}

// This will get the first returned node in the jQuery collection.
// eslint-disable-next-line no-unused-vars
var salesGraphChart = new Chart(salesGraphChartCanvas, { // lgtm[js/unused-local-variable]
  type: 'line',
  data: salesGraphChartData,
  options: salesGraphChartOptions
})

}
