<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panjar</title>
    <style>
        .card {
            background-color: #FFF;
            height: auto;
            width: auto;
            border: 2px solid black;
        }

        .card h2 {
            text-align: center;
        }

        .card .date {
            display: flex;
            justify-content: flex-start;
        }

        .date div {
            width: auto;
            height: auto;
        }

        .tb tr,
        .tb td,
        .tb th {
            border: 1px solid #000;
            border-collapse: collapse;
        }

        .tb {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="card">
        <h2>PT BENECOM TRICOM<br>FORM PANJAR</h2>

        <div class="date">
            <div style="background-color:#FFF;height:30px">
                <table style="margin-left: 180px;">
                    <tr>
                        <td>No</td>
                        <td>:</td>
                        <td><?= $remarks->bk ?></td>
                    </tr>
                    <tr>
                        <td>Tgl</td>
                        <td>:</td>
                        <td><?= $remarks->tanggal_request ?></td>
                    </tr>
                </table>
            </div>
            <div style="background-color:#FFF;border:2px solid #000">
                <table style="padding: 10px;">
                    <tr>
                        <td style="padding: 10px;">Keterangan</td>
                        <td>:</td>
                        <td>................</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;">Jumlah</td>
                        <td>:</td>
                        <td>................</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px;">Terbilang</td>
                        <td>:</td>
                        <td>................</td>
                    </tr>
                </table>
            </div>
            <div style="background-color:#FFF;margin-top:10px">
                <table class="tb" style="padding: 10px;border:1px solid #000;border-collapse:collapse;margin-left:170px;height:300px">
                    <tr>
                        <th>Manager</th>
                        <th>Finance</th>
                        <th>Received</th>
                    </tr>
                    <tbody>
                        <tr>
                            <td><img height="60px" width="60px" src="./assets/ttd/tanda.png" alt=""></td>
                            <td><img height="60px" width="60px" src="./assets/ttd/tanda.png" alt=""></td>
                            <td><img height="60px" width="60px" src="./assets/ttd/tanda.png" alt=""></td>
                        </tr>
                        <tr>
                            <td>Dasep Depiyawan</td>
                            <td>Dasep Depiyawan</td>
                            <td>Dasep Depiyawan</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="background-color:#FFF;font-size:10px">
                <label for="">Note :</label><br>
                <label for="">Lembar 1 : Untuk Finance</label><br>
                <label for="">Lembar 2 : Untuk Received & saat pertanggungjawaban mohon dilampirkan</label>
            </div>

        </div>
    </div>
</body>

</html>