<!DOCTYPE html>
<html>
<head>
	<title>Invitation Receipt</title>
    <!-- <link href="{{ public_path('/css/app.css',2,',','.') }}" rel="stylesheet"> -->
</head>
<body>
    <style>
        * {
            font-family: Tahoma, Geneva, Verdana, sans-serif;
        }
        .table {
            width: 100%;
            border: 1px #999 solid;
        }
        .table thead th {
            text-align: left;
            border-bottom: 1px #999 solid;
            padding: 10px;
            font-weight: bold;
        }
        .table tbody td {
            text-align: left;
            padding: 10px;
        }
    </style>

    <div id="print-receipt" style="width: 700px; margin: auto;">
        <div style="padding: 15px;">
            <div style="padding-bottom: 50px;">
                <table>
                    <tr>
                        <td style="width: 360px; vertical-align: top;">
                            <img 
                                src="{{ $image }}" 
                                alt="{{ $image }}" 
                                style="width: 200px;">
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td style="width: 60px; padding-right: 20px; vertical-align: top;">
                                        <div style="text-align: right;"><b>Dari :</b></div>
                                    </td>
                                    <td>
                                        <div>UNDANGABI</div>
                                        <div>di Tempat</div>
                                    </td>
                                </tr>
                            </table>
                            <table style="margin-top: 30px;">
                                <tr>
                                    <td style="width: 60px; padding-right: 20px;">
                                        <div style="text-align: right;">Tel :</div>
                                    </td>
                                    <td>
                                        <div>+62-8515-5377-009</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 60px; padding-right: 20px;">
                                        <div style="text-align: right;">Email :</div>
                                    </td>
                                    <td>
                                        <div>undangabi.official@gmail.com</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div> 

            <div style="padding-bottom: 50px;">
                <table>
                    <tr>
                        <td style="width: 250px; vertical-align: top;">
                            <table>
                                <tr>
                                    <td style="width: 90px; vertical-align: top;">
                                        <div><b>Kepada :</b></div>
                                    </td>
                                    <td>
                                        <div style="padding-bottom: 5px;">{{ $invitation['invitation']['title'] }}</div>
                                        <div>di Tempat</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="vertical-align: top;">
                           <table>
                                <tr>
                                    <td style="width: 170px; vertical-align: top; padding-bottom: 10px;">
                                        <div style="text-align: right;"><b>No Invoice :</b></div>
                                    </td>
                                    <td>
                                        <div style="padding-left: 20px;">{{ $invitation['invitation']['invitation_id'] }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 170px; vertical-align: top; padding-bottom: 10px;">
                                        <div style="text-align: right;"><b>Tanggal Invoice :</b></div>
                                    </td>
                                    <td>
                                        <div style="padding-left: 20px;">{{ date_format(date_create(now()), "d M Y") }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 170px; vertical-align: top; padding-bottom: 10px;">
                                        <div style="text-align: right;"><b>Batas Waktu :</b></div>
                                    </td>
                                    <td>
                                        <div style="padding-left: 20px;">-</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 170px; vertical-align: top;">
                                        <div style="text-align: right;"><b>Status :</b></div>
                                    </td>
                                    <td>
                                        <div style="padding-left: 20px;">
                                            {{ $invitation['invitation']['payment_status'] ? 'Paid' : 'Unpaid' }}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div> 

            <div style="padding-bottom: 50px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Deskripsi</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Undangan</td>
                            <td>{{ $invitation['invitation']['type'] }}<br>{{ $invitation['theme']['name'] }}</td>
                            <td>1</td>
                            <td>
                                Rp. {{ number_format($invitation['invitation']['price'],2,',','.') }}
                            </td>
                            <td>
                                Rp. {{ number_format($invitation['invitation']['price'],2,',','.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="width: 340px; float: right;">
                <table style="padding-bottom: 15px;">
                    <tr>
                        <td style="width: 100px; padding-right: 20px; vertical-align: top; padding-bottom: 10px;">
                            <div style="text-align: right;"><b>Jumlah :</b></div>
                        </td>
                        <td style="vertical-align: top;">
                            Rp. {{ number_format($invitation['invitation']['price'],2,',','.') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 100px; padding-right: 20px; vertical-align: top;">
                            <div style="text-align: right;"><b>Discount :</b></div>
                        </td>
                        <td style="vertical-align: top;">
                            Rp. {{ number_format($invitation['invitation']['discount'],2,',','.') }}
                        </td>
                    </tr>
                </table>

                <table>
                    <tr>
                        <td style="width: 100px; padding-right: 20px; vertical-align: top;">
                            <div style="text-align: right; font-size: 16pt;"><b>Total :</b></div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="font-size: 16pt;"><b>Rp. {{ number_format($invitation['invitation']['total_price'],2,',','.') }}</b></div>
                        </td>
                    </tr>
                </table>
            </div> 

        </div>
    </div>
</body>
</html>