<?php 

/*
░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
░░≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡
░░      TABLA DE AMORTIZACION MENSUAL                                                
░░              CREDITOS SIMPLES
░░≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡≡                       
░░                                                                               
░░   -> AUTOR: DANIEL RIVERA                                                               
░░   -> PHP 8.1, JAVASCRIPT, JQUERY                       
░░   -> GITHUB: (danielrivera03)                                             
░░       https://github.com/DanielRivera03                              
░░   -> TODOS LOS DERECHOS RESERVADOS                           
░░       © 2023   
░░                                                      
░░   -> POR FAVOR TOMAR EN CUENTA TODOS LOS COMENTARIOS
░░      Y REALIZAR LOS AJUSTES PERTINENTES ANTES DE INICIAR
░░
░░      ♥♥ HECHO CON ALGUNAS TAZAS DE CAFE ♥♥
░░                                                                               
░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░

*/ 

    


    $ContadorDomingos = 0; // INICIALIZACION CONTADOR DE DOMINGOS
    // RECEPCION DE DATOS
    $NombreClientes = (empty($_POST['val-nombrecliente'])) ? NULL : $_POST['val-nombrecliente'];
    $MontoFinanciamiento = (empty($_POST['val-montofinanciamiento'])) ? NULL : $_POST['val-montofinanciamiento'];
    $FechaSolicitudInicial = (empty($_POST['val-fechainiciocreditos'])) ? NULL : $_POST['val-fechainiciocreditos'];
    $FechaSolicitudFinal = (empty($_POST['val-fechacreditos'])) ? NULL : $_POST['val-fechacreditos'];
    $TasaInteres = (empty($_POST['val-tasainteres'])) ? NULL : $_POST['val-tasainteres'];
    $UrlGlobal = "http://" . $_SERVER['SERVER_NAME'] . ":90" . "/TablaAmortizacionDiaria" . '/';
    // CALCULO DIAS CREDITO
    $FechaInicioCreditos = new DateTime($FechaSolicitudInicial);
    $FechaFinalizacionCreditos = new DateTime($FechaSolicitudFinal);
    $ContadorDiasCreditos = $FechaInicioCreditos->diff($FechaFinalizacionCreditos);

    // NO PERMITIR VISTA SI DATOS NO HAN SIDO PROCESADOS EN FORMULARIO
    if(empty($NombreClientes))
        header('location:index.php');

    // CALCULAR CUANTOS DOMINGOS EXISTEN EN LAS DOS FECHAS ESTIPULADAS
    function CalcularCantidadDomingos($FechaSolicitud, $ConversionFechaFin) {
        $Domingos = 0;
        $PeriodoCalculoDomingos = new DatePeriod(
        new DateTime($FechaSolicitud),
        new DateInterval('P1D'),
        new DateTime($ConversionFechaFin)
        );
        foreach ($PeriodoCalculoDomingos as $Fecha) {
        if ($Fecha->format('N') == 7) 
            $Domingos++;
        }
        return $Domingos;
    }

    $FinCreditos = $FechaSolicitudFinal; // CALCULO FINAL DE ESTADO DE CUENTA CLIENTES
    $ConversionFechaFin = $FinCreditos; // CONVERSION FECHA FINAL DE CREDITOS YYYY-MM-DD
    $Domingos = CalcularCantidadDomingos($FechaSolicitudInicial, $ConversionFechaFin);

    // CALCULAR EL TOTAL DE CUOTAS SIN INCLUIR LOS DOMINGOS
    function TotalCuotas($FechaSolicitud, $ConversionFechaFin) {
        $TotalCuotas = 0;
        $PeriodoCalculoCuotas = new DatePeriod(
        new DateTime($FechaSolicitud),
        new DateInterval('P1D'),
        new DateTime($ConversionFechaFin)
        );
        foreach ($PeriodoCalculoCuotas as $Fecha) {
        if ($Fecha->format('N') >= 1 && $Fecha->format('N') <= 6) 
            $TotalCuotas++;
        }
        return $TotalCuotas; // -> + 1 POR EL MOTIVO DE INICIALIZAR EN CERO EL CALCULO DE LAS CUOTAS 
    }
    
    $TotalCuotas = TotalCuotas($FechaSolicitudInicial, $ConversionFechaFin);
    // CALCULO MESES CREDITO -> CONVERSION N DIAS A N MESES
    $ConversionMeses = Round($TotalCuotas / 30.417,1);
    $FechaCompleta = strtotime($FechaSolicitudInicial); // OBTENER FECHA COMPLETA
    $ObtenerDia = date("d", $FechaCompleta); // OBTENER UNICAMENTE DIA

    // -> CALCULO CUOTAS CREDITOS CLIENTES
    $SaldoInicialCredito = $MontoFinanciamiento; // SALDO INICIAL DE CREDITO
    $CalculoCapital = $MontoFinanciamiento / $TotalCuotas; // CALCULO CAPITAL
    // CALCULO DE CUOTA DIARIA FINAL
    $CalculoCuotaMensualCapital = ($MontoFinanciamiento/$TotalCuotas +($MontoFinanciamiento/$TotalCuotas)*$TasaInteres/100)*.13+($MontoFinanciamiento/$TotalCuotas+($MontoFinanciamiento/$TotalCuotas)*$TasaInteres/100);


    // -> $TOTALCUOTAS = NUMERO DE CUOTAS FINAL CALCULADO SIN INCLUIR LOS DOMINGOS

?>
        <style>
            .aviso_clientes {
                display: none;
                text-align: justify;
            }

            @media print {
                @page {
                    size: auto;
                    margin: 0mm;
                }

                #aviso_empleados,
                #impresion_solicitud,
                #registro_solicitud {
                    display: none;
                }

                .aviso_clientes {
                    display: block;
                }
            }
        </style>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>CashMan H.A. | Estado Cuenta Cr&eacute;ditos Clientes </title>
        <!-- Favicon icon -->
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $UrlGlobal; ?>images/apple-icon-57x57.png">
            <link rel="apple-touch-icon" sizes="60x60" href="<?php echo $UrlGlobal; ?>images/apple-icon-60x60.png">
            <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $UrlGlobal; ?>images/apple-icon-72x72.png">
            <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $UrlGlobal; ?>images/apple-icon-76x76.png">
            <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $UrlGlobal; ?>images/apple-icon-114x114.png">
            <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $UrlGlobal; ?>images/apple-icon-120x120.png">
            <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $UrlGlobal; ?>images/apple-icon-144x144.png">
            <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $UrlGlobal; ?>images/apple-icon-152x152.png">
            <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $UrlGlobal; ?>images/apple-icon-180x180.png">
            <link rel="icon" type="image/png" sizes="192x192" href="<?php echo $UrlGlobal; ?>images/android-icon-192x192.png">
            <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $UrlGlobal; ?>images/favicon-32x32.png">
            <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $UrlGlobal; ?>images/favicon-96x96.png">
            <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $UrlGlobal; ?>images/favicon-16x16.png">
            <link rel="manifest" href="<?php echo $UrlGlobal; ?>images/manifest.json">
            <meta name="msapplication-TileColor" content="#ffffff">
            <meta name="msapplication-TileImage" content="<?php echo $UrlGlobal; ?>images/ms-icon-144x144.png">
            <meta name="theme-color" content="#ffffff">
        <div class="progress ">
            <div class="progress-bar bg-warning progress-animated" style="width: 100%; height:15px;" role="progressbar"></div>
        </div>
        <?php
        // DATOS DE LOCALIZACION -> IDIOMA ESPAÑOL -> ZONA HORARIA EL SALVADOR (UTC-6)
        setlocale(LC_TIME, "spanish");
        date_default_timezone_set('America/El_Salvador');
        
        echo '
        <link href="';
        echo $UrlGlobal;
        echo 'css/style.css" rel="stylesheet">
        <div class="table-responsive">
        <table style="width: 95%; margin: auto; padding: 1rem 0 0 0;"  cellpadding="5">
	<tr>
	<td width="65%"><br><br>
        <img style="width: 50px;" src="';
        echo $UrlGlobal;
        echo 'images/logo.png"><img style="margin: 0 0 0 .5rem; width: 110px;" src="';
        echo $UrlGlobal;
        echo 'images/logo-text.png"><br><br>
	    <b><i style="font-size: .8rem" class="fa fa-university"></i> ESTADO DE CUENTA GENERADO';
        echo '</b><br />
        <i style="font-size: .8rem" class="fa fa-info-circle"></i> Cliente : ';
        echo $NombreClientes;
        echo ' ';
        echo '
    <br><i style="font-size: .8rem" class="fa fa-hourglass-half"></i> Plazo: ';
        echo $TotalCuotas. " (Cuotas / D&iacute;as) / ".$ConversionMeses." meses";
        echo ' 
    <br><i style="font-size: .8rem" class="fa fa-calendar"></i> D&iacute;as Calculados: ';
        echo "".$ContadorDiasCreditos->days. " d&iacute;as.";
        echo ' 
    <br><i style="font-size: .8rem" class="fa fa-bell"></i> Domingos Exclu&iacute;dos: ';
        echo "".$Domingos. " domingos.";
        echo ' 
	</td>
	<td width="35%">         
	<i style="font-size: .8rem" class="fa fa-balance-scale"></i> C&oacute;digo No. : ';
        echo 1;
        echo '<br />
    <i style="font-size: .8rem" class="fa fa-line-chart"></i> Tasa Inter&eacute;s Diaria : ';
        echo $TasaInteres;
        echo '%<br />
	<i style="font-size: .8rem" class="fa fa-calendar-check-o"></i> Emisi&oacute;n : ';
        echo date('Y-m-d H:i:s');
        echo '<br />
	</td>
	</tr>
	</table><br><br>
    <article style="width: 95%; margin: auto; display: block;">';
        echo '
        
        <article style="width: 95%; margin: auto; display: flex; justify-content: center;">
        <form method="post">
            <a href="javascript:window.print()"><button id="impresion_solicitud" style="margin: .5rem;" type="button" class="btn btn-rounded btn-dark"><span class="btn-icon-left text-dark"><i class="fa fa-print color-dark"></i></span>Imprimir Estado de Cuenta</button></a>
        </form>
        </article>
    </article><br>
            <table style="width: 95%; margin: auto;" class="table table-striped table-responsive-sm table-hover">
                <thead style="background: #474787; color: #fff;">
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Estado</th>
                        <th>&Uacute;ltima Fecha de Pago</th>
                        <th>Cuota Diaria</th>
                        <th>Capital</th>
                        <th>Saldo Final</th>
                    </tr>
                </thead>
            <tbody>';

        // FECHA INICIO DE CREDITO -> SEGUN INGRESO DE SOLICITUD CREDITICIA
        // FORMATO FECHA DE REGISTRO -> AÑO/MES/DIA = YYYY/MM/DD
        // FORMATO FECHA DE MUESTRA CLIENTES -> DIA/MES/AÑO = DD/MM/YYYY
        $IntervaloFecha = new DateInterval('P1D'); // INTERVALO 1 DIA A LA VEZ -> EN UN SOLO MES
        $InicioCreditos = date_create($FechaSolicitudInicial); // ASIGNAR INICIO DE CALCULO ESTADO DE CUENTE CLIENTES
        $CuotasMensualesGeneradas = new DatePeriod($InicioCreditos, $IntervaloFecha, $TotalCuotas+$Domingos); // GENERAR EL CALCULO SEGUN EL PERIODO ASIGNADO AL CLIENTE

        // EXTRAER FECHA COMPLETA COMO ENTERO PARA COMPROBACIONES
        $ExtraerFecha = strtotime($FechaSolicitudInicial);
        $ObtenerMes = date("m", $ExtraerFecha); // OBTENER MES EN CUESTION DE SOLICITUD DE CREDITO
        $ObtenerDia = date("d", $ExtraerFecha); // OBTENER DIA EN CUESTION DE SOLICITUD DE CREDITO
        $ContadorCuotas = 0; // INICIALIZAR CONTADOR DE CUOTAS ASIGNADAS

            foreach ($CuotasMensualesGeneradas as $DiaAsignado) {
                $DiaLaboral = $DiaAsignado->format('N'); // OBTENER EL NUMERO DE DIAS DE LA SEMANA EN FORMATO NUMERICO ENTERO [LUNES A DOMINGO --> 1 - 7 RESPECTIVAMENTE]

                // SOLAMENTE TOMAR EN CUENTA DE LUNES A SABADO -> EXCLUYENDO DOMINGOS
                if($DiaLaboral>=1 && $DiaLaboral<=6){
                    $ContadorCuotas++; // AUMENTO EN 1 SEGUN EL RANGO A CUMPLIR -> "N" CUOTAS
                    echo '
                    <tr>
                        <th>';
                    echo $ContadorCuotas;
                    echo '</th>
                            <td>';
                    echo "Pr&eacute;stamos Personales";
                    echo '</td>
                            <td>';
                    if ($ContadorCuotas == 1) {
                        echo '<span class="badge badge-primary">N/D</span>';
                    } else {
                        echo '<span class="badge badge-danger">Pendiente</span>';
                    }
                    echo '
                            </td>
                        <td>';

                    if ($ContadorCuotas == 1) {
                        echo '------------------------';
                    } else {
                        
                        // SOLO IMPRIMIR FECHAS DE LUNES A SABADO -> EXCLUYENDO DOMINGOS
                        if ($DiaLaboral >=1 && $DiaLaboral<=6) 
                            echo $DiaAsignado->format('d-m-Y');
                        echo PHP_EOL;
                    }
                    // CALCULO CUOTA DIARIA
                    echo '
                    </td>
                        <td class="color-primary">$';
                    if ($ContadorCuotas == 1) {
                        echo "0.00";
                    } else {
                        echo number_format($CalculoCuotaMensualCapital, 2);
                    }
                    echo ' USD</td>
                    </td>
                        <td class="color-primary">$';
                    // CALCULO DE CAPITAL
                    if ($ContadorCuotas == 1) {
                        echo "0.00";
                    } else {
                        echo number_format($CalculoCapital, 2);
                    }
                    echo ' USD</td> 
                        <td class="color-primary">$';
                    // CALCULO SALDO FINAL
                    if ($ContadorCuotas == 1) {
                        echo number_format($SaldoInicialCredito, 2);
                    } else {
                        $SaldoInicialCredito = $SaldoInicialCredito - $CalculoCapital;
                        echo number_format($SaldoInicialCredito, 2);
                    }
                    echo ' USD</td>
                    </tr>
                ';
                }

                 
                }
                echo '
                    </tbody>
                </table>
            </div>';   
                
        ?>
                    </tbody>
                </table>
            </div>
        

            <script src="<?php echo $UrlGlobal; ?>js/global.min.js"></script>
            <?php //} ?>

