<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Pago Prestación de Servicios</title>

        <style>
            body {
                font-size: 13px !important;
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

        <table class="table">
            <tbody>
                <tr>
                    <td width="30%" style="text-align: center;">
                        <img src="images/logotipo.png" style="width: 60%;">
                        <p>
                            NIT: 13495654-8 <br>
                            JOSÉ LEONARDO PUERTO LEÓN
                        </p>
                    </td>
                    <td width="40%" style="text-align: center; padding-right: 10px;">
                        <h3 style="margin-bottom: -5px;">INSTITUTO TÉCNICO DE COLOMBIA</h3>
                        <p>
                            Lic Func: Res 2486 de Dic 5/2012 de la SEMC <br>
                            Calle 6 AN 19A-16 Barrio Comuneros. <br>
                            Cúcuta - Colombia
                            315 605 6257 <br>
                            E-mail: itc.ae.cucuta@outlook.com
                        </p>
                    </td>
                    <td width="30%" style="text-align: center;">
                        <p>
                            <strong>
                                Documento Soporte en adquisiciones efectuadas no obligadas a facturar.
                            </strong>
                        </p>
                        <div style="border: 1px solid; border-radius: 5px; text-align: center; padding: -100px !important;">
                            <h2 style="color: red">
                                N° <span style="color: #000 !important;">JA</span> {{ $pago->id }}
                            </h2>
                        </div>
                        <div style="margin-top: 10px; text-align: start !important;">
                            <span>
                                Fecha de emisión:
                            </span>
                            <table class="table table-bordered">
                                @php
                                    $fechaComoEntero = strtotime($pago->fecha_emision);
                                    $dia = date("d", $fechaComoEntero);
                                    $mes = date("m", $fechaComoEntero);
                                    $año = date("Y", $fechaComoEntero);
                                @endphp
                                <tr>
                                    <td>{{ $dia }}</td>
                                    <td>{{ $mes }}</td>
                                    <td>{{ $año }}</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table">
            <tbody>
                <tr style="border: 1px solid !important;">
                    <td width="25%" style="padding-bottom: 5px; padding-left: 10px;"><strong>Nombre / Denominación:</strong></td>
                    <td width="75%" style="padding-bottom: 5px;">
                        {{ $pago->nombre_usuario }}
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table">
            <tbody>
                <tr style="border-left: 1px solid; border-right: 1px solid; border-bottom: 1px solid;">
                    <td width="40%" style="border-right: 1px solid;">
                        <table class="table" style="padding-left: 10px;">
                            <tbody>
                                <tr>
                                    <td width="25%" style=""><strong>Nit / C.C:</strong></td>
                                    <td width="75%" style="">
                                        {{ $pago->numero_documento_usuario }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td width="60%">
                        <table class="table" style="padding-left: 10px;">
                            <tbody>
                                <tr>
                                    <td width="20%" style=""><strong>Domicilio:</strong></td>
                                    <td width="80%" style="">
                                        {{ $pago->domicilio_usuario }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table">
            <tbody>
                <tr>
                    <td width="70%">
                        <p><strong>La cantidad de:</strong></p>
                        <div style="border: 1px solid; padding: 3px 10px; margin-top: -10px;">
                            {{ $pago->valor_texto }}
                        </div>
                    </td>
                    <td width="30%">
                        <p><strong>Valor:</strong></p>
                        <div style="border: 1px solid; padding: 3px 10px; margin-top: -10px; margin-left: -3px;">
                            $ {{ number_format($pago->valor, 0, ",", ".") }}
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table">
            <tbody>
                <tr>
                    <td width="50%">
                        <p><strong>Por concepto de:</strong></p>
                        <div style="border: 1px solid; padding: 3px 10px; margin-top: -10px; height: 70px;">
                            {{ $pago->conceptos }}
                        </div>
                    </td>
                    <td width="50%">
                        <p><strong>Observaciones:</strong></p>
                        <div style="border: 1px solid; padding: 3px 10px; margin-top: -10px; margin-left: -3px; height: 70px;">
                            {{ $pago->observaciones }}
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table">
            <tbody>
                <tr>
                    <td width="50%" style="text-align: center">
                        <p style="font-size: 12px;">
                            <strong>
                                RANGO AUTORIZADO: JA 1 AL JA 5000 / FECHA 2022-04-20<br>
                                RESOLUCIÓN DE HABILITACIÓN DIAN N° 001876402793759-9<br>
                                VIGENCIA 6 MESES
                            </strong>
                        </p>
                    </td>
                    <td width="50%" style="padding-left: 10px;">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="25%" style="padding-bottom: 5px;">Recibimos de:</td>
                                    <td width="75%" style="padding-bottom: 5px;">
                                        <div class="border_abajo">
                                            _
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table" style="margin-top: 5px;">
                            <tbody>
                                <tr>
                                    <td width="15%" style="padding-bottom: 5px;">Firma:</td>
                                    <td width="85%" style="padding-bottom: 5px;">
                                        <div class="border_abajo">
                                            _
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

    </body>

</html>
