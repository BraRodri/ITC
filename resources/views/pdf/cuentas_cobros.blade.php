<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Pago Cuenta Cobro</title>

        <style>
            body {
                font-size: 14px !important;

            }

            body::before {
                content: ' ';
                display: block;
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                z-index: 1;
                background-image: url('images/logotipo.png');
                background-position: center center;
                background-repeat: no-repeat;
                background-size: contain;
                opacity: 10%;
            }

            .table {
                width: 100%;
                max-width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
            }

            .contenedor-principal{
                margin-top: 5px;
                width: 100%;
                padding: 20px;
            }

            .border_abajo{
                border-bottom: 1px solid #000;
                margin-right: 15px;
            }

            .margin-abajo{
                margin-bottom: 0px;
            }

            .texto-centrado{
                text-align: center !important;
            }

            .table-bordered {
                border: 1px solid;
                border-radius: 10px;
                border-collapse: collapse;
                font-size: 13px;
            }

            .table-bordered>:not(caption)>* {
                border-width: 1px 0;
            }

            .table-bordered>:not(caption)>*>* {
                border-width: 0 1px;
            }

            .table>:not(caption)>*>* {
                padding: 0.5rem 0.5rem;
                border-bottom-width: 1px;
            }

            .table-bordered tbody td {
                border-color: inherit;
                border-style: solid;
                border-width: 0;
                border: 1px solid;
                padding: 3px;
            }

            .table-bordered thead th {
                border-color: inherit;
                border-style: solid;
                border-width: 0;
                border: 1px solid #000;
                padding: 3px;
                color: #fff;
                background-color: #017CC1;
            }
        </style>

    </head>

    <body>

        @php
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        @endphp

        <div style="width: 100%; text-align: center; color: #8DBCD3;">
            <p>
                INSTITUTO TECNICO DE COLOMBIA - CUCUTA - (TECNICO LABORAL EN AUXILIAR EN ENFERMERIA)<br>
                Licencia de Funcionamiento: Res. <strong>2486</strong> de 05/12/2012 y Res. <strong>2002</strong> de 15/09/2014 de la SEMC<br>
                Acuerdo No. <strong>00039</strong> de 22/02/2018 de Minprotección Social y Res. No. <strong>2044</strong> de 31/07/2018 de la SEMC
            </p>
        </div>

        @php
            $fechaComoEntero = strtotime($pago->created_at);
            $dia = date("d", $fechaComoEntero);
            $mes = date("m", $fechaComoEntero);
            $año = date("Y", $fechaComoEntero);
        @endphp

        <div style="margin-bottom: 40px; margin-top: 40px;">
            <p>Cúcuta, {{ $dia }} {{ $meses[date('n')-1] }} de {{ $año }}</p>
        </div>

        <br>

        <div style="text-align: center">
            <span><strong>CUENTA DE COBRO POR SERVICIOS {{ $pago->numero_cuenta_cobro }}</strong></span> <br> <br> <br>
            <span>INSTITUTO TECNICO DE COLOMBIA ITC - CUCUTA "JOSE LEONARDO PUERTO LEON"<br>Nit 13495654-8</span> <br> <br>
            <span>DEBE A:</span>
        </div>

        <div style="margin-top: 30px;">
            <table class="table">
                <tbody>
                    <tr style="border: 1px solid !important;">
                        @php
                            $tipo_c = ($pago->tipo_documento_usuario == 'Cédula de Ciudadania') ? 'C.C.' : $pago->tipo_documento_usuario;
                        @endphp
                        <td width="100%" style="padding: 5px;">
                            <strong>{{ strtoupper($pago->nombre_usuario) }} {{ strtoupper($tipo_c) }} {{ strtoupper($pago->numero_documento_usuario) }}</strong>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table">
                <tbody>
                    <tr style="border-bottom: 1px solid;border-left: 1px solid;border-right: 1px solid;">
                        <td width="33%" style="padding: 5px; border-right: 1px solid;">
                            Fecha Inicio:<br>
                            {{ $pago->fecha_inicio }}
                        </td>
                        <td width="33%" style="padding: 5px; border-right: 1px solid;">
                            Fecha de Terminación: <br>
                            {{ $pago->fecha_terminacion }}
                        </td>
                        <td width="33%" style="padding: 5px;">
                            Cuenta Cobro No. {{ $pago->numero_cuenta_cobro }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table">
                <tbody>
                    <tr style="border-bottom: 1px solid;border-left: 1px solid;border-right: 1px solid;">
                        <td width="100%" style="padding: 5px;">
                            <strong>CONCEPTO:</strong>
                            <p>{{ strtoupper($pago->conceptos) }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table">
                <tbody>
                    <tr style="border-bottom: 1px solid;border-left: 1px solid;border-right: 1px solid;">
                        <td width="20%" style="padding: 5px; border-right: 1px solid;">
                            VALOR
                        </td>
                        <td width="80%" style="padding: 5px;">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td colspan="2" style="border-bottom: 1px solid;">
                                            LETRA: {{ strtoupper($pago->valor_texto) }}
                                        </td>
                                    </tr>
                                    <tr style="">
                                        <td width="50%" style="padding: 5px; border-right: 1px solid;">
                                            EFECTIVO:
                                            <div class="border_abajo">
                                                $ {{ number_format($pago->valor, 0, ",", ".") }}
                                            </div>
                                        </td>
                                        <td width="50%" style="padding: 5px;">
                                            CUENTA (A) No. ______________________ <br>
                                            BANCO: _____________________________ <br>
                                            $ ____________________________________
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            <p>Cordialmente,</p>
        </div>

        <div style="margin-top: 80px;">
            ___________________________________________ <br>
            <p>
                {{ strtoupper($pago->nombre_usuario) }} <br>
                {{ strtoupper($tipo_c) }} {{ strtoupper($pago->numero_documento_usuario) }}
            </p>
        </div>

        <div style="margin-top: 60px;">
            <p>
                ANEXO: <br>
                COPIA DEL RUT <br>
                CERTIFICACIÓN BANCARIA <br>
                PLANILLA Y SOPORTE DE PAGO DE SEGURIDAD SOCIAL DEL MES DE {{ strtoupper($meses[date('n')-1]) }} <br>
                INFORME DE ACTIVIDADES DEL MES DE {{ strtoupper($meses[date('n')-1]) }} DE {{ date('Y') }}
            </p>
        </div>

    </body>

</html>
