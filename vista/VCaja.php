<!-- Content Wrapper. Contains page content -->
<div class='content-wrapper'>
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">

      </div>
    </div><!-- /.container-fluid -->
  </section>

  <section class='content'>
    <!-- Info boxes para resumen de caja -->
    <?php
    $infoCaja = ControladorCaja::ctrInfoCajaChica();
    ?>
    <div class="row">
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-success">
          <span class="info-box-icon"><i class="fas fa-arrow-up"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Ingresos</span>
            <span class="info-box-number">Bs. <?php echo number_format($infoCaja['total_ingresos'] ?? 0, 2); ?></span>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-danger">
          <span class="info-box-icon"><i class="fas fa-arrow-down"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Salidas</span>
            <span class="info-box-number">Bs. <?php echo number_format($infoCaja['total_salidas'] ?? 0, 2); ?></span>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-info">
          <span class="info-box-icon"><i class="fas fa-wallet"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Saldo Actual</span>
            <span class="info-box-number">Bs. <?php echo number_format($infoCaja['saldo_actual'] ?? 0, 2); ?></span>
          </div>
        </div>
      </div>
    </div>

    <h5 class="table-title">
      Gestion de Caja Chica
    </h5>

    <table id='DataTable' class='table table-bordered table-striped'>
      <thead>
        <tr>
          <th>Tipo</th>
          <th>Concepto</th>
          <th>Descripción</th>
          <th>Cantidad</th>
          <th>Usuario</th>
          <th>Fecha</th>
          <th><button type='button' class='btn btn-block btn-primary btn-xs' onclick='MNuevoCaja()'>Nuevo</button></th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Obtener registros de la tabla
        $registros = ControladorCaja::ctrMostrarRegistros();
        foreach ($registros as $value) {
        ?>
        <tr>
          <td>
            <?php if($value["tipo"] == "ingreso"){ ?>
              <span class="badge bg-success">
                <i class="fas fa-arrow-up"></i> Ingreso
              </span>
            <?php } else { ?>
              <span class="badge bg-danger">
                <i class="fas fa-arrow-down"></i> Salida
              </span>
            <?php } ?>
          </td>
          <td><?php echo $value["concepto"]; ?></td>
          <td><?php echo $value["descripcion"] ?? '-'; ?></td>
          <td class="text-right">
            <?php if($value["tipo"] == "ingreso"){ ?>
              <span class="text-success">+Bs. <?php echo number_format($value["cantidad"], 2); ?></span>
            <?php } else { ?>
              <span class="text-danger">-Bs. <?php echo number_format($value["cantidad"], 2); ?></span>
            <?php } ?>
          </td>
          <td><?php echo $value["nombre"] ?? 'N/A'; ?></td>
          <td><?php echo date('d/m/Y H:i', strtotime($value["create_at"])); ?></td>
          <!-- <td>
            <?php if($value["estado_caja"]==1){
            ?>
            <span href="#" class="badge bg-success">
              Activo
            </span>
            <?php
        }else{
            ?>
            <span class="badge bg-danger">Inactivo</span>
            <?php
        }?>
          </td> -->
          <td>
            <div class="btn-group">
              <!-- <button class="btn btn-sm btn-secondary" onclick="MEditCaja(<?php echo $value['id_caja']; ?>)">
                <i class="fas fa-edit"></i>
              </button> -->
              <button class="btn btn-sm btn-danger" onclick="MEliCaja(<?php echo $value['id_caja']; ?>)">
                <i class="fas fa-trash"></i>
              </button>
            </div>
          </td>
        </tr>

        <?php
        }
        ?>

      </tbody>
    </table>

  </section>
</div>