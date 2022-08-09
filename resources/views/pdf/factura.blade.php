<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Factura</title>

        <style>
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
                font-size: 15px;
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
                    <td width="30%">
                        <img src="images/logotipo.png" style="width: 80%;">
                    </td>
                    <td width="70%" style="text-align: center;">
                        <h1 style="margin-bottom: -20px;">CÚCUTA</h1>
                        <h3 style="margin-bottom: -15px;">
                            Calle 1 # 5-14 B. Comuneros<br>
                            Cel: 315-6056257
                        </h3>
                        <p>
                            Licencia de Funcionamiento: Resolución No. 2486 de Dic/05/2012 de la Secretaria de Educación de Cúcuta
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table">
            <tbody>
                <tr>
                    <td width="60%" style="padding-top: 10px;">

                        <table class="table">
                            <tbody>
                                <tr >
                                    <td width="20%" style="padding-bottom: 5px;">Fecha:</td>
                                    <td width="80%" style="padding-bottom: 5px;">
                                        <div class="border_abajo">
                                            {{ date("Y-m-d h:i:s a", strtotime($factura->created_at)) }}
                                        </div>
                                    </td>
                                </tr>
                                <tr style="padding-top: 20px;">
                                    <td width="20%" style="padding-bottom: 5px;">Nombres:</td>
                                    <td width="80%" style="padding-bottom: 5px;">
                                        <div class="border_abajo">
                                            @if ($factura->registroServicio)
                                                @if ($factura->registroServicio->estudiante)
                                                    {{ $factura->registroServicio->estudiante->nombres }}
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="10%" style="padding-bottom: 5px;">C.C:</td>
                                    <td width="35%" style="padding-bottom: 5px;">
                                        <div class="border_abajo">
                                            @if ($factura->registroServicio)
                                                @if ($factura->registroServicio->estudiante)
                                                    {{ $factura->registroServicio->estudiante->numero_documento }}
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                    <td width="15%" style="padding-bottom: 5px;">Celular:</td>
                                    <td width="35%" style="padding-bottom: 5px;">
                                        <div class="border_abajo">
                                            @if ($factura->registroServicio)
                                                @if ($factura->registroServicio->estudiante)
                                                    {{ $factura->registroServicio->estudiante->celular }}
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </td>
                    <td width="40%">

                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="30%">
                                        RECIBO DE CAJA
                                    </td>
                                    <td width="70%">
                                        <div style="border: 1px solid; border-radius: 5px; text-align: center;">
                                            <h2 style="color: red;">
                                                N° {{ substr(str_repeat(0, 5).$factura->id, - 5) }}
                                            </h2>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </td>
                </tr>
            </tbody>
        </table>

        <br>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="30%">FECHA</th>
                    <th width="35%">DETALLE</th>
                    <th width="35%">VALOR</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center;">{{ date("Y-m-d h:i:s a", strtotime($factura->created_at)) }}</td>
                    <td style="text-align: center;">
                        {{ $factura->registroServicio->servicio }}
                    </td>
                    <td style="text-align: center;">
                        {{ number_format($factura->valor, 0, ",", ".") }}
                    </td>
                </tr>
                @if (count($factura->abonos) > 0)
                    @foreach ($factura->abonos as $item)
                        @if ($item->estado == 1)
                            <tr>
                                <td style="text-align: center;">{{ date("Y-m-d h:i:s a", strtotime($item->created_at)) }}</td>
                                <td style="text-align: center;">
                                    {{ $item->tipo }}
                                </td>
                                <td style="text-align: center;">
                                    {{ number_format($item->valor, 0, ",", ".") }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
                <tr>
                    <td></td>
                    <td style="text-align: right;">
                        TOTAL $
                    </td>
                    <td style="text-align: center;">
                        {{ number_format($factura->saldo, 0, ",", ".") }}
                    </td>
                </tr>
            </tbody>
        </table>

        <br>

        @if ($factura->con_firma == 0)
            <table class="table">
                <tbody>
                    <tr>
                        <td width="60%">
                            <div style="border: 1px solid; border-radius: 10px; margin-right: 10px; padding: 10px; text-align: center;">
                                <div style="border-bottom: 1px solid; margin-top: 40px; margin-left: 40px; margin-right: 40px;"></div>
                                Firma y Sello
                            </div>
                            <p style="text-align: center">
                                Nota: No se devuelven dineros por ningún motivo. Las mensualidades se deben pagar los 5 primeros dias de cada mes.
                            </p>
                        </td>
                        <td width="40%" style="text-align: center;">
                            ÁREA AUXILIAR EN ENFERMERIA <br>
                            <div style="border: 1px solid; border-radius: 10px; padding: 30px; margin-top: 30px;">

                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            @else
            <table class="table">
                <tbody>
                    <tr>
                        <td width="60%">
                            <div style="border: 1px solid; border-radius: 10px; margin-right: 10px; padding: 10px; text-align: center;">
                                <div style="margin-top: 20px; margin-bottom: 5px;">
                                    @if ($factura->registroServicio)
                                        @if ($factura->registroServicio->estudiante)
                                            {{ $factura->registroServicio->estudiante->nombres }}
                                        @endif
                                    @endif
                                </div>
                                <div style="border-bottom: 1px solid; margin-left: 40px; margin-right: 40px;"></div>
                                Firma y Sello
                            </div>
                            <p style="text-align: center">
                                Nota: No se devuelven dineros por ningún motivo. Las mensualidades se deben pagar los 5 primeros dias de cada mes.
                            </p>
                        </td>
                        <td width="40%" style="text-align: center;">
                            ÁREA AUXILIAR EN ENFERMERIA <br>
                            <div style="border: 1px solid; border-radius: 10px; padding: 10px; margin-top: 30px;">
                                @if ($factura->creador)
                                    {{ $factura->creador->nombres }} <br>
                                    C.C. {{ $factura->creador->numero_documento }}
                                @endif

                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif


    </body>

</html>
